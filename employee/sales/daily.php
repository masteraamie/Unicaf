<?php
session_start();

if(!isset($_SESSION['employee']))
{
    header("Location: ../index.php");
}
require_once("../../admin/master_engine/update_modules.php");
require_once("../../admin/master_engine/database_io.php");


$errors = array();

$id = $items = $total  = array();


if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['DAY']) && isset($_GET['MONTH']) && isset($_GET['YEAR']))
{
    $day = $_GET["DAY"];
    if($day != "" &&  is_numeric($day))
    {
        $db = new DatabaseIO();
        $count = $db->get_entry(TBL_BILLING , "COUNT(ID)" , "Status" , 1);

        $dbIO = new DatabaseIO();
        $percent =  $dbIO->get_entry(TBL_PERCENT , "Percent" , "1" ,"1");

        $show = (int)($count * ($percent/100));

        $month = (int)$_GET['MONTH'];
        $year = (int)$_GET['YEAR'];
        $query = "SELECT ID , Items , Total  from ".TBL_BILLING." WHERE (Day = ? and Month = ? and Year = ? and Status = 1) LIMIT $show";
        $connection = new mysqli(HOST , USER , PASSWORD , DB_NAME);
        $statement = $connection->prepare($query);
        $statement->bind_param("iii" , $day , $month , $year);
        $statement->execute();
        $statement->bind_result($i , $item , $t);
        $statement->store_result();
        while($statement->fetch())
        {
            $id[] = $i;
            $items[] = $item;
            $total[] = $t;
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