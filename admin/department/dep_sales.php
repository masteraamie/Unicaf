<?php
session_start();

if(!isset($_SESSION['user']))
{
    header("Location: ../index.php");
}
require_once '../master_engine/database_io.php';
$dbIO = new DatabaseIO();
$departments = $dbIO->get_entries_with_id(TBL_DEPARTMENT , "Name");


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
            <a href="manage_dep.php">
                <li class="active"><span class="fa fa-home"></span> Department</li>
            </a>
            <a href="../expenditure/manage_exp.php">
                <li><span class="fa fa-money"></span> Expenditure</li>
            </a>
            <a href="../staff/index.php">
                <li><span class="fa fa-users"></span> Staff</li>
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
                            <a href="add_dep.php" class="btn btn-default"><span class="fa fa-plus"></span> Add Department</a>
                            <a href="manage_dep.php" class="btn btn-default"><span class="fa fa-hand-pointer-o"></span> Manage Department</a>
                        </div>
                        <div class="btn-group btn-group-sm">
                            <a href="dep_sales.php" class="btn btn-primary"><span class="fa fa-dollar"></span> Sales</a>
                            <a href="manage_vat.php" class="btn btn-default"><span class="fa fa-area-chart"></span> Manage Vat</a>
                            <a href="pay_bills.php" class="btn btn-default"><span class="fa fa-money"></span> Pay Bills</a>
                            <a href="view_bal.php" class="btn btn-default"><span class="fa fa-table"></span> View Balance</a>
                            <a href="dep_payments.php" class="btn btn-default"><span class="fa fa-table"></span> View Payments</a>
                        </div>
                    </div>
                </div>




                <div class="panel panel-primary">
                    <div class="panel-heading"><span class="fa fa-dollar"></span> Department Sales</div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="row">

                                <form id="mainform" action="view_sales.php" method="get">

                                    <div class="col-lg-6">
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <label>Select Department</label>
                                                <select name="department" id="department" class="form-control">
                                                    <?php

                                                    foreach($departments as $k => $n)
                                                    {
                                                        echo "<option value='$k'>";
                                                        echo    $n;
                                                        echo "</option>";
                                                    }

                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <label>Month</label>
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
                                                    <div class="col-lg-6">
                                                        <label>Year</label>
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
                                                    <div class="col-lg-6">
                                                        <br>
                                                        <input type="submit" value="Get Sales" class="btn btn-success">
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




<!-- script references -->
<script src="../../js/jquery.js"></script>
<script src="../../bootstrap/js/bootstrap.min.js"></script>

<script>


    $(document).ready(function(){


    });

</script>


</body>
</html>