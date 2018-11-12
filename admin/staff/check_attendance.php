<?php
session_start();

if(!isset($_SESSION['user']))
{
    header("Location: ../login.php");
}
require_once("../master_engine/validations.php");
require_once("../master_engine/upload_modules.php");
require_once("../master_engine/database_io.php");


$errors = array();

$dbIO = new DatabaseIO();

$namesArr =  $dbIO->get_entries_with_id(TBL_STAFF , "Name");

$months = array( '1' => 'January' , '2' => 'February' , '3' => 'March' , '4' => 'April' ,
    '5' => 'May' , '6' => 'June' , '7' => 'July' , '8' => 'August' ,'9' => 'September' ,'10' => 'October' ,'11' => 'November'
,'12' => 'December' );

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Welcome Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="icon" href="../../img/favicon.png">
    <link href="../../css/font-awesome.css" rel="stylesheet">
    <link href="../../bootstrap/css/bootstrap.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href="../main.css" rel="stylesheet">

    <style>

        .show_attendance{
            background-color: rgba(19, 19, 19, 0.73);
            width: 100%;
            height: 100%;
            position: fixed;
            z-index: 1000;
            display: none;
        }

        .table td{
            padding-left: 10px;
        }

    </style>

</head>
<body>

<noscript>
    <META HTTP-EQUIV="Refresh" CONTENT="0;URL=index.php">
</noscript>

<div class="sidebar">

    <div class="sidebar-container">

        <ul>
            <a href="../index.php">
                <li><span class="fa fa-dashboard"></span> Dashboard</li>
            </a>
            <a href="../stock/view_stock.php">
                <li><span class="fa fa-book"></span> Stock</li>
            </a>
            <a href="../supplier/manage_supp.php">
                <li><span class="fa fa-truck"></span> Supplier</li>
            </a>
            <a href="../menuitems/index.php">
                <li><span class="fa fa-list"></span> Food / Menu Items</li>
            </a>
            <a href="../products/index.php">
                <li><span class="fa fa-barcode"></span> Products</li>
            </a>
            <a href="../property/manage_prop.php">
                <li><span class="fa fa-building"></span> Property</li>
            </a>
            <a href="../department/manage_dep.php">
                <li><span class="fa fa-home"></span> Department</li>
            </a>
            <a href="../expenditure/manage_exp.php">
                <li><span class="fa fa-money"></span> Expenditure</li>
            </a>
            <a href="index.php">
                <li class="active"><span class="fa fa-users"></span> Staff</li>
            </a>
            <a href="../user/manage_user.php">
                <li><span class="fa fa-user"></span> User</li>
            </a>
            <a href="../sales/index.php">
                <li><span class="fa fa-dollar"></span> Sales</li>
            </a>
        </ul>

    </div>

</div>

<div class="content">


    <?php include_once("../master_engine/header.php"); ?>



    <div class="container-fluid" style="padding-top: 50px">
        <div class="row">
            <div class="col-lg-12">



                <div class="panel panel-primary">
                    <div class="panel-heading"><span class="fa fa-navicon"></span> Navigation</div>
                    <div class="panel-body" style="text-align: center">
                        <div class="btn-group btn-group-sm">
                            <a href="add_member.php" class="btn btn-default"><span class="fa fa-plus"></span> Add Staff Member</a>
                            <a href="manage_staff.php" class="btn btn-default"><span class="fa fa-hand-pointer-o"></span> Manage Staff</a>
                        </div>
                        <div class="btn-group btn-group-sm">
                            <a href="do_attendance.php" class="btn btn-default"><span class="fa fa-clock-o"></span> Do Attendance</a>
                            <a href="check_attendance.php" class="btn btn-primary"><span class="fa fa-bar-chart-o"></span> Check Attendance</a>
                        </div>
                        <div class="btn-group btn-group-sm">
                            <a href="pay_salary.php" class="btn btn-default"><span class="fa fa-dollar"></span> Pay Salary</a>
                            <a href="view_salary.php" class="btn btn-default"><span class="fa fa-line-chart"></span> View Salary</a>
                        </div>
                    </div>
                </div>




                <div class="panel panel-primary">
                    <div class="panel-heading"><span class="fa fa-bar-chart-o"></span>  Check Attendance</div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="row">

                                <form id="mainform" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

                                    <div class="col-lg-6">
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading">Select Type</div>
                                                    <div class="panel-body">
                                                        <div class="row" style="color: #ffffff">
                                                            <div class="col-lg-6" style="padding: 20px">
                                                                <input type="radio" id="daily" checked name="check"> Daily
                                                            </div>
                                                            <div class="col-lg-6" style="padding: 20px">
                                                                <input type="radio" id="monthly" name="check"> Monthly
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading">Select Member Details</div>
                                                    <div class="panel-body">

                                                        <div class="col-lg-12">
                                                            <label>Select Staff Member</label>
                                                            <select id="member_name" name="name" class="form-control">
                                                                <?php

                                                                foreach($namesArr as $k => $n)
                                                                {
                                                                    echo "<option value='$k'>";
                                                                    echo    $n;
                                                                    echo "</option>";
                                                                }

                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-lg-12 daily">
                                                            <label>Select Day</label>
                                                            <select name="day" id="day" class="form-control">
                                                                <?php
                                                                for($i = 1; $i < 31; $i++)
                                                                {
                                                                    if($i == date('d'))
                                                                        echo "<option selected>";
                                                                    else
                                                                        echo "<option>";

                                                                    echo $i;
                                                                    echo "</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-lg-12 monthly">
                                                            <label>Select Month</label>
                                                            <select name="month" id="month" class="form-control">
                                                                <?php
                                                                for($i = 1; $i < 12; $i++)
                                                                {
                                                                    if($i == date('m'))
                                                                        echo "<option value='$i' selected>";
                                                                    else
                                                                        echo "<option value='$i'>";
                                                                    echo $months[$i];
                                                                    echo "</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-lg-12 year">
                                                            <label>Select Year</label>
                                                            <select name="year" id="year" class="form-control">
                                                                <?php
                                                                $y = date("Y");
                                                                for($i = 2016; $i <= $y; $i++)
                                                                {
                                                                    if($i == $y)
                                                                        echo "<option selected>";
                                                                    else
                                                                        echo "<option>";
                                                                    echo $i;
                                                                    echo "</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-lg-12">
                                                            <input type="button" value="Get Details" id="getdet" class="btn btn-success pull-right">
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="show_attendance">
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <a href="javascript:void(0)" class="btn btn-warning pull-right close-btn"><span class="fa fa-close"></span></a><br>
            <h2 id="get_mem" style="text-align: center;background-color: #ffffff;padding: 20px 0px 20px 0px"></h2>
            <table class="table table-responsive" style="background-color: #f8fff4">
                <thead>
                <tr>
                    <td>Date</td>
                    <td>Status</td>
                    <td>Edit</td>
                </tr>
                </thead>
                <tbody id="attend">

                </tbody>
            </table>
        </div>
        <div class="col-lg-3"></div>
    </div>
</div>


<!-- script references -->
<script src="../../js/jquery.js"></script>
<script src="../../bootstrap/js/bootstrap.min.js"></script>
<script src="jquery-1.12.0.min.js"></script>
<script src="get_attendance.js"></script>



</body>
</html>