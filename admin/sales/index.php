<?php
session_start();

if(!isset($_SESSION['user']))
{
    header("Location: ../index.php");
}


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
            <a href="index.php">
                <li class="active"><span class="fa fa-dollar"></span> Sales</li>
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
                    <div class="panel-heading"><span class="fa fa-dollar"></span> Customer Sales</div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="row">

                                    <!-- Panel !-->
                                    <div class="col-lg-4">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">Daily</div>
                                            <div class="panel-body">
                                                <div class="row">

                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <label>Month</label>
                                                                <select name="month" class="form-control" id="m_daily">
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
                                                                <select name="year" class="form-control" id="y_daily">
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
                                                            <div class="col-lg-6" style="padding-top: 10px">
                                                                <label>Day</label>
                                                                <select name="day" class="form-control" id="d_daily">
                                                                    <?php
                                                                    for($i = 1; $i < 31; $i++)
                                                                    {
                                                                        if($i == date('d'))
                                                                            echo "<option  selected>";
                                                                        else
                                                                            echo "<option>";

                                                                        echo $i;
                                                                        echo "</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-6" style="padding-top: 16px">
                                                                <br>
                                                                <button id="daily" class="btn btn-success pull-right">Get Sales</button>
                                                            </div>
                                                        </div>
                                                    </div>



                                                </div>
                                            </div>
                                        </div>
                                    </div>

<!-- Panel !-->
                                    <div class="col-lg-4">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">Monthly</div>
                                            <div class="panel-body">
                                                <div class="row">

                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <label>Month</label>
                                                                <select name="month" class="form-control" id="m_monthly">
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
                                                                <select name="year" class="form-control" id="y_monthly">
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
                                                            <div class="col-lg-6 pull-right" style="padding-top: 16px">
                                                                <br>
                                                                <button id="monthly" class="btn btn-success pull-right">Get Sales</button>
                                                            </div>
                                                        </div>
                                                    </div>



                                                </div>
                                            </div>
                                        </div>
                                    </div>

<!-- Panel !-->
                                    <div class="col-lg-4">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">Yearly</div>
                                            <div class="panel-body">
                                                <div class="row">

                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <label>Year</label>
                                                                <select name="year" class="form-control" id="y_yearly">
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
                                                            <div class="col-lg-6 pull-right" style="padding-top: 16px">
                                                                <br>
                                                                <button id="yearly" class="btn btn-success pull-right">Get Sales</button>
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

        $("#daily").click(function(){


            var day = $("#d_daily").find(":selected").text();
            var month = $("#m_daily").find(":selected").val();
            var year = $("#y_daily").find(":selected").text();

            window.location.href = 'daily.php?DAY='+day+'&MONTH='+month+'&YEAR='+year;


        });

        $("#monthly").click(function(){


            var month = $("#m_daily").find(":selected").val();
            var year = $("#y_monthly").find(":selected").text();

            window.location.href = 'monthly.php?MONTH='+month+'&YEAR='+year;


        });

        $("#yearly").click(function(){

            var year = $("#y_yearly").find(":selected").text();

            window.location.href = 'yearly.php?YEAR='+year;


        });

    });

</script>


</body>
</html>