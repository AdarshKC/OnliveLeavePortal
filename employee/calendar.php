<?php
session_start();
$mobile = 0;
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
	$mobile = 1;
}


error_reporting(0);
include_once('../includes/config.php');
include_once('../util/leave.php');
if(strlen($_SESSION['emplogin'])==0)
{   
    header('location:index.php');
} else {
	$month = intval(date("m", strtotime(date("Y-m-d"))));
	$year = intval(date("Y", strtotime(date("Y-m-d"))));
	$day = intval(date("d", strtotime(date("Y-m-d"))));
	
?>
    <!DOCTYPE html>
    <html lang="en">
    
    <head>
    
    <!-- Title -->
    <title>Employee | Calendar</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta charset="UTF-8">
    <meta name="description" content="Responsive Admin Dashboard Template" />
    <meta name="keywords" content="admin,dashboard" />
    <meta name="author" content="Steelcoders" />
    
    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"><link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.min.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="../assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet">
    <link href="../assets/css/alpha.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/custom.css" rel="stylesheet" type="text/css" />
	<style type="text/css">
	/* calendar */
	table.calendar		{ border-radius: 1em; overflow: hidden; border-left: 1px solid #999 !important; background-color: black;}
	.calendar-row	{ background-color: #999; }
	td.calendar-day	{ min-height:80px; font-size:11px; position:relative; } * html div.calendar-day { height:80px; }
	td.calendar-day:hover	{ background:#eceff5; }
	td.calendar-day-np	{ background:#eee; min-height:80px; } * html div.calendar-day-np { height:80px; }
	td.calendar-day-head { background:#ccc; font-weight:bold; font-size: inherit; text-align:center; width:60px; padding:5px; border-bottom:1px solid #999; border-top:1px solid #999; border-right:1px solid #999; }
	/* shared */
	.calendar-row{ font-size: 20px; }
	.calendar-day, .calendar-day-np { font-size: 20px; white-space: nowrap; }
	.day-selected-def{
		background-color: #1E90FF;	
	}

	.holiday {
		color: red !important;
		font-weight: bold;
		background-color: rgba(212, 54, 54, 0.3) !important;
	}

	.weekend {
		color: red;
		font-weight: bold;
	}

	.leave{
		color: blue;
		font-weight: bold;
	}

    .selected {
        background-color: #63D8DC;
        border: 1px solid #fff !important;
    }

	.leave-accepted{
		color: green;
		font-weight: bold;
		background-color: rgb(103, 230, 103, 0.6);
	}

	@media only screen and (max-width: 425px) {
		.calendar-day, .calendar-day-np { font-size: 0.8em; white-space: nowrap; }	
        #leave_apply_details h5{
            font-size: 15px;
        }
	}	

	@media only screen and (max-width: 370px) {
		.calendar-row{ font-size: 0.8em; }
		.calendar-day, .calendar-day-np { font-size: 0.75em; white-space: nowrap; }	
	}

	@media only screen and (max-width: 330px) {
		.calendar-row{ font-size: 0.7em; }
		.calendar-day, .calendar-day-np { font-size: 0.6em; padding-left: 0; white-space: nowrap; }	
		.calendar{
			margin-right: 0;
  			margin-left: 0;
		}
	}

	/* Write your custom CSS here */

/* Dropdown Button */
.dropbtn1 {
  background-color: #3498DB;
  color: white;
  padding: 8px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

/* Dropdown button on hover & focus */
.dropbtn1:hover, .dropbtn1:focus {
  background-color: #2980B9;
}

/* The container <div> - needed to position the dropdown content */
.dropdown1 {
  position: relative;
  display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content1 {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content1 div {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content1 div:hover {background-color: #ddd}

/* Dropdown Button */
.dropbtn2 {
  background-color: #3498DB;
  color: white;
  padding: 8px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

/* Dropdown button on hover & focus */
.dropbtn2:hover, .dropbtn2:focus {
  background-color: #2980B9;
}

/* The container <div> - needed to position the dropdown content */
.dropdown2 {
  position: relative;
  display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content2 {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content2 div {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content2 div:hover {background-color: #ddd}


/* Show the dropdown menu (use JS to add this class to the .dropdown-content container when the user clicks on the dropdown button) */
.show1 {display:block;}


	</style>
	</head>
	<body>
	<?php
    include('../includes/header.php');
    include('sidebar.php');
    ?>
    <main class="mn-inner" >
    <div class="row" >
    <div class="col col-sm-12 col-lg-6	">
    
    <div class="card">
    <div class="clearfix" style="padding: 10px; ">
    	<center>
    	<button class="btn blue btn-secondary float-left" type="button" id="decrement"><i class="fas fa-arrow-circle-left"></i></button>
    	<div class="dropdown1">
  		<button onclick="month_drpdwn()" class="dropbtn1" id="month_choice"><?php echo date("M", strtotime(date("Y-m-d"))); ?></button>
  		<div id="myDropdown1" class="dropdown-content1">
    		<div onclick="month_change(1)">January</div>
    		<div onclick="month_change(2)">February</div>
    		<div onclick="month_change(3)">March</div>
    		<div onclick="month_change(4)">April</div>
    		<div onclick="month_change(5)">May</div>
    		<div onclick="month_change(6)">June</div>
    		<div onclick="month_change(7)">July</div>
    		<div onclick="month_change(8)">August</div>
    		<div onclick="month_change(9)">September</div>
    		<div onclick="month_change(10)">October</div>
    		<div onclick="month_change(11)">November</div>
    		<div onclick="month_change(12)">December</div>
  		</div>
		</div>
		<div class="dropdown2 float-middle">
  		<button onclick="year_drpdwn()" class="dropbtn2" id="year_choice"><?php echo $year; ?></button>
  		<div id="myDropdown2" class="dropdown-content2">
  			<?php 
  				for($i=5; $i>-6; $i--)
    			{   
    				$year_choice.="<div onclick=\"year_change(".($year-$i).")\">";
    				$year_choice.= ($year-$i)."</div>";
   			 	}
   			 	echo $year_choice;
  			?>
  		</div>
		</div>
		<button class="btn blue btn-secondary float-right" type="button" id="increment"><i class="fas fa-arrow-circle-right"></i></button>
	</center>
	</div>
    <div class="card-content">
    	<div id="calend" class="modal-trigge"></div>
	</div> 
    <?php if($mobile==1) { ?>
        <div id="modal1" class="modal modal-fixed-footer" >
            <div class="modal-content" id="details"> </div>    
        </div>    
    <?php } ?>
    </div>
    </div>
    <?php if($mobile==0){ ?>
    <div class="col col-sm-12 col-lg-6 details_parent">
        <div class="card" id="details" style="padding: 10px; "></div>    
    </div>
    <?php } ?>
    </div>
    <div class="row apply_leave" style="display: none;">
        <div class="col col-sm-12 col-lg-6  ">
        <div class="card" style="height: 110px; padding: 10px;">
            <center>
            <form action="apply-leave-step1.php" method="POST">
                <input type="text" id="from" name="from" value="" style="display: none;" required>
                <input type="text" id="to" name="to" value="" style="display: none;" required>
                <div id="leave_apply_details" style="padding-right: 10px; padding-bottom: 10px;"></div>
            <button type="submit" name="apply_begin" id="apply" class="waves-effect waves-light btn blue m-b-xs">Apply Leave</button>
            </form>
            </center>       
        </div>
        </div>        
    </div>
    </main>
	</div>

	</body>
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
	function myFunction(x) {
  		if (x.matches) { // If media query matches
    		document.getElementById("decrement").classList.remove('btn');
    		document.getElementById("increment").classList.remove('btn');
  		}
	}

	var x = window.matchMedia("(max-width: 355px)")
	myFunction(x) // Call listener function at run time
	x.addListener(myFunction) // Attach listener function on state changes
</script>
    <script >
    	<?php 
    		$link = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$pos = strrpos($link, "/");
			$link = substr($link, 0, $pos);
    	?>
      var holidays, leaves;
    	var mlist = [ "Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec" ];
 	 	

    	var d = new Date();
    	var cur_month = d.getMonth()+1;
    	var cur_year = d.getFullYear();
    	var cur_day = d.getDate();

    	var shown_month = cur_month;
		var shown_year = cur_year;

		// document.getElementById("month_choice").value = ((cur_month==12)?0:cur_month);
  //   	document.getElementById("year_choice").value = cur_year;
  		(function($) {
  			change(cur_month, cur_year, cur_day);
  		}(jQuery));
  		/* When the user clicks on the button, 
			toggle between hiding and showing the dropdown content */
		function month_drpdwn() {
  			document.getElementById("myDropdown1").classList.toggle("show1");
		}

		function year_drpdwn() {
  			document.getElementById("myDropdown2").classList.toggle("show1");
		}

		// Close the dropdown menu if the user clicks outside of it
		window.onclick = function(event) {
            var days = document.getElementsByClassName("calendar-day");
            for (i = 0; i < days.length; i++) {
                var day = days[i];
                if (day.classList.contains('selected')) {
                    day.classList.remove('selected');
                }
            }

            if(!(event.target.matches('#modal1') || event.target.parentElement.matches("#modal1"))){
                $("#modal1").fadeOut();
            }

            if (!event.target.matches('.dropbtn1')) {
    			var dropdowns = document.getElementsByClassName("dropdown-content1");
   			 	var i;
    			for (i = 0; i < dropdowns.length; i++) {
      				var openDropdown = dropdowns[i];
     		 		if (openDropdown.classList.contains('show1')) {
        				openDropdown.classList.remove('show1');
      				}
    			}
  			} 

  			if (!event.target.matches('.dropbtn2')) {
    			var dropdowns = document.getElementsByClassName("dropdown-content2");
   			 	var i;
    			for (i = 0; i < dropdowns.length; i++) {
      				var openDropdown = dropdowns[i];
     		 		if (openDropdown.classList.contains('show1')) {
        				openDropdown.classList.remove('show1');
      				}
    			}
  			}

            if (event.target.matches('.calendar-day')) {
                event.target.classList.add("selected");
                var day = event.target.innerHTML;
                var show = "";
                var indx = 0;
                indx = event.target;
                if(indx.getAttribute("data-name")!=null){
                    $(".apply_leave").fadeOut();
                    $(".details_parent").fadeIn();
                    show = '<h4>Holiday</h4><h5><strong>Name: </strong>'+indx.getAttribute("data-name");
                    show+= "</h5>";
                    $("#modal1").fadeIn();
                } else if(indx.getAttribute("data-leaveIndx")!=null){
                    $(".apply_leave").fadeOut();
                    $(".details_parent").fadeIn();
                    var i = indx.getAttribute("data-leaveIndx")-1;
                    show = '<h4>Leave</h4><h5><strong>Leave Type: </strong>'+leaves[i]['type'];
                    show+= '</h5><h5><strong>From: </strong>'+leaves[i]['from'];
                    show+= '</h5><h5><strong>To: </strong>'+leaves[i]['to'];
                    show+= '</h5><h5><strong>Posting Date: </strong>'+leaves[i]['posting_date'];
                    show+= '</h5><h5><strong>Leaves Consumed: </strong>'+leaves[i]['count'];
                    show+= '</h5><h5><strong>Description: </strong>'+leaves[i]['description'];
                    show+= '</h5><h5><strong>Status: </strong>'+(leaves[i]['status']==1?"Approved":"Pending")+"</h5>";

                    $("#modal1").fadeIn();
                } else {
                    $(".details_parent").fadeOut();
                    var temp = shown_year+"-"+(shown_month<10?"0":"")+shown_month+"-"+(day<10?"0":"")+day;
                    //console.log(from);
                    var from = $("#from").val();
                    var to = $("#to").val();
                    if(from!="" && to!=""){
                        $("#from").val("");
                        $("#to").val("");
                    } 

                    var from = $("#from").val();
                    var to = $("#to").val();

                    if(from==""){
                            $("#from").val(temp);
                            $("#leave_apply_details").html("<h5>"+temp+" to -</h5>");
                    } else {
                        $("#to").val(temp);
                        var fr = Date.parse(from);
                        var t = Date.parse(temp);
                        if(t<fr){
                            $("#from").val(temp);
                            $("#to").val(from);
                        }
                        from = $("#from").val();
                        to = $("#to").val();
                        var days_count = (parseInt(Math.abs(t-fr)/86400000)+1);
                        $("#leave_apply_details").html("<h5>"+from+" to "+to+" ( "+days_count+" days )</h5>");
                        // for (var i = parseInt(from.substr(8,9)); i!=parseInt(from.substr(8,9))+1; i++) {
                        //     Things[i]
                        // }
                        // .classList.add("selected");
                        
                        //console.log(document.getElementById("from").value+" to "+document.getElementById("to").value);
                    }
                    $(".apply_leave").fadeIn();
                } 
                document.getElementById("details").innerHTML = show;                
            } else {
                $(".details_parent").fadeOut();
                $(".apply_leave").fadeOut();
            }
		}


    	function month_change(month){
    		var year = document.getElementById("year_choice").textContent;
    		var day = (month==cur_month && year==cur_year)?cur_day:-1;
    		change(month, year, day);
    		shown_month = month;
    		shown_year = year;
    	}

    	function year_change(year){
    		var month = mlist.indexOf(document.getElementById("month_choice").textContent)+1;
    		var day = (month==cur_month && year==cur_year)?cur_day:-1;
    		change(month, year, day);
    		shown_month = month;
    		shown_year = year;
    	}

    	$("#decrement").click(function(){
    		shown_month--;
    		if(shown_month==0){
    			shown_month=12;
    			shown_year--;
    		}
    		var shown_day;
    		if(shown_month==cur_month && shown_year==cur_year){
    			shown_day = cur_day;
    		} else {
    			shown_day = -1;
    		}

    		change(shown_month, shown_year, shown_day);

    	});

    	$("#increment").click(function(){
    		shown_month++;
    		if(shown_month==13){
    			shown_month=1;
    			shown_year++;
    		}
    		var shown_day;
    		if(shown_month==cur_month && shown_year==cur_year){
    			shown_day = cur_day;
    		} else {
    			shown_day = -1;
    		}

    		change(shown_month, shown_year, shown_day);
    	});



    	function change(month, year, day, select=0){

    		console.log("clicked");
    		$.post("//<?php echo $link; ?>/calendar_func.php",
            {
              month: month,
              year: year,
              day: day,
              eid: <?php echo $_SESSION['eid']; ?>
            },
            function(data, status){
            	console.log("Response");
            	console.log("Data: " + data + "\nStatus: " + status);
              	if(status=='success'){//$("#myloader").fadeOut();
              		
                	console.log(data);

                	if(data["status"]==200){         
                		document.getElementById("month_choice").innerHTML = mlist[month-1];
  						document.getElementById("year_choice").innerHTML = year;
  						$("#calend").html(data['ToLoad']);
                        holidays = data['holidays'];
                        leaves = data['leaves'];
                	}else{
                  		console.log("err");
              	 		$("#loader_gif").fadeOut();
                  		$(".card-content").html("<h3>Some Error occured! Sorry for the inconvenience.</h3>");
              		}
              	}else{//$("#myloader").fadeOut();
                	$("#loader_gif").fadeOut();
                  	$(".card-content").html("<h3>Some Error occured! Sorry for the inconvenience..</h3>");
              		console.log("Failed "+data);
                }
            },"json");
    	}
    </script>
</html>
<?php
}
?>