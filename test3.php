<!DOCTYPE html>
<html>
<body>

<?php
require_once "includes/config.php";
require_once "util/leave.php";

$from = "2019-03-28";
$to = "2019-04-1";
$leave = new Leave($from, $to); 

$days = $leave->calcToalLeaveDays(0);
echo $from." | ".$to."<br>";

foreach ($days['weekends'] as $value) {
	echo date('Y-m-d', $value). "<br>";
}

$leave->prepare_holidayQuery();

print_r($days);

echo json_encode($days);

?>

</body>
</html>