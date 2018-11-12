<?php
session_start();

if(!isset($_SESSION['user']))
{
    header("Location: ../index.php");
}
require_once("../master_engine/validations.php");
require_once("../master_engine/update_modules.php");
require_once("../master_engine/database_io.php");

//defining variables
$name = $balance = $paid = $salary = $designation = $month = $year = "";

$errors = array();

$validate = new Validation();

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['ID']) && isset($_GET['Month']) && isset($_GET['Year']))
{
    $id = $_GET["ID"];
    if($id != "" &&  is_numeric($id))
    {
        $month = (int)$_GET['Month'];
        $year = (int)$_GET['Year'];

        $query = "SELECT Name  , Designation , Salary  from ".TBL_STAFF." WHERE ID = ?";
        $connection = new mysqli(HOST , USER , PASSWORD , DB_NAME);
        $statement = $connection->prepare($query);
        $statement->bind_param("i" , $id);
        $statement->execute();
        $statement->bind_result($name , $designation , $salary );
        $statement->store_result();
        while($statement->fetch()){}


        $query = "SELECT Paid  , Balance  from ".TBL_SALARY." WHERE (staffID = ? and Month = ? and Year = ?)";
        $connection = new mysqli(HOST , USER , PASSWORD , DB_NAME);
        $statement = $connection->prepare($query);
        $statement->bind_param("iii" , $id , $month , $year);
        $statement->execute();
        $statement->bind_result($paid , $balance);
        $statement->store_result();
        while($statement->fetch()){}
    }
}
else if($_SERVER["REQUEST_METHOD"] == "GET" && !isset($_GET['ID']) && !isset($_GET['Month']) && !isset($_GET['Year']))
    header("Location:view_salary.php");

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

    $id = $_POST["id"];

    $salary = is_numeric(trim($_POST['salary'])) ? trim($_POST['salary']) : "NA";
    $paid = is_numeric(trim($_POST['psalary'])) ? trim($_POST['psalary']) : "NA";

    $month = is_numeric(trim($_POST['month'])) ? trim($_POST['month']) : "NA";
    $year = is_numeric(trim($_POST['year'])) ? trim($_POST['year']) : "NA";

    if($salary != "NA" && $paid != "NA" && $month != "NA" && $year != "NA")
    {
        $newBalance = $salary - $paid;
        $update = new Update();


        if($update->update_salary($paid, $newBalance, $month , $year , $id) == 1)
        {
            echo "<script>alert('Salary Updated Successfully');</script>";
            echo "<script>window.location='view_salary.php';</script>";
        }
        else
        {
            echo "<script>alert('Salary Update Failed');</script>";
        }
    }

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
                    <div class="panel-heading"><span class="fa fa-line-chart"></span>  View Salary</div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="row">

                                <form id="mainform" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

                                    <div class="col-lg-6">
                                        <div class="row">

                                            <input name="id" id="id" value="<?php echo $id; ?>" type="hidden"/>
                                            <input name="month" id="id" value="<?php echo $month; ?>" type="hidden"/>
                                            <input name="year" id="id" value="<?php echo $year; ?>" type="hidden"/>
                                            <div class="col-lg-12">
                                                <label>Name</label>
                                                <input  value="<?php echo $name; ?>" type="text" class="form-control" name="name" contenteditable="false" >
                                            </div>


                                            <div class="col-lg-12">
                                                <label>Salary (in rupees)</label>
                                                <input contenteditable="false"  value="<?php echo $salary; ?>" type="text" class="form-control" name="salary">
                                            </div>

                                            <div class="col-lg-12">
                                                <label>Designation</label>
                                                <input contenteditable="false"  value="<?php echo $designation; ?>" type="text" class="form-control" name="designation">
                                            </div>


                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <label>Paid Salary (in rupees)</label>
                                                <input placeholder="e.g. 10000" value="<?php echo $paid; ?>" type="text" class="form-control" name="psalary">
                                            </div>

                                            <div class="col-lg-12">
                                                <label><?php echo $balance < 0 ?  "Advance" : "Balance";?></label>
                                                <input contenteditable="false" placeholder="e.g. 10000" value="<?php echo $balance < 0 ? -($balance):$balance; ?>" type="text" class="form-control" name="advance">
                                            </div>


                                            <div class="col-lg-12">
                                                <input type="submit" name="submit" value="Update" class="btn btn-success pull-right">
                                            </div>

                                        </div>
                                    </div>


                                </form>

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

        $("#mainform").validate({

            rules: {
                psalary : {
                    required: true,
                    number : true,
                    maxlength : 10
                },
                advance : {
                    required: true,
                    number : true,
                    maxlength : 10
                }

            },
            messages: {

                psalary : {
                    required : "Please enter a paid salary",
                    number : "Paid salary can only be a number",
                    maxlength: " Paid salary can only contain 10 digits"
                },
                advance : {
                    required : "Please enter an advance amt",
                    number : "Advance amt can only be a number",
                    maxlength: "Advance can only contain 10 digits"
                }
            }

        });

    });

</script>



</body>
</html>