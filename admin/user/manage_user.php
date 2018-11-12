<?php
session_start();

if(!isset($_SESSION['user']))
{
    header("Location: ../index.php");
}

require_once '../master_engine/pagination.php';
require_once '../master_engine/database_io.php';

$query = "SELECT ID , Username   FROM " . TBL_USERS . " ORDER BY Username ASC";

$ID = $Name = array();
$connection2 = new mysqli(HOST , USER , PASSWORD , DB_NAME);
$command2 = $connection2->prepare($query);
$command2->execute();
$command2->bind_result($i , $n);
$command2->store_result();
while($command2->fetch())
{
    $ID[] = $i;
    $Name[] = $n;
}
$TABLE = TBL_USERS;
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
            <a href="manage_user.php">
                <li class="active"><span class="fa fa-user"></span> User</li>
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
                            <a href="add_user.php" class="btn btn-default"><span class="fa fa-plus"></span> Add User</a>
                            <a href="manage_user.php" class="btn btn-primary"><span class="fa fa-hand-pointer-o"></span> Manage User</a>
                        </div>
                    </div>
                </div>




                <div class="panel panel-primary">
                    <div class="panel-heading"><span class="fa fa-hand-pointer-o"></span> Manage User</div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="row">

                                    <div class="col-lg-12">
                                            <div class="table-responsive">
                                                <table class="table">

                                                    <?php
                                                    if(count($Name) > 0)
                                                    {?>

                                                    <thead>
                                                    <tr>
                                                        <td>Username</td>
                                                        <td>Action</td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    <?php
                                                    for($i = 0 ; $i < count($Name) ; $i++)
                                                    {
                                                        echo "<tr>";
                                                        echo "<td>";
                                                        echo $Name[$i];
                                                        echo "</td>";
                                                        echo "<td>";
                                                        echo '<a href="../delete_modules/delete_item.php?ID='.$ID[$i].'&TABLE='.$TABLE.'" class="btn btn-danger btn-xs">Delete</a>';
                                                        echo "</td>";
                                                    }?>
                                                    </tbody>
                                                </table>
                                                <?php
                                                }
                                                else
                                                {
                                                    echo "<h2 style='text-align: center;'>You Have No Users Added</h2>";
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