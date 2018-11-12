<?php
session_start();

if(!isset($_SESSION['user']))
{
    header("Location: ../../index.php");
}
require_once("../master_engine/update_modules.php");
require_once("../master_engine/database_io.php");


$errors = array();

$id = $items = $total = $waiter = $table  = array();

$query = "SELECT ID , Items , Total , Cost , Waiter , TableNo from ".TBL_BILLING." WHERE (Status = 0)";
$connection = new mysqli(HOST , USER , PASSWORD , DB_NAME);
$statement = $connection->prepare($query);
$statement->execute();
$statement->bind_result($i , $item , $t , $c , $w , $tn);
$statement->store_result();
while($statement->fetch())
{
    $id[] = $i;
    $items[] = $item;
    $total[] = $t;
    $cost[] = $c;
    $waiter[] = $w;
    $table[] = $tn;
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
                            <a href="pending_bills.php" class="btn btn-primary"><span class="fa fa-dollar"></span> Pending Bills</a>
                            <a href="show_percentage.php" class="btn btn-default"><span class="fa fa-paperclip"></span> Show Bills Percentage</a>
                        </div>
                    </div>
                </div>




                <div class="panel panel-primary">
                    <div class="panel-heading"><span class="fa fa-dollar"></span> Pending Bills</div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive" style="overflow: visible !important;">
                                        <table class="table">
                                            <?php
                                            if(count($id) > 0)
                                            {?>

                                            <thead>
                                            <tr>
                                                <td>Bill ID</td>
                                                <td>Items Sold</td>
                                                <td>Bill Cost</td>
                                                <td>Bill Total</td>
                                                <td>Table No</td>
                                                <td>Waiter</td>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                            for($i = 0 ; $i < count($id) ; $i++)
                                            {
                                                echo "<tr>";
                                                echo "<td>";
                                                echo $id[$i];
                                                echo "</td>";
                                                ?>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                            Items
                                                            <span class="fa fa-caret-down" style="padding-left: 10px"></span>
                                                        </button>
                                                        <ul  style="padding: 10px"  class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                            <?php
                                                            $its = explode("," , $items[$i]);
                                                            for($j = 0 ; $j < count($its) ; $j++)
                                                                echo '<li>'.$its[$j].'</li>';?>
                                                        </ul>
                                                    </div>
                                                </td>
                                                <?php
                                                echo "<td>";
                                                echo $total[$i];
                                                echo "</td>";
                                                echo "<td>";
                                                echo $cost[$i];
                                                echo "</td>";
                                                echo "<td>";
                                                echo $table[$i];
                                                echo "</td>";
                                                echo "<td>";
                                                echo $waiter[$i];
                                                echo "</td>";
                                                echo "</tr>";
                                            }?>
                                            </tbody>
                                        </table>
                                        <?php
                                        }
                                        else
                                        {
                                            echo "<h2 style='text-align: center;'>You Have No Pending Bills</h2>";
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