<?php 
session_start();
// Include database connection file
include("DBConnection.php");
include("Details.php");

// Check if user is logged in
if (!isset($_SESSION["uname"])) {
    header("location: ./index.php?logout=1");
    exit();
}

$uname = $_SESSION["uname"];

// Check and store PNR number if set
$pnr = $_SESSION["pnr"] ?? '';

// Initialize variables with default values to avoid undefined variable warnings
$train_name = $_POST['train_name'] ?? '';
$train_no = $_POST['train_no'] ?? '';
$class = $_POST['class'] ?? '';
$count = $_POST['count'] ?? 0;
$date = $_POST['date'] ?? '';
$src = $_POST['src'] ?? '';
$dest = $_POST['dest'] ?? '';
$dep_time = $_POST['dep_time'] ?? '';
$arr_time = $_POST['arr_time'] ?? '';
$fare = $_POST['fare'] ?? '';
$phno = $_POST['phno'] ?? '';

include("header2.php");

// Check if continue button was clicked
if (isset($_POST['continue1'])) {
    $count = $_POST['count'] ?? 0;
    $phno = $_POST['phno'] ?? '';
    $fare = $_POST['fare'] ?? '';
}

// Check if user clicked on cancel button to cancel ticket
if (isset($_POST['cticket'])) {
    // Delete particular PNR if user clicked on cancel button
    $sql = "DELETE FROM ticket WHERE ticket_no = '$pnr'";
    if ($conn->query($sql) === true) {
        // Update the available seats for the particular train
        $sql5 = "UPDATE train SET seat_avail = seat_avail + 1 WHERE train_no = '$train_no'";
        if ($conn->query($sql5) !== true) {
            echo $conn->error;
        }

        echo "<script> alert('Ticket cancelled'); </script>";
        $_SESSION["pnr"] = null;
        unset($_SESSION["pnr"]);
        echo "<script> document.location.href='./index.php'; </script>";
    } else {
        echo "<script> alert('Ticket already cancelled'); </script>";
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
    <link rel="stylesheet" href="asset/font-awesome/css/all.min.css">
    <link rel="stylesheet" href="asset/css/animate.css">
    <link rel="stylesheet" href="asset/css/hover-min.css">
    <link rel="stylesheet" type="text/css" href="asset/css/custom.css">

    <!-- Optional JavaScript -->
    <script src="asset/js/jquery-3.4.1.slim.min.js"></script>
    <script src="asset/js/popper.min.js"></script>
    <script src="asset/js/bootstrap.min.js"></script>
    <script src="asset/js/validation.js"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=AZgUvqDidJv_eyD6j5IMJOfuK1MnoYuy6t0Z3oPb9-NTPk5HX7GExNgmcD-A4Rh_pcdz3DbjS_Ra1oJX"></script> <!-- Add your PayPal Client ID here -->
    <style>
        .logo {
            border-radius: 1000px;
        }
        div.shadow-cust {
            width: 230px;
            background-color: #DCEEFF;
        }
        .shadow-cust {
            box-shadow: 3px 3px 5px 0px #333;
        }
        i.fa-circle {
            box-shadow: inset 0px 0px 3px 0px #222;
            border-radius: 10px;  
        }
    </style>
</head>
<body class="bg-light">
    
    <!-- box shows process logo -->
    <div class="container border border-primary mt-5 mb-5 p-4">
        <div class="row">
            <div class="col-2 offset-1 sm-hide">
                <div class="p-3 text-center logo bg-primary border border-primary">
                    <img src="asset/img/logo/passangerW.png">            
                </div>
            </div>
            <i class="sm-hide fa fa-arrow-circle-right text-primary mt-4 pl-5"></i>
            <div class="col-2 offset-1 sm-hide">
                <div class="p-3 text-center logo bg-primary border border-primary">
                    <img src="asset/img/logo/reviewW.png">
                </div>
            </div>
            <i class="sm-hide fa fa-arrow-circle-right mt-4 text-primary pl-5"></i>
            <div class="col-12 col-sm-2 offset-1">
                <div class="p-3 text-center logo border border-primary">
                    <img class="text-danger" src="asset/img/logo/cardG.png">
                </div>
            </div>
        </div>
    </div>

    <!-- input the details -->
    <div class="container-fluid pl-5 pb-5">
        <div class="row">
            <!-- col-8 left side -->
            <div class="col-8">
                <div class="col-12 alert alert-primary text-bold">Payment should be accepted via PayPal</div>
                
                <!-- payment form -->
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <form id="paypal-form">
                                    <div class="mt-3">
                                        <div id="paypal-button-container"></div>
                                    </div>
                                </form>
                                <!-- button for cancel the ticket -->
                                <form action="" method="post">
                                    <button name="cticket" class="text-bold btn hvr-grow"><i class="fas fa-ticket-alt "></i> Cancel Ticket</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- col-8 ends -->
            
            <!-- right side showing the ticket details -->
            <div class="col-12 col-sm-3 pl-4">
                <div class="card shadow-cust">
                    <div class="ml-4 mt-1 text-white">
                        <i class="fa fa-xs fa-circle ml-2 pt-1"></i>
                        <i class="fa fa-xs fa-circle ml-4 pt-1"></i>
                        <i class="fa fa-xs fa-circle ml-4 pt-1"></i>
                        <i class="fa fa-xs fa-circle ml-4 pt-1"></i>
                        <i class="fa fa-xs fa-circle ml-4 pt-1"></i>
                    </div>
                    <hr class="mt-1">
                    <div class="card-body pt-0 pb-0 text-center">
                        <img src="asset/img/logo/logo.png" width="40" height="40" class="mb-2">
                        <h5 class="text-bold-16 font-light">
                            <span class="text-blue"><?php echo htmlspecialchars($train_name); ?></span>&nbsp;
                            <span class="text-black">(<?php echo htmlspecialchars($train_no); ?>)</span>
                        </h5>
                        <h6 class="strong fs-12 text-666">
                            <span class=""><?php echo htmlspecialchars($class); ?>, <?php echo htmlspecialchars($count); ?> Traveller</span>
                        </h6>
                        <div class="alert-primary p-1">
                            <h6 class="strong fs-12 text-666">
                                <span class=""><?php echo htmlspecialchars($date); ?></span>
                            </h6>
                            <h5 class="text-bold-16 font-light">
                                <span class="text-black"><?php echo htmlspecialchars($src); ?></span>&nbsp;
                            </h5>
                            <h6 class="strong fs-12 text-666">
                                <span class="">Departure: <?php echo htmlspecialchars($dep_time); ?></span>
                            </h6>
                            <i class="fa fa-arrow-circle-right text-dark"></i>
                            <h6 class="strong fs-12 text-666">
                                <span class=""><?php echo htmlspecialchars($date); ?></span>
                            </h6>
                            <h5 class="text-bold-16 font-light">
                                <span class="text-black"><?php echo htmlspecialchars($dest); ?></span>&nbsp;
                            </h5>
                            <h6 class="strong fs-12 text-666">
                                <span class="">Arrival: <?php echo htmlspecialchars($arr_time); ?></span>
                            </h6>
                        </div>
                        <h6 class="text-bold fs-12 text-black">
                            <span class="float-left">PNR NO: </span>
                            <span class="float-right"><?php echo htmlspecialchars($pnr); ?></span>
                        </h6>
                        <h5 class="text-bold fs-12 text-black">
                            <span class="float-left">Total Fare: </span>
                            <span class="float-right">INR <?php echo htmlspecialchars($fare); ?></span>
                        </h5>
                    </div>
                </div>
            </div> <!-- col-3 ends -->
        </div> <!-- row ends -->
    </div> <!-- container-fluid ends -->

    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?php echo $fare; ?>'
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    // Display a success message
                    alert('Payment completed successfully!');
                    // Redirect to index.php
                    window.location.href = './index.php';
                });
            },
            onError: function(err) {
                console.error('PayPal error:', err);
                alert('Payment could not be completed. Please try again.');
            }
        }).render('#paypal-button-container');
    </script>

</body>
</html>