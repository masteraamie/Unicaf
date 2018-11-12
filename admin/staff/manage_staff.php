<?php
session_start();

if(!isset($_SESSION['user']))
{
    header("Location: ../login.php");
}


require_once '../master_engine/pagination.php';
require_once '../master_engine/database_io.php';


$query = "SELECT ID , Name , Image FROM " . TBL_STAFF . " ORDER BY Name ASC";

$ID = $Name  = $Image = array();
$connection2 = new mysqli(HOST , USER , PASSWORD , DB_NAME);
$command2 = $connection2->prepare($query);
$command2->execute();
$command2->bind_result($i , $n , $im);
$command2->store_result();
while($command2->fetch())
{
    $ID[] = $i;
    $Name[] = $n;
    $Image[] = $im;
}
$TABLE = TBL_STAFF;
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
                            <a href="manage_staff.php" class="btn btn-primary"><span class="fa fa-hand-pointer-o"></span> Manage Staff</a>
                        </div>
                        <div class="btn-group btn-group-sm">
                            <a href="do_attendance.php" class="btn btn-default"><span class="fa fa-clock-o"></span> Do Attendance</a>
                            <a href="check_attendance.php" class="btn btn-default"><span class="fa fa-bar-chart-o"></span> Check Attendance</a>
                        </div>
                        <div class="btn-group btn-group-sm">
                            <a href="pay_salary.php" class="btn btn-default"><span class="fa fa-dollar"></span> Pay Salary</a>
                            <a href="view_salary.php" class="btn btn-default"><span class="fa fa-line-chart"></span> View Salary</a>
                        </div>
                    </div>
                </div>




                <div class="panel panel-primary">
                    <div class="panel-heading"><span class="fa fa-hand-pointer-o"></span>  Manage Staff</div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="row">

                                <div class="col-lg-12">

                                    <div class="row">

                                        <?php
                                        if(count($Name) > 0)
                                        {
                                            for($i = 0 ; $i < count($Name) ; $i++) {

                                                echo '<div class="col-lg-3" style = "padding: 40px;" >';
                                                echo '<img src = "'.$Image[$i].'" style = "width: 60%" class="center-block" >';
                                                echo '<h5 style = "color: #ffffff;padding: 10px 0 10px 0;text-align: center" >'.$Name[$i].'</h5 >';
                                                echo '<div style = "text-align: center" >';
                                                echo '<div class="btn-group btn-group-sm" >';
                                                echo '<a href = "edit_staff.php?ID='.$ID[$i].'" class="btn btn-primary" > Edit / View</a>';
                                                echo '<a href = "../delete_modules/delete_item.php?ID='.$ID[$i].'&TABLE='.$TABLE.'" class="btn btn-danger" > Delete</a >';
                                                echo '</div ></div ></div >';
                                            }
                                        }
                                        else
                                        {
                                            echo "<h2 style='text-align: center;'>You Have No Staff Members Added</h2>";
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



</body>
</html>