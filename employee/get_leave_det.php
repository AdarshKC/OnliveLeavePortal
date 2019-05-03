<?php
session_start();
include_once('../includes/config.php');
include_once('../util/leave.php');

$status = 0;
$ret = array();

if(!isset($_POST['from']) || !isset($_POST['to']) !isset($_POST['type']) || !isset($_SESSION['eid'])){
    $status = 400;
}

if($status==0) {
        $empid = $_SESSION['eid'];
        $leavetype=$_POST['type'];
        $sql="SELECT * FROM leave_left WHERE LeaveType=:leavetype AND emp_id=:empid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':leavetype',$leavetype,PDO::PARAM_STR);
        $query->bindParam(':empid',$empid,PDO::PARAM_INT);
        $query->execute();
        $results=$query->fetchAll(PDO::FETCH_OBJ);
        if($query->rowCount() > 0) {
            foreach($results as $result) {
                $leaves_taken = $result->$leaves_taken;
                $left_days = $result->$left_days;
                $distributed = $result->distributed; 
                $include_weekends = $result->include_weekends; 
                $total_consec = $result->total_consec;      
            }
        }

        $fromdate=$_POST['from'];  
        $todate=$_POST['to'];
        // $from=date("d/m/Y", strtotime($fromdate));
        // $to=date("d/m/Y", strtotime($todate));
        // //$include_weekends = 0;
        $calc_days = new Leave($fromdate, $todate);
        $leave_days = $calc_days->calcToalLeaveDays($include_weekends);
        $count=(int)$leave_days['days'];
        
        $res['count'] = $count;
        $res['left_days'] = $left_days;
        $res['leaves_taken'] = $leaves_taken; 
        $status = 200;       

        // =========================================================================================================
        // $existing = array();

        // $sql = "SELECT * from tblleaves WHERE LeaveType=".$leavetype." AND status IN (0,1) AND empid=".$empid;
        // $query = $dbh -> prepare($sql);
        // $query->execute();
        // $results=$query->fetchAll(PDO::FETCH_OBJ);
            
        // foreach ($results as $result) {
        //     $from_temp = strtotime($result->FromDate);
        //     $to_temp = strtotime($result->ToDate);
        //     $days_temp = ceil(($to_temp-$from_temp)/86400)+1;
        //     for ($i=0; $i < $days_temp; $i++) { 
        //         $existing[$calc_days->getDay($from_temp, $i)] = 1;
        //     }
        // }

        // $sql = "SELECT * from list_holidays";
        // $query = $dbh -> prepare($sql);
        // $query->execute();
        // $results=$query->fetchAll(PDO::FETCH_OBJ);

        // foreach ($results as $result) {
        //     $day_temp = ;
        //     $existing[strtotime($result->from_date)] = 1;
        // }

        // $from = strtotime($fromdate);
        // $i = -1;
        // $j = 0;
        // while(true){
        //     if(in_array($calc_days->getDay($from, $i), $existing) || $calc_days->getWeekday($from, $i)==6 || $calc_days->getWeekday($from, $i)==0 ){
        //         i--;
        //     }
        //     j--;
        //     if(i!=j){
        //         break;
        //     }
        // }

        // $limit = (-1*$i) - 1;

        // $to = strtotime($todate);
        // $i = 1;
        // $j = 0;
        // while(true){
        //     if(in_array($calc_days->getDay($to, $i), $existing) || $calc_days->getWeekday($to, $i)==6 || $calc_days->getWeekday($to, $i)==0 ){
        //         i++;
        //     }
        //     j++;
        //     if(i!=j){
        //         break;
        //     }
        // }

        // $limit+= $i - 1; 
        
        // if($limit+ceil(($to-$from)/86400)+1 > $total_consec){
        //     $status = 402;
        // } 

}

if($status==200){
    $ret['result'] = $res;
} 
$ret['status'] = 200;
    
        //==========================================================================================================      
        //$left_days = 7;

echo json_encode($ret);
?>
        