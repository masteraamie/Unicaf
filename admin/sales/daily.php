<?php
session_start();

if(!isset($_SESSION['user']))
{
    header("Location: ../index.php");
}
require_once("../master_engine/update_modules.php");
require_once("../master_engine/database_io.php");


$errors = array();

$id = $items = $total = $profit = array();


if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['DAY']) && isset($_GET['MONTH']) && isset($_GET['YEAR']))
{
    $day = $_GET["DAY"];
    if($day != "" &&  is_numeric($day))
    {
        $month = (int)$_GET['MONTH'];
        $year = (int)$_GET['YEAR'];
        $query = "SELECT ID , Items , Total , Profit from ".TBL_BILLING." WHERE (Day = ? and Month = ? and Year = ? and Status = 1)";
        $connection = new mysqli(HOST , USER , PASSWORD , DB_NAME);
        $statement = $connection->prepare($query);
        $statement->bind_param("iii" , $day , $month , $year);
        $statement->execute();
        $statement->bind_result($i , $item , $t , $p);
        $statement->store_result();
        while($statement->fetch())
        {
            $id[] = $i;
            $items[] = $item;
            $total[] = $t;
            $profit[] = $p;
        }
    }
}
else if($_SERVER["REQUEST_METHOD"] == "GET" && !isset($_GET['DAY']) && !isset($_GET['MONTH']) && !isset($_GET['YEAR']))
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
                    <div class="panel-heading"><span class="fa fa-bar-chart"></span> Daily Sales Report</div>
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
                                                <td>Bill Total</td>
                                                <td>Bill Profit</td>
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
                                                echo "<td>";
                                            ?>
                                                <div class="dropdown">
                                                    <button class="btn btn-primary btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        Items
                                                        <span class="fa fa-caret-down" style="padding-left: 10px"></span>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                        <?php
                                                        $its = explode("," , $items[$i]);
                                                        for($j = 0 ; $j < count($its) ; $j++)
                                                            echo '<li>'.$its[$j].'</li>';
                                                        ?>
                                                    </ul>
                                                </div>
                                            <?php
                                                echo "</td>";
                                                echo "<td>";
                                                echo $total[$i] == ""  ? 0 : $total[$i];
                                                echo "</td>";
                                                echo "<td>";
                                                echo $profit[$i] == ""  ? 0 : $profit[$i];
                                                echo "</td>";
                                                echo "</tr>";
                                            }?>
                                            </tbody>
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