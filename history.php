<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{   
header('location:index.php');
}
else{

// Sending in history table

/*$today = date("Y-m-d");
$this_year = date("Y");
$sql="SELECT cur_year FROM tblleaves LIMIT 1";
$query = $dbh -> prepare($sql);
$query->bindParam(':date',$today,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if ($this_year==(int)$result[0]['cur_year']) {
    $sql="INSERT INTO leave_history SELECT * FROM tblleaves IF ToDate <= :date";
    $query = $dbh -> prepare($sql);
    $query->bindParam(':date',$today,PDO::PARAM_STR);
    $query->execute();
}*/

//$results=$query->fetchAll(PDO::FETCH_OBJ);
//print_r ($results);


 ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        
        <!-- Title -->
        <title>Leave History</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta charset="UTF-8">
        <meta name="description" content="Responsive Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Steelcoders" />
        
        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="assets/plugins/materialize/css/materialize.min.css"/>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet">
        <link href="assets/plugins/datatables/css/jquery.dataTables.min.css" rel="stylesheet">

                <link href="assets/plugins/google-code-prettify/prettify.css" rel="stylesheet" type="text/css"/>  
        <!-- Theme Styles -->
        <link href="assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/custom.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/onleave.css" rel="stylesheet" type="text/css"/>
<style>


        </style>
    </head>
    <body>
            <main class="mn-inner">
                <div class="row">
                    <div class="col s12">
                        <div class="page-title">Leave History upto year <?php echo htmlentities(date('Y'))?></div>
                    </div>
                   
                    <div class="col s12 m12 l12">
                        <div class="card">
                            <div class="card-content">
                                <!-- <span class="card-title">Approved Leave History</span>
                                 --><?php if($msg){?><div class="succWrap"><strong>SUCCESS</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>
                                <table id="example" class="display responsive-table ">
                                    <thead>
                                        <tr>
                                            <th width="50">#</th>
                                            <th width="150">Employee ID</th>
                                            <th width="200">Leave Type</th>
                                            <th width="150">From Date</th>                 
                                            <th width="150">To Date</th>                 
                                            <th width="300">Status</th>                 
                                            <th width="300">Admin Remarks</th>
                                        </tr>
                                    </thead>
                                 
                                    <tbody>
<?php

$sql="SELECT * FROM leave_history ";

$query = $dbh -> prepare($sql);

$query->bindParam(':date',$today,PDO::PARAM_STR);

$query->execute();

$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{         
    $stat="Approved";
    if($result->Status==0)
        $stat="Pending";
    if($result->Status==1)
        $stat="Not Approved";
      ?>  

                                        <tr>
                                            <td> <b><?php echo htmlentities($cnt);?></b></td>
                                            <td><?php echo htmlentities($result->empid);?></a></td>
                                            <td><?php echo htmlentities($result->LeaveType);?></td>
                                            <td><?php echo htmlentities($result->FromDate);?></td>
                                            <td><?php echo htmlentities($result->ToDate);?></td>
                                            <td><?php echo htmlentities($stat);?></td>
                                            <td><?php echo htmlentities($result->AdminRemark);?></td>
                                        </tr>
                                         <?php $cnt++;} }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
         
        </div>
        <div class="left-sidebar-hover"></div>
        
        <!-- Javascripts -->
        <script src="assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
        <script src="assets/js/alpha.min.js"></script>
        <script src="assets/js/pages/table-data.js"></script>
         <script src="assets/js/pages/ui-modals.js"></script>
        <script src="assets/plugins/google-code-prettify/prettify.js"></script>
        <script>

            var modal = document.getElementsByClassName('modal');
            function openmodal(i){
                var modal = document.getElementById('myModal'+i);
                modal.style.display = "block";                                
            }

            function closemodal(i){
                var modal = document.getElementById('myModal'+i);
                $("#myModal"+i).fadeOut();
                //modal.style.display = "none";                                
            }

            window.onclick = function(event) {
                for (var i = 0; i < modal.length; i++) {
                    if(event.target==modal[i]) {
                        $("#myModal"+(i+1)).fadeOut();
                        //modal[i].style.display = "none";
                    }
                }
            }
        </script>

        
    </body>
</html>
<?php } ?>