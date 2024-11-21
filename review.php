<?php 
// User can check their entered details here
session_start();

include('DBConnection.php');
include('Details.php');

// Check whether user is logged in
if (!isset($_SESSION["uname"])) {
    header("location: ./index.php?logout=1");
}

include("header2.php");

// This session is set on psg_details.php page to avoid reinsertion in DB due to resubmitting the page
$temp = $_SESSION["temp"] ?? null;
$uname = $_SESSION["uname"];

// Proceed if the user clicked on the continue button
if (isset($_POST['continue'])) {
    // Initialize the count for the number of travellers
    $count = 0;

    // Retrieve form data
    $src = $_POST['src'];
    $dest = $_POST['dest'];
    $class = $_POST['class'];
    $date = $_POST['date'];
    $station_no = $_POST['station_no'];
    $train_name = $_POST['train_name'];
    $train_no = $_POST['train_no'];
    $dep_time = $_POST['dep_time'];
    $arr_time = $_POST['arr_time'];
    $duration = $_POST['duration'];
    $email = $_POST['email'];
    $phno = $_POST['phno'];
    $fare = $_POST['fare'];

    // Insert into ticket table
    if ($temp) {
        $sql = "INSERT INTO ticket (status, date, phno, email, train_no, station_no, username) VALUES ('booked', '$date', '$phno', '$email', '$train_no', '$station_no', '$uname')";
        
        if ($conn->query($sql) === TRUE) {
            // Successfully inserted
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Query to get the ticket number of the current user
    $sql1 = "SELECT * FROM ticket WHERE date = '$date' AND username = '$uname'"; 
    $result1 = $conn->query($sql1);
    if ($result1->num_rows > 0) {
        while ($data = $result1->fetch_assoc()) {
            $ticket_no = $data['ticket_no'];
            if (isset($ticket_no)) {
                $pnr = $ticket_no;
                // Store PNR into session 
                $_SESSION['pnr'] = $pnr;  
            }
        }
    }

    // If session['temp'] is true, insert passenger data
    if ($temp) {
        // Function for inserting data into passenger table
        function insertData($name, $age, $gender, $pnr, $conn, $train_no) {
            $sql2 = "INSERT INTO passanger (p_name, p_age, p_gender, ticket_no) VALUES ('$name', '$age', '$gender', '$pnr')";
            if ($conn->query($sql2) === TRUE) {
                // Decrement the available seat count
                $sql5 = "UPDATE train SET seat_avail = seat_avail - 1 WHERE train_no = '$train_no'";
                if ($conn->query($sql5) === TRUE) {
                    // Seat updated
                } else {
                    echo "Error: " . $conn->error;
                }
                // Set session['temp'] to false to prevent reinsertion on resubmitting the page
                $_SESSION["temp"] = false;
            }
        }

        // Insert up to 5 traveller details and increment count
        for ($i = 1; $i <= 5; $i++) {
            if (!empty($_POST["name$i"]) && !empty($_POST["age$i"]) && !empty($_POST["gender$i"])) {
                insertData($_POST["name$i"], $_POST["age$i"], $_POST["gender$i"], $pnr, $conn, $train_no);
                $count++;
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
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="asset/font-awesome/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="asset/css/custom.css">
    
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

    <!-- Include header -->

    <!-- Box shows process logo -->
    <div class="container border border-primary mt-5 mb-5 p-4">
        <div class="row">
            <div class="col-2 offset-1 sm-hide">
                <div class="bg-primary p-3 text-center logo border border-primary">
                    <img src="asset/img/logo/passangerW.png">            
                </div>
            </div>
            <i class="sm-hide fa fa-arrow-circle-right text-primary mt-4 pl-5"></i>
            <div class="col-8 col-sm-2 offset-1">
                <div class="p-3 text-center logo border border-primary">
                    <img src="asset/img/logo/reviewG.png">
                </div>
            </div>
            <i class="sm-hide fa fa-arrow-circle-right mt-4 text-lightdark pl-5"></i>
            <div class="col-2 offset-1 sm-hide">
                <div class="p-3 text-center logo border">
                    <img class="text-danger" src="asset/img/logo/cardG.png">
                </div>
            </div>
        </div>
    </div>

    <!-- Input the details -->
    <div class="container-fluid pl-5 pb-5">
        <div class="row">
            <!-- Col-8 left side -->
            <div class="col-8">
                <h5 class="text-bold-16">
                    <span class="text-blue"><?php echo $train_name; ?></span>&nbsp;
                    <span class="text-black">(<?php echo $train_no; ?>)</span>
                    <span class="strong fs-12 text-666 font-light"><b><?php echo $class; ?> | <?php echo $count; ?> Traveller</b></span>
                </h5>
                <h6 class="strong fs-12 text-666">
                    <span class=""><b>From Station</b></span>
                    <span class="offset-4"><b>Arrival Station</b></span>
                </h6>
                <h5 class="text-bold-16 text-black">
                    <span class="">
                        <img src="asset/img/logo/rail_icon.png" width="20" class="sm-hide">
                        <?php echo $src; ?>
                    </span>
                    <span class="offset-3">
                        &nbsp;&nbsp;&nbsp;<img src="asset/img/logo/rail_icon.png" width="20" class="sm-hide">
                        <?php echo $dest; ?>
                    </span>
                </h5>
                <h6 class="strong fs-12 text-666">
                    <span class=""><b> Departure: <?php echo $date; ?> | <?php echo $dep_time; ?> AM</b></span>
                    <span class="offset-2"><b> Arrival: <?php echo $date; ?> | <?php echo $arr_time; ?> PM</b></span>
                </h6>  

                <!-- Card for travelling passengers -->
                <div class="card mt-4">
                    <div class="card-header bg-primary p-2">
                        <h5 class="text-light"><b>Travelling Passengers</b></h5>
                    </div>
                    
                    <?php 
                    $sql3 = "SELECT * FROM passanger WHERE ticket_no = '$pnr'";
                    $result2 = $conn->query($sql3);
                    if ($result2->num_rows > 0) {
                        while ($data = $result2->fetch_assoc()) {
                    ?>
                    <div class="card-body">
                        <span class="fs-20 text-blue"><b><?php echo $data['p_name']; ?></b></span>
                        <span class="text-bold text-blue">&nbsp;&nbsp;&nbsp;<?php echo $data['p_age']; ?> | <?php echo $data['p_gender']; ?></span>
                    </div>
                    <?php 
                        }
                    }
                    ?>
                </div>

                <form action="./payment.php" method="post"> 
                    <!-- Send hidden data -->
                    <input type="hidden" name="src" value="<?php echo $src; ?>"> 
                    <input type="hidden" name="dest" value="<?php echo $dest; ?>"> 
                    <input type="hidden" name="date" value="<?php echo $date; ?>"> 
                    <input type="hidden" name="train_no" value="<?php echo $train_no; ?>"> 
                    <input type="hidden" name="station_no" value="<?php echo $station_no; ?>"> 
                    <input type="hidden" name="fare" value="<?php echo $fare; ?>"> 
                    <input type="hidden" name="email" value="<?php echo $email; ?>"> 
                    <input type="hidden" name="phno" value="<?php echo $phno; ?>"> 
                    <input type="hidden" name="ticket_no" value="<?php echo $pnr; ?>"> 
                    <input type="hidden" name="count" value="<?php echo $count; ?>"> 
                    <button type="submit" class="btn btn-primary mt-3">Proceed to Payment</button>
                </form>
            </div>
            <!-- Col-4 right side -->
            <div class="col-4">
                <div class="shadow-cust p-3 mt-5">
                    <h5><b>Ticket Details</b></h5>
                    <p><span><b>Ticket No:</b></span> <span class="text-success"><?php echo $pnr; ?></span></p>
                    <p><span><b>Date:</b></span> <span class="text-black"><?php echo $date; ?></span></p>
                    <p><span><b>Mobile No:</b></span> <span class="text-black"><?php echo $phno; ?></span></p>
                    <p><span><b>Email:</b></span> <span class="text-black"><?php echo $email; ?></span></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>