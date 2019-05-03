<?php
include_once('../includes/config.php');
include_once('../util/leave.php');

$status = 0;
$ret = array();

if(!isset($_POST['from']) || !isset($_POST['to']) || !isset($_POST['type']) || !isset($_POST['eid']) ){
    $status = 400;
}

if($status==0) {
    if(/*$_POST['type']==""*/0){
        $status = 405;
    } else {
        // $_POST['from'] = "2019-04-22";
        // $_POST['to'] = "2019-04-24";
        // $_POST['type'] = "Casual Leave";
        // $_POST['eid'] = 1;
        $status = 200;    
        $res = array();
        $empid = $_POST['eid'];
        $leavetype=$_POST['type'];
        $sql="SELECT * FROM leave_left WHERE LeaveType=:leavetype AND emp_id=:empid";
        //$sql="SELECT * FROM leave_left WHERE LeaveType='".$leavetype."' AND emp_id=".$empid;
        //echo $sql;
        $query = $dbh->prepare($sql);
        $query->bindParam(':leavetype',$leavetype,PDO::PARAM_STR);
        $query->bindParam(':empid',$empid,PDO::PARAM_INT);
        $query->execute();
        $results=$query->fetchAll(PDO::FETCH_OBJ);
        $include_weekends = 0;
        $leaves_taken = 0;
        $total_consec = 0;
        $left_days = 0;
            
        if($query->rowCount() > 0) {
            foreach($results as $result) {
                $leaves_taken = (int)($result->leaves_taken);
                $left_days = (int)($result->left_days);
                $distributed = (int)$result->distributed; 
                $include_weekends = (int)$result->include_weekends; 
                $total_consec = (int)$result->total_consec;      
            }
        }

        $fromdate=$_POST['from'];  
        $todate=$_POST['to'];

        $ret["from"] = $fromdate;
        $ret['to'] = $todate;  
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

        if($count>$left_days){
            $status = 403;
        }

        // =========================================================================================================
        $existing = array();

        $sql = "SELECT * from tblleaves WHERE LeaveType='".$leavetype."' AND status IN (0,1) AND empid=".$empid;
            
        $query = $dbh -> prepare($sql);
        $query->execute();
        $results=$query->fetchAll(PDO::FETCH_OBJ);
            
        foreach ($results as $result) {
            $from_temp = strtotime($result->FromDate);
            $to_temp = strtotime($result->ToDate);
            $days_temp = ceil(($to_temp-$from_temp)/86400)+1;
            for ($i=0; $i < $days_temp; $i++) { 
                $existing[] = $calc_days->getDay($from_temp, $i);
            }
        }

        $ret['existing'] = $existing;

        $sql = "SELECT * from list_holidays";
        $query = $dbh -> prepare($sql);
        $query->execute();
        $results=$query->fetchAll(PDO::FETCH_OBJ);

        foreach ($results as $result) {
            $existing[] = strtotime($result->from_date);
        }

        
        $from = strtotime($fromdate);
        $i = -1;
        $j = -1;
        while(true){
            if(in_array($calc_days->getDay($from, $i), $existing) || $calc_days->getWeekday($from, $i)==6 || $calc_days->getWeekday($from, $i)==0 ){
                $i--;
            } else {
                break;
            }
        }

        $limit = (-1*$i) - 1;
        $ret['test0'] = $limit;
        
        $to = strtotime($todate);
        $i = 1;
        $j = 1;
        while(true){
            if(in_array($calc_days->getDay($to, $i), $existing) || $calc_days->getWeekday($to, $i)==6 || $calc_days->getWeekday($to, $i)==0 ){
                $i++;
            } else {
                break;
            }
        }


        $limit+= $i - 1; 

        $ret['test'] = $limit;
        
        if($limit+ceil(($to-$from)/86400)+1 > $total_consec && $total_consec!=0){
            $status = 402;
        } 
    }
}

if($status==200){
    $ret['result'] = $res;
} 
$ret['status'] = $status;
    
        //==========================================================================================================      
        //$left_days = 7;

echo json_encode($ret);
?>
        