<?php
session_start();
error_reporting(0);
include_once('../includes/config.php');
include_once('../util/leave.php');
if(strlen($_SESSION['emplogin'])==0)
{   
    header('location:index.php');
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    
    <head>
    
    <!-- Title -->
    <title>Employee | Apply Leave</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta charset="UTF-8">
    <meta name="description" content="Responsive Admin Dashboard Template" />
    <meta name="keywords" content="admin,dashboard" />
    <meta name="author" content="Steelcoders" />
    
    <!-- Styles -->
    <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.min.css" />
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="../assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet">
    <link href="../assets/css/alpha.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/custom.css" rel="stylesheet" type="text/css" />
    <style>
    .errorWrap {
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #dd3d36;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
    }
    
    .succWrap {
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #5cb85c;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
    }

    .stats-card:hover{
        cursor: pointer;
        -webkit-box-shadow: 0 2px 1px 0 rgba(0, 0, 0, .6);
        box-shadow: 0 2px 1px 0 rgba(0, 0, 0, .6);
    }
    
    .red-color{
        background-color: red;
        color: red;
    }

    [class*="loade-"] {
    display: inline-block;
    width: 5em;
    height: 5em;
    color: inherit;
    vertical-align: middle;
    pointer-events: none;
}

.loade-01 {
    border: .2em dotted currentcolor;
    border-radius: 50%;
    animation: 1s loade-01 linear infinite;
}

@keyframes loade-01 {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

    </style>
    
    </head>
    
    <body>
    <?php 
    include('../includes/header.php');
    include('sidebar.php');
    ?>
    <main class="mn-inner">
    <div class="middle-content">
    <div class="row no-m-t no-m-b">
    <div class="col s12 m12 l4">
    <div class="modal-trigger card stats-card calendarOpener" href="#modal1" >
    <div class="card-content">
    
    <span class="card-title">Working Days Left(<?php echo date('Y'); ?>)</span>
    <span class="stats-counter">
    <?php
    $Days = new Leave((string)date('Y-m-d'), (string)date('Y-12-31'));
    $working_days_left = $Days->WorkingDays_left();
    ?>
    
    <span class="counter"><?php echo htmlentities($working_days_left);?></span></span>
    </div>
    <div id="sparkline-bar"></div>
    </div>
    </div>
    <div id="modal1" class="modal modal-fixed-footer" style="height: 80%;">
       <!--  <div class="modal-content ">
            <iframe src="../test.php" height="550px" width="500px"></iframe>
        </div>-->
        <div class="modal-content"> 
        <table class="display">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Holiday</th>
                    <th>Date</th>
                    <th>Day</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * from list_holidays";
                $query = $dbh -> prepare($sql);
                $query->execute();
                $results=$query->fetchAll(PDO::FETCH_OBJ);
                $i = 0;
                foreach ($results as $result) {
                    $i++;
                   ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $result->name; ?></td>
                        <td><?php echo $result->from_date; ?></td>
                        <td><?php echo date('l',$result->from_date); ?></td>
                    </tr>
                <?php
                }
                ?>

            </tbody>
        </table>    
        </div>
        <div class="modal-footer" style="width:90%">
            <div class="col s12 m12 l4"></div>
            <div class="col s12 m12 l4">
                <a href="calendar.php" class="waves-effect waves-light btn blue big m-b-xs" >Go to Calender</a>
            </div>
            <div class="col s12 m12 l4"></div>
            </center>
        </div>
    </div>   

    <div class="col s12 m12 l4">
    <div class="modal-trigger card stats-card" href="#modal2" >
    <div class="card-content">
    
    <span class="card-title">Leaves Taken(<?php echo date('Y'); ?>) </span>
    <?php
    $sql = "SELECT SUM(leaves_taken) AS sum from leave_left WHERE emp_id=:eid";
    $query = $dbh -> prepare($sql);
    $query->bindParam(':eid',$_SESSION['eid'],PDO::PARAM_INT);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    foreach ($results as $result) {
        $dptcount=$result->sum;
    }
    ?>
    <span class="stats-counter"><span
    class="counter"><?php echo htmlentities($dptcount);?></span></span>
    </div>
    <div id="sparkline-line"></div>
    </div>
    </div>
    <div id="modal2" class="modal modal-fixed-footer" style="height: 60%">
        <div class="modal-content">
        <table class="display">
            <thead>
                <tr>
                    <th>Leave Type</th>
                    <th>Taken</th>
                    <th>Left</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * from leave_left WHERE emp_id=". $_SESSION['eid'];
                $query = $dbh -> prepare($sql);
                $query->execute();
                $results=$query->fetchAll(PDO::FETCH_OBJ);
                foreach ($results as $result) {
                   ?>
                   <tr>
                       <td><?php echo $result->LeaveType; ?></td>
                       <td><?php echo $result->leaves_taken; ?></td>
                       <td><?php echo $result->left_days; ?></td>
                   </tr>
                <?php
                }
                ?>

            </tbody>
        </table>    
        </div>    
    </div>

    <div class="col s12 m12 l4">
    <div class="modal-trigger card stats-card" href="#modal2" >
    <div class="card-content">
    <span class="card-title">Leaves Left(<?php echo date('Y'); ?>)</span>
    <?php
    $sql = "SELECT SUM(left_days) AS sum from leave_left WHERE emp_id=". $_SESSION['eid'];
    $query = $dbh -> prepare($sql);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    foreach ($results as $result) {
        $leavtypcount=$result->sum;
    }
    ?>
    <span class="stats-counter"><span
    class="counter"><?php echo htmlentities($leavtypcount);?></span></span>
    
    </div>
    <div id="sparkline-line"></div>
    </div>
    </div>
    
    </div>
    </div>
    
    <div class="row">
    <div class="col s12">
    <div class="page-title">Apply for Leave</div>
    </div>
    <div class="col s12 m12 l8">
    <div class="card">
    <div class="card-content">
    
    <?php
    if(isset($_POST['next']))
    {
        $empid=$_SESSION['eid'];
        $description=$_POST['description'];
        $leavetype=$_POST['leavetype'];
        // $sql="SELECT * FROM leave_left WHERE LeaveType=:leavetype AND emp_id=:empid";
        // $query = $dbh->prepare($sql);
        // $query->bindParam(':leavetype',$leavetype,PDO::PARAM_STR);
        // $query->bindParam(':empid',$empid,PDO::PARAM_INT);
        // $query->execute();
        // $results=$query->fetchAll(PDO::FETCH_OBJ);
        // if($query->rowCount() > 0) {
        //     foreach($results as $result) {
        //         $leaves_taken = $result->$leaves_taken;
        //         $left_days = $result->$left_days;
        //         $distributed = $result->distributed; 
        //         $include_weekends = $result->include_weekends;       
        //     }
        // }
        
        $fromdate=$_POST['fromdate'];  
        $todate=$_POST['todate'];
        $from=date("Y-m-d", $fromdate);
        $to=date("Y-m-d", $todate);
        $include_weekends = 0;
        $calc_days = new Leave($fromdate, $todate);
        $leave_days = $calc_days->calcToalLeaveDays($include_weekends);
        $count=(int)$leave_days['days'];
        $left_days = 7;
        ?>
        
        <form id="example-form" method="post" name="addemp">
        <div>
        <h3>Apply for Leave</h3>
        <section>
        <div class="wizard-content">
        <div class="row">
        <div class="col m12">
        <div class="row">
        <?php if($error)
        {?><div class="errorWrap"><strong>ERROR
            </strong>:<?php echo htmlentities($error); ?> </div><?php
        } 
        else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
        
        <div>
            <h4><?php echo $leavetype; ?></h4>
            <h5>Leaves left now: <?php echo $left_days; ?></h5>
            <h5>Leaves going to be used: <?php echo $count; ?></h5>
            <input type="checkbox" name="combine" value="Do you want to comnine other leave?">
        </div>
        <button type="submit" name="apply" id="apply"
        class="waves-effect waves-light btn indigo m-b-xs">Submit</button>
        
        </div>
        </div>
        </section>
        </section>
        </div>
        </form>
        
        <?php
    } else {
        ?>
        
        <form id="example-form" method="post" name="addemp">
        <div>
        <h3>Apply for Leave</h3>
        <section>
        <div class="wizard-content">
        <div class="row">
        <div class="col m12">
        <div class="row">
        <?php if($error)
        {?><div class="errorWrap"><strong>ERROR
            </strong>:<?php echo htmlentities($error); ?> </div><?php
        } 
        else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
        
        
        <div class="input-field col  s12">
        <select name="leavetype" autocomplete="off">
        <option value="">Select leave type...</option>
        <?php $sql = "SELECT  LeaveType from tblleavetype";
        $query = $dbh -> prepare($sql);
        $query->execute();
        $results=$query->fetchAll(PDO::FETCH_OBJ);
        $cnt=1;
        if($query->rowCount() > 0)
        {
            foreach($results as $result)
            {   ?>
                <option
                value="<?php echo htmlentities($result->LeaveType);?>">
                <?php echo htmlentities($result->LeaveType);?>
                </option>
                <?php 
            }
        } ?>
        </select>
        </div>
        
        <div class="input-field col m6 s12">
        <div for="fromdate">From Date</div>
        <input placeholder="" name="fromdate" type="date" min="<?php echo date('Y-m-d'); ?>" onchange="change_toDate()" required>
        </div>
        <div class="input-field col m6 s12">
        <div for="todate">To Date</div>
        <input placeholder="." name="todate" type="date" min="<?php echo date('Y-m-d'); ?>" onchange="change_fromDate()" required>
        </div>
        <div class="input-field col m12 s12">
        <label for="birthdate">Description</label>
        
        <textarea id="textarea1" name="description"
        class="materialize-textarea" length="500"
        required></textarea>
        </div>
        </div>
        <button type="submit" name="next" id="apply"
        class="waves-effect waves-light btn indigo m-b-xs">Next</button>
        
        </div>
        </div>
        </section>
        </section>
        </div>
        </form>
        
        <?php
    }
    ?>
    
    </div>
    </div>
    </div>
    </div>
    </main>
    </div>
    <div class="left-sidebar-hover"></div>
    <!-- Javascripts -->
    <script src="../assets/plugins/jquery/jquery-2.2.0.min.js"></script>
    <script src="../assets/plugins/materialize/js/materialize.min.js"></script>
    <script src="../assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
    <script src="../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
    <script src="assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/alpha.min.js"></script>
    <script src="../assets/js/pages/form_elements.js"></script>
    <script src="../assets/js/pages/form-input-mask.js"></script>
    <script src="../assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>
    <script>
    function change_toDate(){
        var from = document.forms["addemp"]["fromdate"].value;
        if(from!=""){
            document.forms["addemp"]["todate"].setAttribute("min", from);
        }
    }
    
    function change_fromDate(){
        var to = document.forms["addemp"]["todate"].value;
        if(to!=""){
            document.forms["addemp"]["fromdate"].setAttribute("max", to);
        }
    }
    
    Date.prototype.yyyymmdd = function() {
  var mm = this.getMonth() + 1; // getMonth() is zero-based
  var dd = this.getDate();

  return [this.getFullYear(),
          (mm>9 ? '' : '0') + mm,
          (dd>9 ? '' : '0') + dd
         ].join('-');
};
    </script>
    </body>
    
    </html>
    <?php 
} 
?>