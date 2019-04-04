<?php

include('includes/config.php');

// Updating remaining leaves which accumulates when session reloads...(Need to add accumulate table in tblleaves)

$sql1="SELECT * FROM leave_left";
$query = $dbh -> prepare($sql1);
$query->execute();
$left=$query->fetchAll(PDO::FETCH_OBJ);

$id = 0;
$leaves_taken = 0;
$left_days = 0;

// Leave_taken from startinh session should be zero...
$sql1="UPDATE `leave_left` SET `leaves_taken`=:leaves_taken,`left_days`=:left_days WHERE `id`=:id";
$query = $dbh -> prepare($sql1);
$query->bindParam(':id',$id,PDO::PARAM_INT);
$query->bindParam(':leaves_taken',$leaves_taken,PDO::PARAM_INT);
$query->bindParam(':left_days',$left_days,PDO::PARAM_INT);

foreach ($left as $i) {
    $i->leaves_taken=0;
    $i->left_days+=$i->totl_avl_year;
	$id = $i->id;
	$left_days = $i->left_days;
	$leaves_taken = $i->leaves_taken;
	$query->execute();
}

?>