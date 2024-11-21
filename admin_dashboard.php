<?php 

	//  this page shows admin dashboard
    session_start();

    include('DBConnection.php');

    // checked whther user login or logout
    if(isset($_SESSION["admin_uname"])){
            header("location: ./Adminlogin.php?logout=1");
    }
    include("adminheader2.html");
    // $users='';

    // query for taking different data count from tables
    $sql1 = "select count(username) as users from user";
    $users = queryexe($sql1,1,$conn);
    $sql2 = "select count(train_no) as trains from train";
    $trains = queryexe($sql2,2,$conn);
    $sql2 = "select count(ticket_no) as booked from ticket where status = 'booked'";
    $booked = queryexe($sql2,3,$conn);
    $sql2 = "select count(ticket_no) as cancelled from ticket where status = 'cancelled'";
    $cancelled = queryexe($sql2,4,$conn);
    $sql2 = "select count(id) as cancelled from contact";
    $contact = queryexe($sql2,4,$conn);

    function queryexe($sql,$num,$conn){
	    $result = $conn->query($sql);
	    if($result->num_rows > 0){
	    	while($data = $result->fetch_assoc()){
	    		
	    		if($num == 1){
	    			$users = $data['users'];
            	return $users;
	    		}
	    		else if($num == 2){
	    			$trains = $data['trains'];
	    			return $trains;
	    		}
	    		else if($num == 3){
	    			$booked = $data['booked'];
	    			return $booked;
	    		}
	    		else if($num == 4){
	    			$cancelled = $data['cancelled'];
	    			return $cancelled;
	    		}

	    	}
	    }
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
	<style type="text/css">
			
			
			
			.row{
				/*background: black;*/
				/*display: inline-flex;*/
			}
			.col1{
				background-image: linear-gradient(to right, red , orange);
				height: 100px;
				/*width: 300px;*/
				margin-left: 0px;
				border-radius: 5px;
			}
			.col2{
				background-image: linear-gradient(to right, green , orange);
				height: 100px;
				/*width: 300px;*/
				border-radius: 5px;
				margin-left: 0px;
			}
			.col3{
				background-image: linear-gradient(to right, blue , orange);
				height: 100px;
				/*width: 60px;*/
				margin-left: 0px;
				border-radius: 5px;
			}
			.col4{
				background-image: linear-gradient(to left, blue , orange);
				height: 100px;
				/*width: 00px;*/
				margin-left: 0px;
				border-radius: 5px;
			}
			.cust-font{
				font-size: 32px;
				text-align: center;
				font-family: 'Showcard Gothic';
			}
			.cust-font2{
				margin-top: 0px;
				font-size: 20px;
				font-family: 'Baskerville Old Face';
				font-weight: bold;
			}
			
			
	</style>
	
</head>
<body>
	<!-- header Body -->
	
		<div class="row">
		    <div class="col-12 col-sm-3">    
			   <?php include("adminmenu.html"); ?>
		    </div>
    		<div class="col-12 col-sm-8">
				<div class="bg-black">
					<div class="row mt-5">
						<div class="col-12 col-sm-5 col1 p-3 m-2">
							<div class="row ">
								<div class="col-6">
									<img src="asset/img/logo/register.png" width="70">
								</div>
								<div class="col-6">
										<h2><span class="cust-font">&nbsp;	<?php  echo $users;  ?></span>
										<p class="cust-font2"> Registered Users</p>
									</h2>
								</div>
							</div>
						</div>
						<div class="col-12 col-sm-5 col2 m-2 p-3">
							<div class="row ">
								<div class="col-6">
									<img src="asset/img/logo/train3.png" width="70">
								</div>
								<div class="col-6">
										<h2><span class="cust-font">&nbsp;	<?php  echo $trains;  ?></span>
										<p class="cust-font2">Available Trains</p>
									</h2>
								</div>
							</div>
						</div>
						<div class="col-12 col-sm-5 col4 m-2 p-3">
							<div class="row ">
								<div class="col-6">
									<img src="asset/img/logo/ticket.png" width="70">
								</div>
								<div class="col-6">
										<h2><span class="cust-font">&nbsp;	<?php  echo $booked;  ?> </span>
										<p class="cust-font2">Booked Tickets</p>
									</h2>
								</div>
							</div>
						</div>
						<div class="col-12 col-sm-5 col3 m-2 p-3">
							<div class="row">
								<div class="col-6">
									<img src="asset/img/logo/ticket2.png" width="70">
								</div>
								<div class="col-6">
										<h2><span class="cust-font">&nbsp;	<?php  echo $cancelled;  ?></span>
										<p class="cust-font2">Cancelled Tickets</p>
									</h2>
								</div>
							</div>
						</div>
						<div class="col-12 col-sm-5 col2 m-2 p-3">
							<div class="row ">
								<div class="col-6">
									<img class="" src="asset/img/logo/feedback.png" width="70">
								</div>
								<div class="col-6">
									<h2>
										<span class="cust-font">&nbsp;<?php  echo $contact;  ?> </span>
										<p class="cust-font2">Feedbacks</p>
									</h2>
								</div>
							</div>
						</div>
					</div>	
				</div>
			</div>

<!--	<div class="footer">
		<div class="foinfo">
			<p style="font-size: 18px">Copyright© 2019. All Rights Reserved | Design by Bappa_Developers
			</p>
			<p style="font-size: 22px;color: dodgerblue">Cyberworld.com</p>

		</div>  -->

	</div>
</body>
</html>