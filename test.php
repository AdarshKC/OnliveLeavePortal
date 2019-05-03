<?php
require_once "includes/config.php";
$sql2="SELECT * FROM leave_left ";

echo "Sample Test Case: (Accumulation Part)<br><br>";

$query = $dbh -> prepare($sql2);
$query->execute();
$leave=$query->fetchAll(PDO::FETCH_OBJ);

$d1 = date('m');

foreach ($leave as $i) {
	
	$str= (string)$i->timestamp;
	$d2 = (int)($str[5].$str[6]);

	$d = $i->distributed;

	$number1 = intdiv($d1,12/$d);
	$number2 = intdiv($d2,12/$d);
	$diff = $number1-$number2;
	
	//echo $d1." ".$d2."<br>";
	echo "Should be changed: ".$number1." But Changed ".$number2."<br>Difference ".$diff."<br><br>";
	
	if($diff<=0){
		continue;
	}

	$pos = $i->id;
	$leaves_taken = 0;
	$left_days = $i->left_days;

	if($i->accumulates==1) {
		$left_days+= ($i->totl_avl_year)*($diff);
	} else {
		$left_days = $i->totl_avl_year;
	}

	$sql="UPDATE `leave_left` SET `leaves_taken`=:leaves_taken,`left_days`=:left_days WHERE id=".$pos;
	$query = $dbh -> prepare($sql);
	$query->bindParam(':leaves_taken',$leaves_taken,PDO::PARAM_INT);
	$query->bindParam(':left_days',$left_days,PDO::PARAM_INT);
	$query->execute();
}
?>
