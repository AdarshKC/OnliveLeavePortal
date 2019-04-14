<?php
session_start();
error_reporting(0);
include_once('../includes/config.php');
include_once('../util/leave.php');
if(strlen($_SESSION['emplogin'])==0)
{   
    header('location:index.php');
} else {
	if(isset($_POST['decrement'])){
		$date = $_POST['decrement']."-01";
		$date = strtotime('-1 month', strtotime($date));
		$date = date("Y-m-d", $date);
		$arr = explode("-", $date);
		$month = $arr[1];
		$year = $arr[0];
		$day = 0;
		if($month==date('m') && $year==date('Y')){
			$day = date('d');
		}
	} elseif (isset($_POST['increment'])) {
		$date = $_POST['increment']."-01";
		$date = strtotime('+1 month', strtotime($date));
		$date = date("Y-m-d", $date);
		$arr = explode("-", $date);
		$month = $arr[1];
		$year = $arr[0];
		$day = 0;
		if($month==date('m') && $year==date('Y')){
			$day = date('d');
		}
	} else {
		$month = date('m');
		$year = date('Y');
		$day = date('d');
	}

/* draws a calendar */
function draw_calendar($month,$year,$day){
	$month_choice = '<select id="month_choice" onchange="month_change()" autocomplete="off">';
	for($i=0; $i<12; $i++)
    {   
    	$month_choice.='<option value="'.$i.'"';
    	if($i==intval($month)){
    		$month_choice.=' selected';
    	}
    	$month_choice.='>'.date('F', mktime(0, 0, 0, $i, 10)).'</option>';
    }
    $month_choice.='</select>';
	$year_choice = '<select id="year_choice" onchange="year_change()" autocomplete="off">';
	for($i=8; $i>-9; $i--)
    {   
    	$year_choice.='<option value="'.($year-$i).'"';
    	if($i==0){
    		$year_choice.=' selected';
    	}
    	$year_choice.='>'.($year-$i).'</option>';
    }
    $year_choice.='</select>';
	$calendar = $month_choice." ".$year_choice;
	/* draw table */
	$calendar.= '<div class="row no-gutters calendar justify-content-start">';

	/* table headings */
	$headings = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
	$useragent=$_SERVER['HTTP_USER_AGENT'];

if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
		$headings = array('S','M','T','W','T','F','S');
	}
	$calendar.= '<div class="col border rounded border-primary calendar-row">'.implode('</div><div class="col border border-primary rounded calendar-row">',$headings).'</div>';

	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$calendar.= '<div class="w-100"></div>';

	/* print "blank" days until the first of the current week */
	for($x = 0; $x < $running_day; $x++):
		$calendar.= '<div class="col rounded border border-dark calendar-day-np"> </div>';
		$days_in_this_week++;
	endfor;

	/* keep going with days.... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
		if($list_day==$day){
			$calendar.= '<div class="col rounded border border-dark calendar-day day-selected-def">';	
		} else {
			$calendar.= '<div class="col rounded border border-dark calendar-day">';
		}
			/* add in the day number */
			//$calendar.= '<div class="day-number">'.$list_day.'</div>';
			$calendar.= $list_day;
			/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
			
		$calendar.= '</div>';
		if($running_day == 6):
			$calendar.= '<div class="w-100"></div>';
			// if(($day_counter+1) != $days_in_month):
			// 	$calendar.= '<div class="col calendar-row">';
			//endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
	endfor;

	/* finish the rest of the days in the week */
	if($days_in_this_week < 8):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar.= '<div class="col rounded border border-dark calendar-day-np"> </div>';
		endfor;
	endif;

	/* final row */
	$calendar.= '<div class="w-100"></div>';

	/* end the table */
	$calendar.= '</div>';
	
	/* all done, return result */
	return $calendar;
}
?>
    <!DOCTYPE html>
    <html lang="en">
    
    <head>
    
    <!-- Title -->
    <title>Employee | Calendar</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta charset="UTF-8">
    <meta name="description" content="Responsive Admin Dashboard Template" />
    <meta name="keywords" content="admin,dashboard" />
    <meta name="author" content="Steelcoders" />
    
    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"><link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.min.css" />
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="../assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet">
    <link href="../assets/css/alpha.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/custom.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<style type="text/css">
	/* calendar */
	table.calendar		{ border-radius: 1em; overflow: hidden; border-left: 1px solid #999 !important; background-color: black;}
	.calendar-row	{ background-color: #999; }
	td.calendar-day	{ min-height:80px; font-size:11px; position:relative; } * html div.calendar-day { height:80px; }
	td.calendar-day:hover	{ background:#eceff5; }
	td.calendar-day-np	{ background:#eee; min-height:80px; } * html div.calendar-day-np { height:80px; }
	td.calendar-day-head { background:#ccc; font-weight:bold; font-size: inherit; text-align:center; width:60px; padding:5px; border-bottom:1px solid #999; border-top:1px solid #999; border-right:1px solid #999; }
	/* shared */
	.calendar-row{ font-size: 20px; }
	.calendar-day, .calendar-day-np { font-size: 20px; white-space: nowrap; }
	.day-selected-def{
		background-color: #1E90FF;	
	}

	@media only screen and (max-width: 425px) {
		.calendar-day, .calendar-day-np { font-size: 0.8em; white-space: nowrap; }	
	}	

	@media only screen and (max-width: 370px) {
		.calendar-row{ font-size: 0.8em; }
		.calendar-day, .calendar-day-np { font-size: 0.75em; white-space: nowrap; }	
	}

	@media only screen and (max-width: 330px) {
		.calendar-row{ font-size: 0.7em; }
		.calendar-day, .calendar-day-np { font-size: 0.6em; padding-left: 0; white-space: nowrap; }	
		.calendar{
			margin-right: 0;
  			margin-left: 0;
		}
	}

	</style>
	</head>
	<body>
	<?php
    include('../includes/header.php');
    include('sidebar.php');
    ?>
    <main class="mn-inner">
    <div class="row" style="height: 700px;">
    <div class="col col-sm-12 col-lg-6	">
    
    <div class="card">
    	 <?php
    echo "<div class=\"clearfix\" style=\"padding: 10px; \">";
    echo "<button class=\"btn btn-secondary float-left\" type=\"button\" id=\"decrement\" value=\"".$year."-".$month."\"><i class=\"fas fa-arrow-circle-left\"></i></button>";
	echo "<button class=\"btn btn-secondary float-right\" type=\"button\" name=\"increment\" value=\"".$year."-".$month."\"><i class=\"fas fa-arrow-circle-right\"></i></button>";
	echo "</div>";
	?>
    <div class="card-content">
    <?php
	echo "<form id=\"calend\" name=\"calend\" method=\"post\" >".draw_calendar($month, $year, $day)."</form>";
	?>
	</div>
    </div>
    </div>
    </div>
    <div class="row">
    </div>
	</main>
	</div>

	</body>
	<script src="../assets/plugins/jquery/jquery-2.2.0.min.js"></script>
    <script src="../assets/plugins/materialize/js/materialize.min.js"></script>
    <script src="../assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
    <script src="../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
    <script src="assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/alpha.min.js"></script>
    <script src="../assets/js/pages/form_elements.js"></script>
    <script src="../assets/js/pages/form-input-mask.js"></script>
    <script src="../assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>
    <script type="text/javascript">
    	function month_change(){
    		var month_choice = document.getElementById("month_choice").value;
    		console.log(month_choice);	
    	}
    </script>
</html>
<?php
}
?>