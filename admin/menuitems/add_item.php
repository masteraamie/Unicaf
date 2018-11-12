<?php
session_start();

if(!isset($_SESSION['user']))
{
    header("Location: ../index.php");
}
require_once("../master_engine/validations.php");
require_once("../master_engine/upload_modules.php");
require_once("../master_engine/database_io.php");


$errors = array();

$validate = new Validation();

//defining variables
$name = $cost = $price = $serial = "";


if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

    $name = trim($_POST['name']);
    $cost = trim($_POST['cp']);
    $price = trim($_POST['sp']);
    $serial = trim($_POST['serial']);

    $errors = $validate->validate_item($name , $cost , $price , $serial);

    if(empty($errors))
    {
        $upload = new Upload();
        if($upload->add_item($name, $cost , $price , $serial) == 1)
        {
            echo "<script>alert('Food Item Added Successfully');</script>";
        }
        else
        {
            echo "<script>alert('Error Adding Food Item');</script>";
        }
    }
    else
    {
        foreach($errors as $e)
        {
            echo "<script>alert('$e');</script>";
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
            <a href="index.php">
                <li class="active"><span class="fa fa-list"></span> Food / Menu Items</li>
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
                            <a href="add_item.php" class="btn btn-primary"><span class="fa fa-plus"></span> Add Menu Item</a>
                            <a href="manage_item.php" class="btn btn-default"><span class="fa fa-hand-pointer-o"></span> Manage Menu Item</a>
                        </div>
                        <div class="btn-group btn-group-sm">
                            <a href="pending_bills.php" class="btn btn-default"><span class="fa fa-dollar"></span> Pending Bills</a>
                            <a href="show_percentage.php" class="btn btn-default"><span class="fa fa-paperclip"></span> Show Bills Percentage</a>
                        </div>
                    </div>
                </div>




                <div class="panel panel-primary">
                    <div class="panel-heading"><span class="fa fa-plus-circle"></span> Add Menu Item</div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="row">

                                <form id="mainform" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

                                    <div class="col-lg-6">
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <label>Name</label>
                                                <input placeholder="e.g. Biryani" value="<?php echo $name; ?>" type="text" class="form-control" name="name">
                                            </div>


                                            <div class="col-lg-12">
                                                <label>Serial</label>
                                                <input placeholder="e.g. 12" value="<?php echo $serial; ?>" type="text" class="form-control" name="serial">
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <label>Cost Price (in rupees)</label>
                                                <input placeholder="e.g. 199" type="text" value="<?php echo $cost; ?>" class="form-control" name="cp">
                                            </div>

                                            <div class="col-lg-12">
                                                <label>Selling Price (in rupees)</label>
                                                <input placeholder="e.g. 220" value="<?php echo $price; ?>" type="text" class="form-control" name="sp">
                                            </div>


                                            <div class="col-lg-12">
                                                <input type="submit" name="submit" value="Add Item" class="btn btn-success pull-right">
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
                name : {
                    required: true,
                    maxlength : 30
                },
                cp : {
                    required: true,
                    number : true,
                    maxlength : 10
                },
                sp : {
                    required: true,
                    number : true,
                    maxlength : 10
                },
                serial : {
                    required: true,
                    number : true,
                    maxlength : 10
                }

            },
            messages: {
                name : {
                    required : "Please enter a name",
                    maxlength: "Name can only contain 30 characters"
                },
                cp : {
                    required : "Please enter a cost price",
                    number : "Cost price can only be a number",
                    maxlength: "Cost price can only contain 10 digits"
                },
                sp : {
                    required : "Please enter a selling price",
                    number : "Selling price can only be a number",
                    maxlength: "Selling price can only contain 10 digits"
                },
                serial : {
                    required : "Please enter a serial number for this item",
                    number : "Serial can only be a number",
                    maxlength: "Serial can only contain 10 digits"
                }
            }
        });

    });

</script>


</body>
</html>