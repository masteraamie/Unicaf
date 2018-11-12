<?php
session_start();

if(!isset($_SESSION['user']))
{
    header("Location: ../index.php");
}

require_once "../master_engine/database_io.php";


$dbIO = new DatabaseIO();
$count = $dbIO->get_count(TBL_ITEMS);

$dbIO = new DatabaseIO();
$pending = $dbIO->get_entry(TBL_BILLING , "COUNT(ID)" , "Status" , 0);

$dbIO = new DatabaseIO();
$percent = $dbIO->get_entry(TBL_PERCENT , "Percent" , "1" , "1");

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
            <a href="index.php">
                <li class="active"><span class="fa fa-list"></span> Food / Menu Items</li>
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
                            <a href="add_item.php" class="btn btn-default"><span class="fa fa-plus"></span> Add Menu Item</a>
                            <a href="manage_item.php" class="btn btn-default"><span class="fa fa-hand-pointer-o"></span> Manage Menu Item</a>
                        </div>
                        <div class="btn-group btn-group-sm">
                            <a href="pending_bills.php" class="btn btn-default"><span class="fa fa-dollar"></span> Pending Bills</a>
                            <a href="show_percentage.php" class="btn btn-default"><span class="fa fa-paperclip"></span> Show Bills Percentage</a>
                        </div>
                    </div>
                </div>




                <div class="panel panel-primary">
                    <div class="panel-heading"><span class="fa fa-pie-chart"></span> Food/Menu Item Details</div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-4" >
                                    <div class="box red">
                                        <h6>Total Items</h6>
                                        <h1><?php echo $count;?></h1>
                                    </div>
                                </div>
                                <div class="col-lg-4" >
                                    <div class="box green">
                                        <h6>Pending Bills</h6>
                                        <h1><?php echo $pending;?></h1>
                                    </div>
                                </div>
                                <div class="col-lg-4" >
                                    <div class="box blue">
                                        <h6>Bill View Percentage</h6>
                                        <h1><?php echo $percent."%";?></h1>
                                    </div>
                                </div>
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