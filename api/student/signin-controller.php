<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (isset($_SESSION['studlogin'])) {
    $status=202;
    $msg='Alraedy loggedin';
} else {
    if(isset($_POST['username']) && isset($_POST['password']))// && filter_var($_POST['email`1`12'], FILTER_VALIDATE_EMAIL))
    {
	   $uname=$_POST['username'];
	   $password=md5($_POST['password']);
	   $sql="SELECT EmailId,Password,Status,id FROM tblstudents WHERE EmailId=:uname and Password=:password";
	   $query=$dbh -> prepare($sql);
	   $query-> bindParam(':uname', $uname, PDO::PARAM_STR);
	   $query-> bindParam(':password', $password, PDO::PARAM_STR);
	   $query-> execute();
	   if($results=$query->fetchAll(PDO::FETCH_OBJ)){
           if($query->rowCount() > 0) {
 			    foreach ($results as $result) {
                    if($result->Status==0){
    				    $status=402;
    			    } 
                    $_SESSION['eid']=$result->id;
  			   }
			   if($status==402) {
				    $msg="Your account is Inactive. Please contact admin";
			   } else {
				    $status = 200;
				    $_SESSION['studlogin']=$_POST['username'];
				    $msg = "Successfully Logged In.";
			   } 
		   } else {
			 $status = 400;
			 $msg = "Invalid Details!";
		  }
	   } else{
		  $status = 502;
		  $msg = "Error Fetching Result! Server Down!";
	   }
    } else{
	   $status = 400;
	   $msg = "Invalid Details!";
    }
}

$ret = array();

$ret['status'] = $status;
$ret['msg'] = $msg;

echo json_encode($ret);

?>