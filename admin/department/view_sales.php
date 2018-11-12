<?php
session_start();

if(!isset($_SESSION['user']))
{
    header("Location: ../index.php");
}
require_once("../master_engine/update_modules.php");
require_once("../master_engine/database_io.php");

$dbIO = new DatabaseIO();
$vat =  $dbIO->get_entry(TBL_VAT , "VAT" , "1" ,"1");

$errors = array();
$serial = 0;
$items = $name = $quantity = $total  = $paid = $balance = array();

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['month']) && isset($_GET['year']) && isset($_GET['department']))
{
    $month = (int)$_GET['month'];
    if($month != "" &&  is_numeric($month))
    {
        $month = (int)$_GET['month'];
        $year = (int)$_GET['year'];
        $dept = (int)$_GET['department'];

        $query = "SELECT ID , deptName , Items , Quantity , Total , Paid , Balance from " . TBL_DEPT_BILLS . " WHERE (Month = ? and Year = ? and deptID = ?)";
        $connection = new mysqli(HOST, USER, PASSWORD, DB_NAME);
        $statement = $connection->prepare($query);
        $statement->bind_param("iii", $month , $year , $dept);
        $statement->execute();
        $statement->bind_result($serial , $n , $i , $q , $t , $p , $b);
        $statement->store_result();
        while ($statement->fetch()) {
            $name[] = $n;
            $items[] = $i;
            $quantity[] = $q;
            $total[] = $t;
            $paid[] = $p;
            $balance[] = $b;
        }

        $z = "";
        $zeroes = 8 - strlen($serial);
        for($i = 0 ; $i < $zeroes ; $i++)
        {
            $z .= "0";
        }

        $serial = $z.$serial;

        for($i = 0 ; $i < count($items) ; $i++) {
            $items_check = $newQnts = array();
            $its = explode(",", $items[$i]);
            $qnts = explode(",", $quantity[$i]);


            for ($j = 0; $j < count($its); $j++) {
                if (in_array($its[$j], $items_check)) {
                    $key = array_search($its[$j], $items_check);
                    $newQnts[$key] += $qnts[$j];

                } else {
                    $items_check[] = $its[$j];
                    $newQnts[] = $qnts[$j];
                }
            }
        }


        if(!empty($items_check)) {
            $prices = array();
            for ($i = 0; $i < count($items_check); $i++) {
                $query = "SELECT Price from " . TBL_ITEMS . " WHERE (Name = ?)";
                $connection = new mysqli(HOST, USER, PASSWORD, DB_NAME);
                $statement = $connection->prepare($query);
                $statement->bind_param("s", $items_check[$i]);
                $statement->execute();
                $statement->bind_result($prices[$i]);
                $statement->store_result();
                $statement->fetch();
            }
        }
    }


}
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
    <link href="print2.css" media="print" rel="stylesheet">

    <style>


        .show_print{
            display: none;
        }

    </style>

</head>
<body>

<div class="sidebar dontprint">

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



                <div class="panel panel-primary dontprint">
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


                <div class="col-lg-12">
                    <h6 class="show_print" style="padding-left: 15px">TIN NO. : 01832121747</h6>

                    <img src="../../img/logo_print.png" style="width: 100px;" class="show_print center-block">
                    <h3 class="show_print" style="text-align: center">University Cafeteria</h3>
                    <h6 class="show_print"><div style="width: 50%;padding-left: 15px"><?php echo "Bill Serial : ".$serial ;  ?></div>
                    <h6 class="show_print"><div style="width: 50%;padding-left: 15px"><?php echo date('D')." , ".date('d M, Y');  ?></div>
                        <h6 class="show_print"><div style="width: 50%;padding-left: 15px"><?php if(!empty($name)){echo "Dept Name : ".$name[0]; } ?></div>
                        <div style="width: 50%;display: inline;text-align: right !important;" class="tbl_no_prnt"></div> </h6>
                </div>


                <div class="panel panel-primary">

                    <div class="panel-heading dontprint"><span class="fa fa-bar-chart"></span> Sales Report</div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="table-responsive" style="overflow: visible !important;">
                                        <table class="table">
                                            <?php
                                            if(count($items) > 0)
                                            {?>
                                            <thead>
                                            <tr>
                                                <td class="dontprint">Month</td>
                                                <td>Items Sold</td>
                                                <td>Quantity</td>
                                                <td>Price</td>
                                                <td>Amount</td>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                            for($i = 0 ; $i < count($items) ; $i++)
                                            {
                                                echo  '<tr><td class="dontprint">';
                                                echo $month;
                                                echo  '</td>';

                                                ?>

                                                <td>
                                                    <ul>
                                                        <?php
                                                        for($j =  0; $j < count($items_check) ; $j++) {
                                                            echo '<li style="text-indent: 10px">' . $items_check[$j] . '</li>';
                                                        }?>
                                                    </ul>
                                                </td>

                                                <td>
                                                    <ul>
                                                        <?php
                                                        for($j =  0; $j < count($newQnts) ; $j++) {
                                                            echo '<li style="text-indent: 10px">' . $newQnts[$j] . '</li>';
                                                        }?>
                                                    </ul>
                                                </td>

                                                <td>
                                                    <ul>
                                                        <?php
                                                        for($j =  0; $j < count($newQnts) ; $j++) {
                                                            echo '<li style="text-indent: 10px">' . $prices[$j] . '</li>';
                                                        }?>
                                                    </ul>
                                                </td>


                                                <td>
                                                    <ul>
                                                        <?php
                                                        for($j =  0; $j < count($newQnts) ; $j++) {
                                                            if($newQnts[$j] != 0) {
                                                                echo '<li style="text-indent: 10px">' . $prices[$j] * $newQnts[$j] . '</li>';
                                                            }
                                                        }?>
                                                    </ul>
                                                </td>

                                                <?php

                                                echo '</tr>';
                                            }?>

                                            </tbody>
                                            <tfoot>
                                            <tr class="dontprint">
                                                <td colspan="4" style="text-align: right; padding-right: 60px !important;">
                                                    <b>Total :</b>
                                                </td>
                                                <td>
                                                    Rs <?php
                                                    $ttl = 0;
                                                    for($j =  0; $j < count($prices) ; $j++)
                                                        $ttl += $prices[$j] * $newQnts[$j];
                                                    echo $ttl;
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr class="dontprint">
                                                <td colspan="4" style="text-align: right; padding-right: 60px !important;">
                                                    <b>VAT @ <?php echo $vat;?>% :</b>
                                                </td>
                                                <td>
                                                    Rs <?php


                                                    $vatAmt = (int)($total[0] * ($vat / 100));

                                                    echo $vatAmt;
                                                    ?>
                                                </td>
                                           </tr>
                                            <tr class="dontprint">
                                                <td  colspan="4" style="text-align: right;font-size: 16px; padding-right: 60px !important;">
                                                    <b>Grand Total : Rs</b>
                                                </td>
                                                <td>
                                                    <b><?php
                                                        $grndTtl = $total[0] + $vatAmt;
                                                        echo (int)$grndTtl;?></b>
                                                </td>
                                            </tr>

                                            <tr class="printblack" style="color: #ffffff">
                                                <td colspan="3" style="text-align: right; padding-right: 60px !important;">
                                                    <b>VAT @ <?php echo $vat;?>% :</b>
                                                </td>
                                                <td>
                                                    Rs <?php echo (int)($total[0]*($vat/100)); ?>
                                                </td>
                                            </tr>


                                            <tr class="printblack" style="color: #ffffff">
                                                <td  colspan="3" style="text-align: right;font-size: 16px; padding-right: 60px !important;">
                                                    <b>Grand Total : Rs</b>
                                                </td>
                                                <td>
                                                    <b><?php
                                                        $grndTtl = $total[0] + $vatAmt;
                                                        echo (int)$grndTtl;?></b>
                                                </td>
                                            </tr>

                                            <tr class="dontprint">
                                                <td colspan="4"></td>
                                                <td>
                                                    <input type="button" class="btn btn-success" value="Print" onclick="window.print();">
                                                </td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                        <?php


                                        }



                                        else
                                        {
                                            echo "<h2 style='text-align: center;'>You Have No Sales</h2>";
                                        }

                                        ?>
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