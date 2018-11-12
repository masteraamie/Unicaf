<?php
session_start();

if(!isset($_SESSION['user']))
{
    header("Location: ../login.php");
}

require_once("../master_engine/validations.php");
require_once("../master_engine/upload_modules.php");
require_once("../master_engine/database_io.php");


$errors = array();

$dbIO = new DatabaseIO();

$namesArr =  $dbIO->get_entries_with_id(TBL_STAFF , "Name");
$salaryArr = $dbIO->get_entries_with_id(TBL_STAFF , "Salary");

$validate = new Validation();

//defining variables
$name = $salary = $date = "";


if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

    $selected_id = $_POST['staff'];

    $selected_name = $namesArr[$selected_id];

    $salaryPaid = $_POST['pay_sal'];

    $date = date("Y-m-d");

    $current = $_POST['cur_sal'];



    $errors = $validate->validate_salary($selected_id , $selected_name , $salaryPaid);

    if(empty($errors))
    {
        $balance = $current - $salaryPaid;
        $upload = new Upload();
        if($upload->add_salary($selected_id , $selected_name , $salaryPaid , $current , $date , $balance) == 1)
        {
            echo "<script>alert('Salary Uploaded Successfully');</script>";
        }
        else
        {
            echo "<script>alert('Error Uploading Salary');</script>";
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
                            <a href="pay_salary.php" class="btn btn-primary"><span class="fa fa-dollar"></span> Pay Salary</a>
                            <a href="view_salary.php" class="btn btn-default"><span class="fa fa-line-chart"></span> View Salary</a>
                        </div>
                    </div>
                </div>




                <div class="panel panel-primary">
                    <div class="panel-heading"><span class="fa fa-dollar"></span>  Pay Salary</div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="row">

                                <form id="mainform" action="" method="post">

                                    <div class="col-lg-6">
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <label>Select Staff Member</label>
                                                <select name="staff" id="staff" class="form-control">
                                                    <?php

                                                    foreach($namesArr as $k => $n)
                                                    {
                                                        echo "<option value='$k'>";
                                                        echo    $n;
                                                        echo "</option>";
                                                    }

                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-lg-12">
                                                <label>Current Salary Amount (in rupees)</label>
                                                <input type="text" id="current" name="cur_sal" class="form-control">
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <label>Paid Salary Amount (in rupees)</label>
                                                <input type="text" name="pay_sal" class="form-control">
                                            </div>

                                            <div class="col-lg-12">
                                                <input type="submit" name="submit" value="Pay Salary" class="btn btn-success pull-right">
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


        var name = <?php $count = 1; print "[";foreach($namesArr as  $n){ if($count==1){ print "'$n'";++$count;}else{echo ",'$n'";}}print "];"; ?>
        var salary = <?php $count = 1; print "[";foreach($salaryArr as  $n){ if($count==1){ print "'$n'";++$count;}else{echo ",'$n'";}}print "];"; ?>


            getSalary();

        function getSalary()
        {
            var first = $("#staff").find(":selected").text();
            var index = name.indexOf(first);

            $("#current").val(salary[index]);
        }

        $("#staff").change(function(){
            getSalary();
        });

        $("#mainform").validate({
            rules: {
                cur_sal : {
                    required: true,
                    number : true,
                    maxlength : 10
                },
                pay_sal : {
                    required: true,
                    number : true,
                    maxlength : 10
                }

            },
            messages: {
                cur_sal : {
                    required : "Please enter the current salary",
                    number : "Current salary can only be a number",
                    maxlength: "Current salary can only contain 10 digits"
                },
                pay_sal : {
                    required : "Please enter the paid salary",
                    number : "Paid salary can only be a number",
                    maxlength: "Paid salary can only contain 10 digits"
                }
            }
        });

    });

</script>



</body>
</html>