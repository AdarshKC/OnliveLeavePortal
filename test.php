
<?php
require_once "includes/config.php";
require_once "util/leave.php";

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
?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<style type="text/css">
	/* calendar */
table.calendar		{ border-radius: 1em; overflow: hidden; border-left: 1px solid #999 !important; background-color: black;}
tr.calendar-row	{ background-color: #fff; }
td.calendar-day	{ min-height:80px; font-size:11px; position:relative; } * html div.calendar-day { height:80px; }
td.calendar-day:hover	{ background:#eceff5; }
td.calendar-day-np	{ background:#eee; min-height:80px; } * html div.calendar-day-np { height:80px; }
td.calendar-day-head { background:#ccc; font-weight:bold; font-size: 20px; text-align:center; width:60px; padding:5px; border-bottom:1px solid #999; border-top:1px solid #999; border-right:1px solid #999; }
/* shared */
td.calendar-day, td.calendar-day-np { width:60px; padding:5px; border-bottom:1px solid #999; border-right:1px solid #999; }
td.day-selected-def{
	background-color: #1E90FF;	
}
</style>
<body>
<?php
echo "<form id=\"calend\" name=\"calend\" method=\"post\" >".draw_calendar($month, $year, $day). "</div>";
?>

</body>
</html>
<?php 
/* draws a calendar */
function draw_calendar($month,$year,$day){
	$calendar = "<center><h3><button type=\"submit\" name=\"decrement\" value=\"".$year."-".$month."\"><i class=\"fas fa-arrow-circle-left\"></i></button> ".date('F', mktime(0, 0, 0, $month, 10))." ".$year." <button type=\"submit\" name=\"increment\" value=\"".$year."-".$month."\"><i class=\"fas fa-arrow-circle-right\"></i></button></h3><center>";
	/* draw table */
	$calendar.= '<table cellpadding="0" cellspacing="0" class="calendar">';

	/* table headings */
	$headings = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$calendar.= '<tr class="calendar-row">';

	/* print "blank" days until the first of the current week */
	for($x = 0; $x < $running_day; $x++):
		$calendar.= '<td class="calendar-day-np"> </td>';
		$days_in_this_week++;
	endfor;

	/* keep going with days.... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
		if($list_day==$day){
			$calendar.= '<td class="calendar-day day-selected-def">';	
		} else {
			$calendar.= '<td class="calendar-day">';
		}
			/* add in the day number */
			//$calendar.= '<div class="day-number">'.$list_day.'</div>';
			$calendar.= '<center><h1>'.$list_day.'</h1></center>';
			/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
			$calendar.= str_repeat('<p> </p>',2);
			
		$calendar.= '</td>';
		if($running_day == 6):
			$calendar.= '</tr>';
			if(($day_counter+1) != $days_in_month):
				$calendar.= '<tr class="calendar-row">';
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
	endfor;

	/* finish the rest of the days in the week */
	if($days_in_this_week < 8):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar.= '<td class="calendar-day-np"> </td>';
		endfor;
	endif;

	/* final row */
	$calendar.= '</tr>';

	/* end the table */
	$calendar.= '</table>';
	
	/* all done, return result */
	return $calendar;
}
?>