<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        
        <!-- Title -->
        <title>Online Leave Management System</title>
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
            .button {
                border: none;
                color: white;
                padding: 10px;
                min-width: 200px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 4px 2px;
                -webkit-transition-duration: 0.4s; /* Safari */
                transition-duration: 0.4s;
                cursor: pointer;
            }

            .button2 {
                background-color: white; 
                color: black; 
                border: 2px solid #008CBA;
            }
            
            .button2:hover {
                background-color: #008CBA;
                color: white;
            }
            
            .start{
                padding-top: 20px; 
            }
            
            .start h1{
                font-size: 50px;
            }
      </style>
        
    </head>
    <body>
        <div class="start" align="center">
            <h1>IIT Patna Online Leave Management Portal</h1>
            <h2>Login As:</h2>
            
            <button class="button button2" onclick="window.location.href='admin/index.php'">Admin</button><br>
            <button class="button button2" onclick="window.location.href='employee/index.php'">Employee</button><br>
            <button class="button button2" onclick="window.location.href='Bhead/index.php'">Faculty Adviser</button><br>
            <button class="button button2" onclick="window.location.href='student/index.php'">Student</button><br>

            <br><h3>To check employees who currently on leave</h3>
            <button class="button button2" onclick="<?php if(strlen($_SESSION['alogin'])==0){ echo "alert('Please Login')"; }else{ echo "window.location.href='emponleave.php'"; } ?>">Click Here</button>
            
        </div>
        
        <!-- Javascripts -->
        <script src="../assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="../assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="../assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="../assets/js/alpha.min.js"></script>
        
    </body>
</html>