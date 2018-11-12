<?php
session_start();

if(!isset($_SESSION['user']))
{
    header("Location: ../index.php");
}
require_once("../master_engine/update_modules.php");
require_once("../master_engine/database_io.php");


$errors = array();

$month = $year = "";

$staff = $status = $balance = $ids = $salary = $paid = array();

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['month']) && isset($_GET['year']))
{
    $month = (int)$_GET['month'];
    if($month != "" &&  is_numeric($month))
    {
        $month = (int)$_GET['month'];
        $year = (int)$_GET['year'];

        $query = "SELECT staffID , staffName , Status , Balance , Salary , Paid   from " . TBL_SALARY . " WHERE (Month = ? and Year = ?)";
        $connection = new mysqli(HOST, USER, PASSWORD, DB_NAME);
        $statement = $connection->prepare($query);
        $statement->bind_param("ii", $month, $year);
        $statement->execute();
        $statement->bind_result($i , $n , $st , $bal , $sal , $p);
        $statement->store_result();
        while ($statement->fetch())
        {
            $ids[] = $i;
            $staff[] = $n;
            $status[] = $st;
            $balance[] = $bal;
            $salary[] = $sal;
            $paid[] = $p;
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
                            <a href="check_attendance.php" class="btn btn-default"><span class="fa fa-bar-chart-o"></span> Check Attendance</a>
                        </div>
                        <div class="btn-group btn-group-sm">
                            <a href="pay_salary.php" class="btn btn-default"><span class="fa fa-dollar"></span> Pay Salary</a>
                            <a href="view_salary.php" class="btn btn-primary"><span class="fa fa-line-chart"></span> View Salary</a>
                        </div>
                    </div>
                </div>




                <div class="panel panel-primary">
                    <div class="panel-heading"><span class="fa fa-eye"></span> View Balance</div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <?php
                                            if(count($staff) > 0)
                                            {?>

                                            <thead>
                                            <tr>
                                                <td>Name</td>
                                                <td>Salary</td>
                                                <td>Paid</td>
                                                <td>Balance/Advance</td>
                                                <td>Edit</td>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                            for($i = 0 ; $i < count($staff) ; $i++)
                                            {
                                                echo "<tr>";
                                                echo "<td>";
                                                echo $staff[$i];
                                                echo "</td>";
                                                echo "<td>";
                                                echo $salary[$i];
                                                echo "</td>";
                                                echo "<td>";
                                                echo $paid[$i];
                                                echo "</td>";
                                                echo "<td>Rs ";
                                                echo $balance[$i] < 0 ? -($balance[$i])." A":$balance[$i]." B";
                                                echo "</td>";
                                                echo "<td>";
                                                echo '<a href="edit_salary.php?ID='.$ids[$i].'&Month='.$month.'&Year='.$year.'" class="btn btn-danger btn-xs">Edit</a>';
                                                echo "</td>";
                                                echo "</tr>";
                                            }?>
                                            </tbody>
                                        </table>
                                        <?php
                                        }
                                        else
                                        {
                                            echo "<h2 style='text-align: center;'>You Have No Balances Yet</h2>";
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
<script src="../../js/jquery.validate.js"></script>
<script src="../../bootstrap/js/bootstrap.min.js"></script>

<script>


    $(document).ready(function(){



    });

</script>


</body>
</html>