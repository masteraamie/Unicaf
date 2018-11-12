<?php
session_start();

if(!isset($_SESSION['employee']))
{
    header("Location: ../index.php");
}

require_once '../admin/master_engine/pagination.php';
require_once '../admin/master_engine/database_io.php';

$query = "SELECT ID , Name , Quantity , Unit FROM " . TBL_PRODUCTS . " WHERE (Quantity <= Alert) ORDER BY Name ASC";

$ID = $Name = $Quantity  = $Unit = array();
$connection2 = new mysqli(HOST , USER , PASSWORD , DB_NAME);
$command2 = $connection2->prepare($query);
$command2->execute();
$command2->bind_result($i , $n, $q , $u);
$command2->store_result();
while($command2->fetch())
{
    $ID[] = $i;
    $Name[] = $n;
    $Quantity[] = $q;
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
    <link rel="icon" href="../img/favicon.png">
    <link href="../css/font-awesome.css" rel="stylesheet">
    <link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href="main.css" rel="stylesheet">
</head>
<body>
<?php include_once("header.php"); ?>
<div class="sidebar">

    <div class="sidebar-container">

        <ul>
            <a href="../index.php">
                <li><span class="fa fa-dollar"></span> Customer Billing</li>
            </a>
            <a href="departmental/department.php">
                <li><span class="fa fa-dollar"></span> Departmental Billing</li>
            </a>
        </ul>

    </div>

</div>
<div class="content">


    <div class="container-fluid" style="padding-top: 50px">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading"><span class="fa fa-bell"></span> All Alerts</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table">
                                        <?php
                                        if(count($Name) > 0)
                                        {?>

                                        <thead>
                                    <tr>
                                        <td>Product Name</td>
                                        <td>Quantity Left</td>
                                        <td>Unit</td>
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
                                    echo $Quantity[$i];
                                    echo "</td>";
                                    echo "<td>";
                                    echo $Unit[$i];
                                    echo "</td>";
                                    echo "<td>";
                                    echo "<div class='btn-group btn-group-xs'>";
                                    echo "<a href='../stock/add_stock.php' class='btn btn-primary btn-xs'>Add Stock</a>";
                                    echo "</div>";
                                    echo "</td>";
                                    echo "</tr>";
                                }?>
                                </tbody>
                            </table>
                            <?php
                            }
                            else
                            {
                                echo "<h2 style='text-align: center;'>You Have No Alerts</h2>";
                            }

                            ?>
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