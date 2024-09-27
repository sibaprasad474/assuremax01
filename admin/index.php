<?php
session_start(); 

if (!isset($_SESSION['user_email'])) {
    header('Location: ../index.html');
    exit();
}

$user_name = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'Guest';

require_once '../db/db.php';
include_once('./includes/header.php');

$query = "SELECT full_name, dob FROM customers";
$stmt = $conn->prepare($query);
$stmt->execute();
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Debug: Check the fetched data
echo "<script>console.log('Customers: " . json_encode($customers) . "');</script>";

$today = date('Y-m-d');
$birthdaysToday = [];
foreach ($customers as $customer) {
    $dob = date('Y-m-d', strtotime($customer['dob']));
    
    // Debug: Compare DOB with today's date
    echo "<script>console.log('DOB: " . $dob . " vs Today: " . $today . "');</script>";
    
    if (date('m-d', strtotime($dob)) === date('m-d', strtotime($today))) {
        $birthdaysToday[] = $customer['full_name'];
    }
}

// Debug: Check if birthdaysToday array is populated
if (!empty($birthdaysToday)) {
    echo "<script>console.log('Birthday Alert Triggered');</script>";
}
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Dashboard</h1>
            <p>Welcome, <?php echo htmlspecialchars($user_name); ?>!</p>
        </div>
    </div>

    <?php if (!empty($birthdaysToday)): ?>
        <div id="birthdayNotification" style="position: fixed; top: 20vh; width: 40%; background-color:#fff; color: #000; padding: 5px; z-index: 1000;">
            <marquee behavior="scroll" direction="left" scrollamount="10">
                <?php foreach ($birthdaysToday as $birthdayPerson) {
                    echo htmlspecialchars($birthdayPerson) . "'s birthday 🎂! ";
                } ?>
            </marquee>
        </div>
    <?php endif; ?>

    <div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"></div>
                        <div>Customers</div>
                    </div>
                </div>
            </div>
            <a href="customers.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-tasks fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">12</div>
                        <div>New Tasks!</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

    <!-- Additional Panel 1 -->
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-bell fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">5</div>
                        <div>Alerts</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

    <!-- Additional Panel 2 -->
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-support fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">9</div>
                        <div>Support Tickets</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-8">
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-8 -->
        <div class="col-lg-4">
            <!-- /.panel .chat-panel -->
        </div>
        <!-- /.col-lg-4 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<?php include_once('./includes/footer.php'); ?>
