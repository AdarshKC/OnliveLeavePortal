<?php

require_once "includes/config.php";

$sql2="SELECT * FROM tblleaves ";
$query = $dbh -> prepare($sql2);
$query->execute();
$leave=$query->fetchAll(PDO::FETCH_OBJ);

$str= (string)$leave[1]->PostingDate;
$d2=(int)($str[5].$str[6]);

//echo $d2;

$sql1="SELECT * FROM tblleavetype ";
$query = $dbh -> prepare($sql1);
$query->execute();
$empl=$query->fetchAll(PDO::FETCH_OBJ);


foreach ($empl as $i) {
	$d = $empl[0]->distributed;
	$c = date('m');
	$r = intdiv(($c*$d+11),12);
	$d1 = intdiv(($r*12),$d);
	
	echo $d1.$d2;

	echo $d1-$d2;
}
?>
