<?php

include_once('includes/config.php');
include_once('util/leave.php');

$fromdate="2019-05-07";  
$todate="2019-05-15";
$include_weekends = 0;
$calc_days = new Leave($fromdate, $todate);
$leave_days = $calc_days->calcToalLeaveDays($include_weekends);
$count=(int)$leave_days['days'];
      
echo json_encode($leave_days);  

?>