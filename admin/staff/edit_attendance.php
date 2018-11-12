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
$name = $status = "";

$errors = array();

$validate = new Validation();

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['ID']) && isset($_GET['Date']))
{
    $id = $_GET["ID"];
    $date = $_GET["Date"];
    if($id != "" &&  is_numeric($id))
    {
        $query = "SELECT Name , Status from ".TBL_ATTEND." WHERE (ID = ? and Date = ?)";
        $connection = new mysqli(HOST , USER , PASSWORD , DB_NAME);
        $statement = $connection->prepare($query);
        $statement->bind_param("is" , $id , $date);
        $statement->execute();
        $statement->bind_result($name , $status);
        $statement->store_result();
        while($statement->fetch()){}

    }
}
else if($_SERVER["REQUEST_METHOD"] == "GET" && !isset($_GET['ID']))
    header("Location:check_attendance.php");

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

    $id = $_POST['id'];
    $date = $_POST['date'];
    $status = $_POST['status'];
    $name = $_POST['name'];
    $errors = $validate->validate_attendence($id , $name , $status , "random");

    if(empty($errors))
    {
        $update = new Update();
        if($update->update_attendance($id , $date , $status) == 1)
        {
            echo "<script>alert('Attendence Updated Successfully');</script>";
            echo "<script>window.location='check_attendance.php';</script>";
        }
        else
        {
            echo "<script>alert('Error Updating Attendance');</script>";
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
                            <a href="do_attendance.php" class="btn btn-primary"><span class="fa fa-clock-o"></span> Do Attendance</a>
                            <a href="check_attendance.php" class="btn btn-default"><span class="fa fa-bar-chart-o"></span> Check Attendance</a>
                        </div>
                        <div class="btn-group btn-group-sm">
                            <a href="pay_salary.php" class="btn btn-default"><span class="fa fa-dollar"></span> Pay Salary</a>
                            <a href="view_salary.php" class="btn btn-default"><span class="fa fa-line-chart"></span> View Salary</a>
                        </div>
                    </div>
                </div>




                <div class="panel panel-primary">
                    <div class="panel-heading"><span class="fa fa-clock-o"></span>  Do Attendance</div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="row">

                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

                                    <input type="hidden" class="form-control" name="id" value="<?php echo $id;?>">
                                    <input type="hidden" class="form-control" name="date" value="<?php echo $date;?>">
                                    <div class="col-lg-12">

                                        <ul class="alert alert-danger">
                                            <?php echo $validate->displayErrors($errors); ?>
                                        </ul>

                                    </div>
                                    <div class="col-lg-6" style="padding: 30px">
                                        <label>Staff Member Name</label>
                                        <input type="text" class="form-control" name="name" value="<?php echo $name;?>">
                                        <label>Current Status</label>
                                        <input type="text" class="form-control" value="<?php echo $status;?>" disabled>
                                    </div>

                                    <div class="col-lg-6" style="padding: 30px">
                                        <label>Dated</label>
                                        <input type="text" class="form-control" disabled value="<?php echo $date;?>">

                                        <label>Change Status</label>
                                        <select class="form-control" name="status">
                                            <option>Absent</option>
                                            <option selected>Present</option>
                                            <option>Leave</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-6 pull-right" style="padding: 0px 30px 0px 30px">
                                        <input type="submit" name="submit" value="Update Attendance" class="btn btn-success pull-right">
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
<script src="../../bootstrap/js/bootstrap.min.js"></script>


</body>
</html>