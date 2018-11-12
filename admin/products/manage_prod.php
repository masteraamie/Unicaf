<?php
session_start();

if(!isset($_SESSION['user']))
{
    header("Location: ../index.php");
}
require_once '../master_engine/database_io.php';


$ID = $Name = $Type = $Barcode = $Unit = $Alert = array();

$query = "SELECT ID , Name , Type , Barcode , Alert , Unit  FROM " . TBL_PRODUCTS . " ORDER BY Name ASC";

$ID = $Link = $Position  = $Image = "";
$connection2 = new mysqli(HOST , USER , PASSWORD , DB_NAME);
$command2 = $connection2->prepare($query);
$command2->execute();
$command2->bind_result($i , $n , $t , $b , $a , $u );
$command2->store_result();
while($command2->fetch())
{
    $ID[] = $i;
    $Name[] = $n;
    $Type[] = $t;
    $Barcode[] = $b;
    $Alert[] = $a;
    $Unit[] = $u;
}
$TABLE = TBL_PRODUCTS;
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
            <a href="index.php">
                <li class="active"><span class="fa fa-barcode"></span> Products</li>
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
                            <a href="add_prod.php" class="btn btn-default"><span class="fa fa-plus"></span> Add Product</a>
                            <a href="manage_prod.php" class="btn btn-primary"><span class="fa fa-hand-pointer-o"></span> Manage Product</a>
                        </div>
                    </div>
                </div>




                <div class="panel panel-primary">
                    <div class="panel-heading"><span class="fa fa-hand-pointer-o"></span> Manage Product</div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table" id="data">


                                            <?php
                                            if(count($Name) > 0)
                                            {?>

                                            <thead>
                                            <tr>
                                                <td>Name</td>
                                                <td>Category</td>
                                                <td>Barcode</td>
                                                <td>Alert Qnty</td>
                                                <td>Unit</td>
                                                <td>Action</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr style="color: #ffffff;">
                                                <td>Name</td>
                                                <td>Category</td>
                                                <td>Barcode</td>
                                                <td>Alert Qnty</td>
                                                <td>Unit</td>
                                                <td>Action</td>
                                            </tr>
                                            <?php
                                            for($i = 0 ; $i < count($Name) ; $i++)
                                            {
                                                echo "<tr>";
                                                echo "<td>";
                                                echo $Name[$i];
                                                echo "</td>";
                                                echo "<td>";
                                                echo $Type[$i];
                                                echo "</td>";
                                                echo "<td>";
                                                echo $Barcode[$i];
                                                echo "</td>";
                                                echo "<td>";
                                                echo $Alert[$i];
                                                echo "</td>";
                                                echo "<td>";
                                                echo $Unit[$i];
                                                echo "</td>";
                                                echo "<td>";
                                                echo "<div class='btn-group btn-group-xs'>";
                                                echo "<a href='edit_prod.php?ID=$ID[$i]' class='btn btn-primary btn-xs'>Edit</a>";
                                                echo "<a href='../delete_modules/delete_item.php?ID=$ID[$i]&TABLE=$TABLE' class='btn btn-danger btn-xs'>Delete</a>";
                                                echo "</div>";
                                                echo "</td>";
                                                echo "</tr>";
                                            }?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td style="padding-top: 50px;text-align: left">
                                                    <button id="exportexcel" class="btn btn-primary">Export As Excel File</button>
                                                </td>
                                            </tr>
                                            </tfoot>
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
<script src="../../js/table_export.js"></script>
<script src="../../js/base64.js"></script>
<script src="../../bootstrap/js/bootstrap.min.js"></script>

<script>


    $(document).ready(function(){

        $("#exportexcel").click(function(){
            $("#data tbody td:last-child").remove();
            $("#data tbody td:nth-child(3)").remove();
            $('#data').tableExport({type:'excel',escape:'false'});
            window.location.href = "manage_prod.php";
        });

    });

</script>


</body>
</html>