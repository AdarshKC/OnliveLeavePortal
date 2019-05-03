<?php

$ret = array();
$status = 0;
if(!isset($_POST['month']) || !isset($_POST['year']) || !isset($_POST['day']) || !isset($_POST['eid']))
{
	$status = 400;
}
if($status!=400){
	function get_date($month, $year, $day){
		return ($year ."-". ($month<=9?"0":""). $month ."-". ($day<=9?"0":""). $day);
	}

	$month_ = intval($_POST["month"]);
	$year_ = intval($_POST["year"]);
	$day_ = intval($_POST["day"]);
	$eid = $_POST["eid"];
	// $month_ = 4;
	// $year_ = 2019;
	// $day_ = 16;

	include_once('../includes/config.php');
	include_once('../util/leave.php');
	$range = "'". get_date($month_, $year_, 1) ."' AND '".get_date($month_, $year_, 31)."'";
		
	$sql = "SELECT * from list_holidays WHERE from_date BETWEEN ".$range;
	$query = $dbh -> prepare($sql);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    		
	$holidays_fetched = array();
    $holidays_fetched['data'] = array();
    $holidays_fetched['days'] = array();
    
    foreach ($results as $result) {
    	$holidays_fetched['data'][$result->name] = intval(date("d", strtotime($result->from_date)));
    	$holidays_fetched["days"][]	 = intval(date("d", strtotime($result->from_date)));
    }

    $sql = "SELECT * from tblleaves WHERE (FromDate BETWEEN ".$range.") OR (ToDate BETWEEN ". $range . ") AND empid=".$eid." AND status IN (0,1)";
	$query = $dbh -> prepare($sql);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    		
	$leaves_fetched = array();
     
    foreach ($results as $result) {
    	$leaves = array();
    	$leaves['type'] = $result->LeaveType;
    	$leaves['description'] = $result->Description;
    	$leaves['count'] = $result->count;
    	$leaves['posting_date'] = $result->PostingDate;
    	$leaves['status'] = $result->Status;
    	$leaves['from'] = $result->FromDate;
    	$leaves["to"] = $result->ToDate;

    	$leaves_fetched[] = $leaves;
    }

    /* draws a calendar */
	function draw_calendar($month,$year,$day, $holidays_fetched, $leaves_fetched){
		/* draw table */
		$calendar= "<div class=\"row no-gutters calendar justify-content-start\">";

		/* table headings */
		$headings = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat");
		$useragent=$_SERVER["HTTP_USER_AGENT"];

		if(preg_match("/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i",$useragent)||preg_match("/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i",substr($useragent,0,4))){
			$headings = array("S","M","T","W","T","F","S");
		}
		$calendar.= "<div class=\"col border rounded border-primary calendar-row\">".implode("</div><div class=\"col border border-primary rounded calendar-row\">",$headings)."</div>";

		/* days and weeks vars now ... */
		$running_day = date("w",mktime(0,0,0,$month,1,$year));
		$days_in_month = date("t",mktime(0,0,0,$month,1,$year));
		$days_in_this_week = 1;
		$day_counter = 0;
		$dates_array = array();

		/* row for week one */
		$calendar.= "<div class=\"w-100\"></div>";

		/* print \"blank\" days until the first of the current week */
		for($x = 0; $x < $running_day; $x++):
			$calendar.= "<div class=\"col rounded border border-dark calendar-day-np\"> </div>";
			$days_in_this_week++;
		endfor;

		$holidays = $holidays_fetched;	

		$leave_going=0;

		/* keep going with days.... */
		for($list_day = 1; $list_day <= $days_in_month; $list_day++):
			$flag = 0;
			if($list_day==$day){
				$calendar.= "<div id=\"".$list_day."\" class=\"col rounded border border-dark calendar-day day-selected-def";	
			} else {
				$calendar.= "<div id=\"".$list_day."\" class=\"col rounded border border-dark calendar-day";
			}

			if($leave_going==1){
				if(strtotime(get_date($month, $year, $list_day))>$leave_going_to){
					$leave_going = 0;
					foreach ($leaves_fetched as $key=>$leave) {
						if(strtotime(get_date($month, $year, $list_day))>=strtotime($leave['from']) && strtotime(get_date($month, $year, $list_day))<=strtotime($leave['to'])){
							$leave_going = 1;
							$leave_going_to = strtotime($leave['to']);
							$leave_going_index = $key;
						}
					}
				} 
			} else {
				foreach ($leaves_fetched as $key=>$leave) {
					if(strtotime(get_date($month, $year, $list_day))>=strtotime($leave['from']) && strtotime(get_date($month, $year, $list_day))<=strtotime($leave['to'])){
						$leave_going = 1;
						$leave_going_to = strtotime($leave['to']);
						$leave_going_index = $key;
					}
				}
			}

			if($leave_going==1) {
				$calendar.= " leave";
				if($leaves_fetched[$leave_going_index]['status']==1){
					$calendar.= "-accepted";
				}
				$flag=1;
			} 

			if ( in_array($list_day, $holidays['days']) ) {
				$calendar.= " holiday\" data-name=\"".array_search($list_day,$holidays['data']);
			} elseif ( $running_day==0 || $running_day==6 ) {
				$calendar.= " weekend";
			} 

			if($leave_going==1 && $flag==1) {
				$calendar.= "\" data-leaveIndx=\"".($leave_going_index+1);
			} 

			$calendar.= "\">";
			/* add in the day number */
			//$calendar.= "<div class=\"day-number\">".$list_day."</div>";
			$calendar.= $list_day;
			/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
			
			$calendar.= "</div>";
			if($running_day == 6):
				$calendar.= "<div class=\"w-100\"></div>";
				// if(($day_counter+1) != $days_in_month):
				// 	$calendar.= "<div class=\"col calendar-row\">";
				//endif;
				$running_day = -1;
				$days_in_this_week = 0;
			endif;
			$days_in_this_week++; $running_day++; $day_counter++;
		endfor;

		/* finish the rest of the days in the week */
		if($days_in_this_week < 8):
			for($x = 1; $x <= (8 - $days_in_this_week); $x++):
				$calendar.= "<div class=\"col rounded border border-dark calendar-day-np\"> </div>";
			endfor;
		endif;

		/* final row */
		$calendar.= "<div class=\"w-100\"></div>";

		/* end the table */
		$calendar.= "</div>";
		
		/* all done, return result */
		return $calendar;
	}

	if($toLoad = draw_calendar($month_, $year_, $day_, $holidays_fetched, $leaves_fetched)){
		$status = 200;
	}

}

if($status==200){
	$ret["ToLoad"] = $toLoad;	
	$ret["holidays"] = $holidays_fetched;
	$ret["leaves"] = $leaves_fetched;
}
$ret["status"] = $status;

echo json_encode($ret);
?>