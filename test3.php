<?php
session_start();
error_reporting(0);
include('includes/config.php');

$sql1="SELECT * FROM tblemployees";
$query = $dbh -> prepare($sql1);
$query->execute();
$empl=$query->fetchAll(PDO::FETCH_OBJ);

//print_r ($empl);
//echo $query->rowCount();

$sql2="SELECT * FROM tblleavetype ";
$query = $dbh -> prepare($sql2);
$query->execute();
$leave=$query->fetchAll(PDO::FETCH_OBJ);

//echo $query->rowCount();
//print_r ($leave);

// Some error in code!!!

foreach($leave as $i) {
	foreach($empl as $j) {
		$emp_id = $j->id;
		$leave_id = $i->id;
		$LeaveType = $i->LeaveType;
		$unique_id = (string)$leave_id."_".$emp_id;
		$accumulates = $i->accumulates;
		$totl_avl_year = $i->totl_avl_year;
		$distributed = $i->distributed;
		
		//echo $emp_id." ".$leave_id." ".$unique_id." ".$accumulates."<br><br>";
		// Calculating leaves_taken for current session...
		$leaves_taken = 0;
		$sql3="SELECT * FROM tblleaves WHERE LeaveType=:l AND empid=:e AND Status=1";
		$query = $dbh -> prepare($sql3);
		$query->bindParam(':e', $emp_id, PDO::PARAM_INT);
		$query->bindParam(':l', $LeaveType, PDO::PARAM_STR);
		$query->execute();
		$taken=$query->fetchAll(PDO::FETCH_OBJ);
		if($query->rowCount()) {
			foreach ($taken as $k) {
				//echo "is<br>";
				$leaves_taken+=$k->count;
			}
		}
		$left_days = ($totl_avl_year)-($leaves_taken); 
		//echo $i->totl_avl_year.$totl_avl_year."<br>";
		//print_r ($taken);
		//echo "<br>";

		$sql="INSERT INTO leave_left(emp_id,leave_id,unique_id,accumulates,leaves_taken,left_days,LeaveType,totl_avl_year,distributed) VALUES (:emp_id, :leave_id, :unique_id, :accumulates, :leaves_taken, :left_days, :LeaveType, :totl_avl_year, :distributed)";

		$query = $dbh->prepare($sql);
		$query->bindParam(':emp_id', $emp_id, PDO::PARAM_INT);
		$query->bindParam(':leave_id', $leave_id, PDO::PARAM_INT);
		$query->bindParam(':unique_id', $unique_id, PDO::PARAM_STR);
		$query->bindParam(':accumulates', $accumulates, PDO::PARAM_INT);
		$query->bindParam(':leaves_taken',$leaves_taken, PDO::PARAM_INT);
		$query->bindParam(':left_days',$left_days, PDO::PARAM_INT);
		$query->bindParam(':LeaveType',$LeaveType, PDO::PARAM_STR);
		$query->bindParam(':totl_avl_year',$totl_avl_year, PDO::PARAM_INT);
		$query->bindParam(':distributed',$distributed, PDO::PARAM_INT);
		$query->execute();

		//print_r($query->fetchAll(PDO::FETCH_OBJ));
		
		echo $emp_id." ".$leave_id." ".$unique_id." ".$accumulates." ".$leaves_taken." ".$left_days." ".$LeaveType." ".$totl_avl_year." ".$distributed."<br>";
	}
}
?>