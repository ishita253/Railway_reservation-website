<?php 
    
    // view train details
    session_start();

    include('DBConnection.php');

    // checked whther user login or logout
    if(isset($_SESSION["admin_uname"])){
            header("location: ./Adminlogin.php?logout=1");
    }
    include("adminheader2.html");

    $count = 1;

    // select all train name & nos for shows in select box
    $sql1 = "select train_no,train_name from train";

    $result1 = $conn->query($sql1);
    
    // execute if admin clicked on view btn
    if (isset($_GET['show'])) {
        $train_no = $_GET['train_no'];

        // execute if admin want all train detaills otherwise execute else part for specific train details
        if($train_no == "all"){
            $sql2 = "select t.train_no,t.train_name,s.source,s.arrival_time,s.destination,
                s.depart_time,s.duration,s.station_no from train t,station s 
                where s.train_no = t.train_no";
        }
        else{
            $sql2 = "select t.train_no,t.train_name,s.source,s.arrival_time,s.destination,
                s.depart_time,s.duration,s.station_no from train t,station s 
                where s.train_no = t.train_no and t.train_no = '$train_no'";
        }
        $result2 = $conn->query($sql2);
    }

 ?>
<!doctype html>
<html lang="en">
<head>
	<title>IR</title>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" type="icon/png" href="asset/img/logo/rail_icon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="asset/css/bootstrap.min.css">

    <!-- :start of optional css-->

    <!-- font-awesome for icon -->
    <link rel="stylesheet" href="asset/font-awesome/css/all.min.css">

    <!-- animation css -->
    <link rel="stylesheet" href="asset/css/animate.css">

    <!-- hover css animations -->
    <link rel="stylesheet" href="asset/css/hover-min.css">

    <!-- custom css -->
    <link rel="stylesheet" type="text/css" href="asset/css/custom.css">

    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="asset/js/jquery-3.4.1.slim.min.js"></script>
    <script src="asset/js/popper.min.js"></script>
    <script src="asset/js/bootstrap.min.js"></script>
    <script src="asset/js/validation.js"></script>
    <style>




        .logo{
            border-radius: 1000px;
        }
        div.shadow-cust{
            width: 230px;
            background-color: #DCEEFF;
       }
       .shadow-cust{
            box-shadow: 3px 3px 5px 0px #333;
       }
       i.fa-circle{
            box-shadow:inset 0px 0px 3px 0px #222;
            border-radius: 10px;  
       }


    </style>

</head>
<body class="bg-img">
    <div class="row">
        <div class="col-12 col-sm-3">    
    	   <?php include("adminmenu.html"); ?>
        </div>
        <div class="col-12 col-sm-8">
            <form name="payForm" onsubmit="return(pnrvalid());" class="m-5 p-5 border bg-light" action="" method="get">
            <div class="row">
                <div class="col-12">
                    <h4 class="navbar-brand text-primary">Train Number:</h4>
                </div>
                <div class="col-8">
                   <select name="train_no" class="input-group form-control" value="trains">
                        <option class="form-control" value="all">All train</option>
                    <?php if($result1->num_rows > 0){
                        while($data1 = $result1->fetch_assoc()){
                     ?>
                        <option class="form-control" value="<?php echo $data1['train_no']; ?>"><?php echo "( ".$data1['train_no']." ) ".$data1['train_name'] ?></option>
                    <?php 
                        } }
                     ?>
                    </select>
                </div>
                <div class="col-4">      
                    <input type="submit" class="btn btn-dark text-light" value="Get Status" name="show">
                </div>
            </div>
            </form>

        <!-- table for trains records -->
    <div class=" bg-light">
        <table class="table  table-hover text-center">
            <?php 
                 if (isset($_GET['show'])) {

                if($result2->num_rows > 0){ ?>
            <tr class="table-success">
                <th>Sr.no</th>
                <th>Train Name</th>
                <th>Train No.</th>
                <th>Source Location</th>
                <th>Destination location</th>
                <th>Departure Time</th>
                <th>Arrival Time</th>
            </tr>
             <?php   while($data2 = $result2->fetch_assoc()){
             ?>
            <tr class="text-bold">
                <td><?php echo $count; ?></td>
                <td><?php echo $data2['train_name']; ?></td>
                <td><?php echo $data2['train_no']; ?></td>
                <td><?php echo $data2['source']; ?></td>
                <td><?php echo $data2['destination']; ?></td>
                <td><?php echo $data2['depart_time']; ?></td>
                <td><?php echo $data2['arrival_time']; ?></td>
            </tr>
            <?php $count++; }}} ?>
        </table>
    </div>
        </div>

    </div>
</body>
</html>



