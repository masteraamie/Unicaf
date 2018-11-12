<?php
session_start();

if(!isset($_SESSION['user']))
{
    header("Location: ../index.php");
}

if(!isset($_SESSION['user']))
{
    header("Location: ../index.php");
}

require_once 'master_engine/connection.php';
require_once 'master_engine/database_io.php';

$query2 = "SELECT SUM(Total) , COUNT(ID) , SUM(Profit) , SUM(Cost) FROM " . TBL_BILLING . " WHERE Date = ?";


$unpaid = $earnings = $profit = $customers  = 0;

$day = date('Y-m-d');


$dbIO = new DatabaseIO();
$earnings = $dbIO->get_entry(TBL_BILLING , "SUM(Total)" , "Status = 1 and Date" , $day);
$customers = $dbIO->get_entry(TBL_BILLING , "COUNT(ID)" , "Date" , $day);
$profit = $dbIO->get_entry(TBL_BILLING , "SUM(Profit)" , "Status = 1 and Date" , $day);
$unpaid = $dbIO->get_entry(TBL_BILLING , "COUNT(ID)" , "Status = 0 and Date" , $day);

$query1 = "SELECT Name , Status FROM " . TBL_ATTEND . " WHERE Date = ?";

$connection2 = new mysqli(HOST , USER , PASSWORD , DB_NAME);
$command2 = $connection2->prepare($query1);
$command2->bind_param("s" , $day);
$command2->execute();
$command2->bind_result($Name , $Status);
$command2->store_result();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Welcome Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="icon" href="../img/favicon.png">
    <link href="../css/font-awesome.css" rel="stylesheet">
    <link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href="main.css" rel="stylesheet">
</head>
<body>

<noscript>
    <META HTTP-EQUIV="Refresh" CONTENT="0;URL=index.php">
</noscript>

<div class="sidebar">

    <div class="sidebar-container">

        <ul>
            <a href="../index.php">
                <li class="active"><span class="fa fa-dashboard"></span> Dashboard</li>
            </a>
            <a href="stock/view_stock.php">
                <li><span class="fa fa-book"></span> Stock</li>
            </a>
            <a href="supplier/manage_supp.php">
                <li><span class="fa fa-truck"></span> Supplier</li>
            </a>
            <a href="menuitems/index.php">
                <li><span class="fa fa-list"></span> Food / Menu Items</li>
            </a>
            <a href="products/index.php">
                <li><span class="fa fa-barcode"></span> Products</li>
            </a>
            <a href="property/manage_prop.php">
                <li><span class="fa fa-building"></span> Property</li>
            </a>
            <a href="department/manage_dep.php">
                <li><span class="fa fa-home"></span> Department</li>
            </a>
            <a href="expenditure/manage_exp.php">
                <li><span class="fa fa-money"></span> Expenditure</li>
            </a>
            <a href="staff/index.php">
                <li><span class="fa fa-users"></span> Staff</li>
            </a>
            <a href="user/manage_user.php">
                <li><span class="fa fa-user"></span> User</li>
            </a>
            <a href="sales/index.php">
                <li><span class="fa fa-dollar"></span> Sales</li>
            </a>
        </ul>

    </div>

</div>

<div class="content">


    <?php include_once("header.php"); ?>



    <div class="container-fluid" style="padding-top: 50px">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading"><span class="fa fa-line-chart"></span> Today's Report</div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-3" >
                                    <div class="box red">
                                        <h6>Pending Bills</h6>
                                        <h1><?php echo $unpaid == "" ? 0:$unpaid; ?></h1>
                                    </div>
                                </div>
                                <div class="col-lg-3" >
                                    <div class="box green">
                                        <h6>Earnings</h6>
                                        <h1><?php echo $earnings == "" ? 0:$earnings; ?></h1>
                                    </div>
                                </div>
                                <div class="col-lg-3" >
                                    <div class="box blue">
                                        <h6>Profit</h6>
                                        <h1><?php echo $profit == "" ? 0:$profit; ?></h1>
                                    </div>
                                </div>
                                <div class="col-lg-3" >
                                    <div class="box orange">
                                        <h6>Orders</h6>
                                        <h1><?php echo $customers == "" ? 0:$customers; ?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading"><span class="fa fa-clock-o"></span> Today's Attendance</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table">

                                <?php
                                if($command2->num_rows > 0)
                                {?>
                                <thead>
                                <tr>
                                    <td>Member Name</td>
                                    <td>Status</td>
                                </tr>
                                </thead>
                                <tbody>

                                <?php    while($command2->fetch()) {
                                        echo "<tr>";
                                        echo "<td>$Name</td>";
                                        echo  "<td>";
                                        if($Status == "Present")
                                            echo "<label class='label label-success'>".$Status."</label>";
                                        elseif($Status == "Absent")
                                            echo "<label  class='label label-danger'>".$Status."</label>";
                                        elseif($Status == "Leave")
                                            echo "<label  class='label label-default'>".$Status."</label>";


                                        echo "</td></tr>";
                                    }
                                }
                                else
                                    echo "<h2 style='text-align: center;'>No Attendance</h2>";
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





</div>




<!-- script references -->
<script src="../js/jquery.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>

<script>


    $(document).ready(function(){


    });

</script>


</body>
</html>