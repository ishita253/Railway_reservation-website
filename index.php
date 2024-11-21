<?php 
    session_start();
    include('Details.php');
    include('DBConnection.php'); 

    // this session is set in pnrstatus page because of reupdating data 
    // and make it unset here so next time new data will update in pnrstatus page
    if(isset($_SESSION['update'])){
         unset($_SESSION['update']);
    }

    //this checked when user redirect from login page. 
    //if login successe it shows msg
    if (isset($_GET['success']) && $_GET['success'] == 1) {
            echo "<script> alert('your are logged in'); </script>";

    } //otherwise it check  for logout 
    else if (isset($_GET['logout']) && $_GET['logout'] == 1) {
            echo "<script> alert('your are logged out'); </script>";
    }

    //check whether user login or not
    if(isset($_SESSION["uname"])){
        $uname = $_SESSION["uname"];
            include("header2.php");
    }
    else{
            include("header.html");
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

    <!-- :end of optional css -->


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="asset/js/jquery-3.4.1.slim.min.js"></script>
    <script src="asset/js/popper.min.js"></script>
    <script src="asset/js/bootstrap.min.js"></script>
    <script src="asset/js/validation.js"></script>
    <style>

         #bg-custom{
            background-color:rgba(2,2,2,0.8);
        }
        #m-cust{
            margin-right: 250px;
            margin-top: 60px; 
        }
        .bg-black{
            background-color:black;
        }
        .bg-img{
            background-image: url('asset/img/7.jpg');
            /*background-repeat: no-repeat;*/
            background-size: 100%;
            max-width: 1900px;
            min-height: 700px;
            

            /*opacity: 0.8;*/
        }
        @media(max-width: 400px){
            .bg-img{
                background-image: url('asset/img/5.jpg');
                background-size: auto;
                background-repeat: no-repeat;
                /*background-position: center*/

            }
        }

        .bg-img2{
            background-image:url('asset/img/5.jpg'); 
            background-size: 100%;
        }
        .pnr{
            background-color: white;
            color: black;
            /*width: 340px;*/
            padding-top: 10px;
            box-shadow: 2px 2px 18px 10px #222;
            border-radius: 2px;
        }
        
        .fs-1{
            font-size: 42px;
            font-family: Tempus Sans ITC;
            margin-top: 50px;
        }
        .fs-2{
            font-size: 18px;
            font-family: Yu Gothic Light;
            font-weight: lighter;
            margin-bottom: 50px; 
        }
        .main-name{
            font-size: 50px;
            font-family: Arial Rounded MT Bold;
            margin-top: 0px;
            background-color: rgba(2,2,2,0.2);
            /*background-color: #116;*/
            border-radius: 5px;
            width:560px;
            padding-left: 50px;

        }

    </style>

</head>
<body >
    
    <!-- include header -->
	<!-- <?php //include('header.html'); ?> -->





    <!-- container -->
    <!-- 1st row -->
    <!-- its show box for serching train and image that used @background -->
    <div class="row bg-img text-light">
        <!-- col 1 -->
        <div class="col-12 col-sm-12 col-md-4 offset-1">
            <!-- PNR status box -->
            <div class="row pnr m-5 text-center">
                    <div class="col-12 mt-3">
                        <span><img src="asset/img/logo/rail_icon.png"></span><br>
                        <span class="fs-1">BOOK</span>
                        <span class="fs-2" >YOUR TICKET</span>
                    </div>
                    <div class="col-12 mt-4">
                       <!-- form tag -->
                        <form action="./train_list.php" method="post">
                            <div class="input-group">   
                                <input type="text" name="src" class="form-control hvr-shadow" placeholder="From*" required> 
                            </div><!-- group1 ends -->
                            <br>
                            <div class="input-group">
                                <input type="text" name="dest" class="form-control hvr-shadow" placeholder="To*" required>
                            </div> <!-- group2 ends-->  
                            <br>
                            <div class="input-group">
                                <input type="date" name="date" class="form-control hvr-shadow" placeholder="" required>
                                <div class="input-group-append">
                                    <span class="input-group-text text-dark ">
                                           <img src="asset/img/logo/cal.png" width="20" height="20">
                                    </span>
                                </div>
                            </div> <!-- group3 ends-->
                            <br>
                            <div class="input-group">
                                <select name="class" class="custom-select hvr-shadow">
                                    <option class="" value="ALL">All Classes</option>
                                    <option class="" value="AC">AC</option>
                                    <option class="" value="SL">Sleeper(SL)</option>
                                </select>
                            </div> <!-- group4 ends-->
                            <br>
                            <div class="input-group">
                                <input class="btn text-light bg-blue btn-block hvr-shadow" type="submit" value="Find Trains" >
                            </div><br>  
                        </form>
                    </div>
            </div>                    
        </div>

        <!-- col 2 and title of system-->
        <div class="sm-hide col-sm-6 offset-0">
            <div class="text-left main-name">
                <span>INDIAN RAILWAYS</span>
            </div>
        </div>
    </div> <!-- ends of row first -->


    <div class="jumbotron bg-secondary"></div>
    <div class="jumbotron bg-secondary"></div>
    <div class="jumbotron bg-secondary"></div>



    <!-- include footer -->
    <?php include('footer.html'); ?>
	

</body>
</html>