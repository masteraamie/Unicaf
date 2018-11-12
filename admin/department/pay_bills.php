<?php
session_start();

if(!isset($_SESSION['user']))
{
    header("Location: ../index.php");
}
require_once("../master_engine/validations.php");
require_once("../master_engine/update_modules.php");
require_once("../master_engine/database_io.php");


$errors = array();

$validate = new Validation();

//defining variables
$name =  "";

$dbIO = new DatabaseIO();

$departments = $dbIO->get_entries_with_id(TBL_DEPARTMENT , "Name");


if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

    $id = trim($_POST['department']);

    $amount = trim($_POST['paid']);

    $mode = trim($_POST['mode']);

    $chqNumber = $mode == "Cash" ? "NA" : trim($_POST['chqNumber']);

    $date = $_POST['date'];

    if($id != "")
    {
        $upload = new Update();
        if($upload->update_payment($id, $amount , $mode , $chqNumber , $date) == 1)
        {
            echo "<script>alert('Payment Added Successfully');</script>";
        }
        else
        {
            echo "<script>alert('Error Adding Payment');</script>";
        }
    }
    else
    {
        echo  "<script>alert('Name Cannot be Left Empty');</script>";
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
    <link href="../../js/jqueryui.css" rel="stylesheet">

    <style>

        .show_print{
            display: none;
        }



    </style>


    <link href="print.css" media="print" rel="stylesheet">


</head>
<body>

<div class="sidebar dontprint">

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
            <a href="manage_dep.php">
                <li class="active"><span class="fa fa-home"></span> Department</li>
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



                <div class="panel panel-primary dontprint">
                    <div class="panel-heading"><span class="fa fa-navicon"></span> Navigation</div>
                    <div class="panel-body" style="text-align: center">
                        <div class="btn-group btn-group-sm">
                            <a href="add_dep.php" class="btn btn-default"><span class="fa fa-plus"></span> Add Department</a>
                            <a href="manage_dep.php" class="btn btn-default"><span class="fa fa-hand-pointer-o"></span> Manage Department</a>
                        </div>
                        <div class="btn-group btn-group-sm">
                            <a href="dep_sales.php" class="btn btn-default"><span class="fa fa-dollar"></span> Sales</a>
                            <a href="manage_vat.php" class="btn btn-default"><span class="fa fa-area-chart"></span> Manage Vat</a>
                            <a href="pay_bills.php" class="btn btn-primary"><span class="fa fa-money"></span> Pay Bills</a>
                            <a href="view_bal.php" class="btn btn-default"><span class="fa fa-table"></span> View Balance</a>
                            <a href="dep_payments.php" class="btn btn-default"><span class="fa fa-table"></span> View Payments</a>
                        </div>
                    </div>
                </div>




                <div class="panel panel-primary">
                    <div class="panel-heading dontprint"><span class="fa fa-money"></span> Pay Bills  (crtl + p to Print Receipt)</div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="row">

                                <div class="col-lg-12">
                                    <h6 class="show_print" style="padding-left: 15px">TIN NO. : 01832121747</h6>

                                    <img src="../../img/logo_print.png" style="width: 100px" class="show_print center-block">
                                    <h3 class="show_print" style="text-align: center;margin: 0px !important;">University Cafeteria</h3>

                                    <h6 class="show_print"><div style="width: 50%;padding-left: 25px;font-weight: bold !important;"><?php echo date('D')." , ".date('d M, Y');  ?></div>
                                </h6>
                                </div>

                                <form id="mainform" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

                                    <div class="col-lg-6">
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <label>Department</label>
                                                <select name="department" class="form-control dept">
                                                    <?php
                                                    foreach($departments as $k => $n)
                                                    {
                                                        echo "<option value='$k'>";
                                                        echo    $n;
                                                        echo "</option>";
                                                    }

                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-lg-12">
                                                <label>The Sum Of Rupees </label>
                                                <input type="text" name="paid" class="form-control paid">
                                            </div>

                                            <div class="col-lg-12">
                                                <label>Date</label>
                                                <input type="text" id="date" contenteditable="false" name="date" class="form-control date">
                                            </div>

                                        </div>
                                    </div>



                                    <div class="col-lg-6">
                                        <div class="row secondrow">

                                            <div class="col-lg-12" id="chqHolder">
                                                <label>Cheque Number</label>
                                                <input type="text" name="chqNumber" class="form-control chqnum">
                                            </div>

                                            <div class="col-lg-12">
                                                <label>Payment Mode</label>
                                                <select name="mode" id="mode" class="form-control mode">
                                                    <option>Cheque</option>
                                                    <option>Cash</option>
                                                </select>
                                            </div>

                                            <div class="col-lg-12 show_print" style="text-align: right !important;width:100% !important;padding-top:10px;font-family: sans-serif;font-weight: bold">
                                                <div class="pull-right" style="text-align: right !important;">Signature</div>
                                            </div>

                                            <div class="col-lg-12">
                                                <input type="submit" name="submit" value="Pay Amount" class="btn dontprint btn-success pull-right">
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
<script src="../../js/jqueryui.js"></script>
<script src="../../js/jquery.validate.js"></script>
<script src="../../bootstrap/js/bootstrap.min.js"></script>

<script>


    $(document).ready(function(){

        var clonech=$("#chqHolder");

        $("#mode").click(function(){
            if($("#mode :selected").val() == "Cash"){
                $("#chqHolder").slideUp();
                $("#chqHolder").remove();
            }
            else{
                $(".secondrow").prepend(clonech);
                $("#chqHolder").slideDown();
            }
        });

        $("#date").datepicker();

        $("#mainform").validate({
            rules: {
                paid : {
                    required: true,
                    maxlength : 10,
                    number : true
                },
                date : {
                    required: true
                }

            },
            messages: {
                paid : {
                    required : "Please enter a paid amount",
                    maxlength: "Paid Amount cannot contain more than 10 digits",
                    number : "Paid amount cann only be a number"
                },
                date : {
                    required : "Please select a date"
                }
            }
        });

    });

</script>


</body>
</html>