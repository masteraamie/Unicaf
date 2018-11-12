<?php
session_start();

if(!isset($_SESSION['employee']))
{
    header("Location: ../index.php");
}
require_once("../../admin/master_engine/update_modules.php");
require_once("../../admin/master_engine/database_io.php");


$errors = array();

$customers = $total =  array();


if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['MONTH']) && isset($_GET['YEAR']))
{
    $month = (int)$_GET['MONTH'];
    if($month != "" &&  is_numeric($month))
    {
        $month = (int)$_GET['MONTH'];
        $year = (int)$_GET['YEAR'];

        $dbIO = new DatabaseIO();
        $percent =  $dbIO->get_entry(TBL_PERCENT , "Percent" , "1" ,"1");

        for($i = 1 ; $i <= 31 ; $i++) {
            $query = "SELECT COUNT(ID) , SUM(Total)  from " . TBL_BILLING . " WHERE (Day = ? and Month = ? and Year = ? and Status = 1)";
            $connection = new mysqli(HOST, USER, PASSWORD, DB_NAME);
            $statement = $connection->prepare($query);
            $statement->bind_param("iii", $i, $month, $year);
            $statement->execute();
            $statement->bind_result($customer, $item);
            $statement->store_result();
            $statement->fetch();
            $customers[$i] = $customer;
            $total[$i] = (int)($item * ($percent/100));;
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

<?php include_once("header.php"); ?>

<div class="sidebar">

    <div class="sidebar-container">

        <ul>
            <a href="../index.php">
                <li><span class="fa fa-dollar"></span> Customer Billing</li>
            </a>
            <a href="../departmental/department.php">
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
                    <div class="panel-heading"><span class="fa fa-navicon"></span> Navigation</div>
                    <div class="panel-body" style="text-align: center">
                        <div class="btn-group btn-group-sm">
                            <a href="index.php" class="btn btn-default"><span class="fa fa-backward "></span> Back To Main Page</a>
                        </div>
                    </div>
                </div>




                <div class="panel panel-primary">
                    <div class="panel-heading"><span class="fa fa-bar-chart"></span> Monthly Sales Report</div>
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
                                                <td>Day</td>
                                                <td>Paid Bills</td>
                                                <td>Bill Total</td>
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