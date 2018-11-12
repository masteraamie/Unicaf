<?php
session_start();

if(!isset($_SESSION['user']))
{
    header("Location: ../index.php");
}
require_once("../master_engine/update_modules.php");
require_once("../master_engine/database_io.php");


$errors = array();

$customers = $total = $profit = array();


if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['YEAR']))
{
    $year = (int)$_GET['YEAR'];
    if($year != "" &&  is_numeric($year))
    {

        for($i = 1 ; $i <= 12 ; $i++) {
            $query = "SELECT COUNT(ID) , SUM(Total) , SUM(Profit) from " . TBL_BILLING . " WHERE (Month = ? and Year = ? and Status = 1)";
            $connection = new mysqli(HOST, USER, PASSWORD, DB_NAME);
            $statement = $connection->prepare($query);
            $statement->bind_param("ii", $i, $year);
            $statement->execute();
            $statement->bind_result($customer, $item, $t);
            $statement->store_result();
            $statement->fetch();
            $customers[$i] = $customer;
            $total[$i] = $item;
            $profit[$i] = $t;
        }
    }
}
else if($_SERVER["REQUEST_METHOD"] == "GET" && !isset($_GET['MONTH']))
    header("Location:index.php");

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
                    <div class="panel-heading"><span class="fa fa-navicon"></span> Navigation</div>
                    <div class="panel-body" style="text-align: center">
                        <div class="btn-group btn-group-sm">
                            <a href="index.php" class="btn btn-default"><span class="fa fa-backward "></span> Back To Main Page</a>
                        </div>
                    </div>
                </div>




                <div class="panel panel-primary">
                    <div class="panel-heading"><span class="fa fa-bar-chart"></span> Yearly Sales Report</div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="table-responsive" style="overflow: visible !important;">
                                        <table class="table">
                                            <?php
                                            if(count($customers) > 0)
                                            {?>

                                            <thead>
                                            <tr>
                                                <td>Month</td>
                                                <td>Paid Bills</td>
                                                <td>Bill Total</td>
                                                <td>Bill Profit</td>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                            for($i = 1 ; $i <= count($customers) ; $i++)
                                            {
                                                if($customers[$i] != 0) {

                                                    echo "<tr>";
                                                    echo "<td>";
                                                    echo $i;
                                                    echo "</td>";
                                                    echo "<td>";
                                                    echo $customers[$i];
                                                    echo "</td>";
                                                    echo "<td>";
                                                    echo $total[$i] == "" ? 0 : $total[$i];
                                                    echo "</td>";
                                                    echo "<td>";
                                                    echo $profit[$i] == "" ? 0 : $profit[$i];
                                                    echo "</td>";
                                                    echo "</tr>";
                                                }
                                            }?>
                                            </tbody>
                                        </table>
                                        <?php
                                        }
                                        else
                                        {
                                            echo "<h2 style='text-align: center;'>You Have No Products Added</h2>";
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