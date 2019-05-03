<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{   
    header('location:index.php');
}else{
    $error = "";
    if(isset($_POST['add'])) {

    $leavetype=$_POST['leavetype'];
    $cons=$_POST['cons'];
    $total=$_POST['total'];
    if ((int)$total>=365) {
        $error = "Number of Leaves exceeded 365!!";
    }
    if($error=="") {
        $description=$_POST['description'];
        $restriction=$_POST['restriction'];
        $accumulates = 0;
        if(isset($_POST['accumulates'])) {
            $accumulates=1;
        }
        $distributed=1;
        if($_POST['distributed']=='Half-yearly'){
            $distributed=2;
            $total/=2;
        }
        if($_POST['distributed']=='Quarterly'){
            $distributed=4;
            $total/=4;
        }
        $include_weekends = 0;
        if(isset($_POST['include_weekends'])) {
            $include_weekends=1;
        }

        $sql="INSERT INTO tblleavetype(LeaveType,Description,Restriction,totl_avl_year,accumulates,distributed,include_weekends,total_consec) VALUES(:leavetype,:description,:restriction,:total,:accumulates,:distributed,:include_weekends,:cons)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':leavetype',$leavetype,PDO::PARAM_STR);
        $query->bindParam(':description',$description,PDO::PARAM_STR);
        $query->bindParam(':restriction',$restriction,PDO::PARAM_STR);
        $query->bindParam(':total',$total,PDO::PARAM_STR);
        $query->bindParam(':accumulates',$accumulates,PDO::PARAM_INT);
        $query->bindParam(':distributed',$distributed,PDO::PARAM_INT);
        $query->bindParam(':cons',$cons,PDO::PARAM_INT);
        $query->bindParam(':include_weekends',$include_weekends,PDO::PARAM_INT);
        $duplicate = 0;
        if(!$query->execute()) { 
            $e = $query->errorInfo();
            if ($e[1]==1062) {
                $error= "Leave Type already exists!";
            } else {
                $error="Something went wrong. Please try again!!";        
            }
        } else { 
            $lastInsertId = $dbh->lastInsertId();
            if($lastInsertId)
            {
                $msg="Leave type added Successfully";
            } else {
                $error="Something went wrong. Please try again";
            }
        }
    }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        
        <!-- Title -->
        <title>Admin | Add Leave Type</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta charset="UTF-8">
        <meta name="description" content="Responsive Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Steelcoders" />
        
        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.min.css"/>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="../assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet"> 
        <link href="../assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/custom.css" rel="stylesheet" type="text/css"/>
  <style>
        .errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
        </style>
    </head>
    <body>
  <?php include('header.php');?>
            
       <?php include('sidebar.php');?>
            <main class="mn-inner">
                <div class="row">
                    <div class="col s12">
                        <div class="page-title">Add Leave Type</div>
                    </div>
                    <div class="col s12 m12 l6">
                        <div class="card">
                            <div class="card-content">
                              
                                <div class="row">
                                    <form class="col s12" name="chngpwd" method="post">
                                          <?php if($error){?><div class="errorWrap"><strong>ERROR</strong> : <?php echo htmlentities($error); ?> </div><?php } 
                else if($msg){?><div class="succWrap"><strong>SUCCESS</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>
                                        <div class="row">
                                            <div class="input-field col s12">
<input id="leavetype" type="text"  class="validate" autocomplete="off" name="leavetype"  required>
                                                <label for="leavetype">Leave Type</label>
                                            </div>


                                        <div class="input-field col s12">
<textarea id="textarea1" class="materialize-textarea" name="description" length="500"></textarea>
                                                <label for="deptshortname">Description</label>
                                            </div>
                                        <div class="input-field col s12">
<textarea id="textarea1" class="materialize-textarea" name="restriction" length="500"></textarea>
                                                <label for="deptshortname">Restriction</label>
                                            </div>    
                                        <div class="input-field col s12">
<input id="total" type="text"  class="validate" autocomplete="off" name="total"  required>
                                                <label for="leavetype">Number of leaves per year(in days)</label>
                                            </div>

                                        <div class="input-field col s12">
<input id="cons" type="text"  class="validate" autocomplete="off" name="cons"  required>
                                                <label for="cons">Maximum number of leaves can be taken consecutevely(in days)</label>
                                            </div>

                                        <div class="input-field col s12">
                                            <select id="distributed" name="distributed" required>
                                                <option value="Quarterly">Quarterly</option>
                                                <option value="Half-yearly">Half-yearly</option>
                                                <option value="Yearly" selected>Yearly</option>
                                            </select>
                                            <label for="distributed">Select the way this leave is distributed.<br></label>
                                        </div>
                                        <div class="input-field col s12">
<input id="accumulates" type="checkbox"  class="validate" name="accumulates">
                                                <label for="accumulates">Does this leave accumulates over the years? </label>
                                            </div>
                                            <div class="input-field col s12">
<input id="include_weekends" type="checkbox"  class="validate" name="include_weekends">
                                                <label for="include_weekends">Does this leave include weekends into Leave days? </label>
                                            </div>

<div class="input-field col s12 addbutton">
<button type="submit" name="add" class="waves-effect waves-light btn indigo m-b-xs">ADD</button>

</div>




                                        </div>
                                       
                                    </form>
                                </div>
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
        <script src="../assets/js/alpha.min.js"></script>
        <script src="../assets/js/pages/form_elements.js"></script>
        
    </body>
</html>
<?php } ?> 
