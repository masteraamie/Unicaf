<?php
session_start();

if(!isset($_SESSION['user']))
{
    header("Location: ../login.php");
}
require_once("../master_engine/validations.php");
require_once("../master_engine/update_modules.php");
require_once("../master_engine/database_io.php");


$errors = array();

$dbIO = new DatabaseIO();

$namesArr =  $dbIO->get_entries_with_id(TBL_PRODUCTS , "Name");

$validate = new Validation();



//defining variables
$name = $barcode = $quantity = "";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {


    $barcode = trim($_POST['barcode']);

    $quantity = trim($_POST['qnty']);

    $id = $_POST['product'];

    $update = new Update();

    if($barcode != "")
    {
        $errors = $validate->validate_release_barcode($barcode  , $quantity);

        if(empty($errors))
        {
            if($update ->release_stock_barcode($barcode , $quantity) == 1)
            {
                echo "<script>alert('Stock Released Successfully');</script>";
            }
            else
            {
                echo "<script>alert('Stock Release Failed');</script>";
            }
        }
    }
    else
    {
        $errors = $validate->validate_release_stock($id  , $quantity);

        if(empty($errors))
        {
            if($update ->release_stock_id($id , $quantity) == 1)
            {
                echo "<script>alert('Stock Released Successfully');</script>";
            }
            else
            {
                echo "<script>alert('Stock Release Failed');</script>";
            }
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
            <a href="view_stock.php">
                <li class="active"><span class="fa fa-book"></span> Stock</li>
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
                            <a href="add_stock.php" class="btn btn-default"><span class="fa fa-plus"></span> Add Stock</a>
                            <a href="view_stock.php" class="btn btn-default"><span class="fa fa-eye"></span> View Stock</a>
                            <a href="release_stock.php" class="btn btn-primary"><span class="fa fa-minus"></span> Release Stock</a>
                            <a href="return_stock.php" class="btn btn-default"><span class="fa fa-backward"></span> Return Stock</a>
                        </div>
                    </div>
                </div>




                <div class="panel panel-primary">
                    <div class="panel-heading"><span class="fa fa-minus"></span> Release Stock</div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="row">
                                <form id="mainform" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label>Scan Barcode</label>
                                                <input type="text" name="barcode" class="form-control" placeholder="Scan Barcode Here">
                                            </div>
                                            <div class="col-lg-12" style="text-align: center">
                                                <a class="btn btn-primary" href="javascript:void(0)">OR</a>
                                            </div>
                                            <div class="col-lg-12">
                                                <label>Select Product</label>
                                                <select name="product" class="form-control">
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
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label>Release Quantity</label>
                                                <input type="text" name="qnty" class="form-control" placeholder="e.g. 10">
                                            </div>
                                            <div class="col-lg-12">
                                                <input type="submit" name="submit" value="Release Stock" class="btn btn-success pull-right">
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
                qnty : {
                    required: true,
                    number : true,
                    maxlength : 10
                }

            },
            messages: {
                qnty : {
                    required : "Please enter a quantity",
                    number : "Quantity can only be a number",
                    maxlength: "Quantity can only contain 10 digits"
                }
            }
        });

    });

</script>


</body>
</html>