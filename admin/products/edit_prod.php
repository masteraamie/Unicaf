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

$validate = new Validation();

//defining variables
$name = $type = $barcode = $unit = "";
$quantity = $alert = "";

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['ID']))
{
    $id = $_GET["ID"];
    if($id != "" &&  is_numeric($id))
    {
        $query = "SELECT `Name`, `Barcode`, `Unit`, `Type`, `Alert` from ".TBL_PRODUCTS." WHERE ID = ?";
        $connection = new mysqli(HOST , USER , PASSWORD , DB_NAME);
        $statement = $connection->prepare($query);
        $statement->bind_param("i" , $id);
        $statement->execute();
        $statement->bind_result($name , $barcode , $unit , $type , $alert);
        $statement->store_result();
        while($statement->fetch()){}

    }
}
else if($_SERVER["REQUEST_METHOD"] == "GET" && !isset($_GET['ID']))
    header("Location:manage_products.php");


if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

    $id = $_POST["id"];
    $name = trim($_POST['name']);
    $type = trim($_POST['cat']);
    $barcode = $type == "Packaged" ? trim($_POST['barcode']) : "NA";
    $unit = trim($_POST['unit']);
    $alert = trim($_POST['alertQnty']);

    $errors = $validate->validate_edit_product($name , $type , "NA" , $unit , $alert);

    if(empty($errors))
    {
        $update = new Update();
        if($update->update_product($name , $type , $barcode , $unit , $alert  , $id) == 1)
        {
            echo "<script>alert('Product Updated Successfully');</script>";
            echo "<script>window.location = 'manage_prod.php';</script>";
        }
        else
        {
            echo "<script>alert('Error Updating Product');</script>";
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
                    <div class="panel-heading"><span class="fa fa-edit"></span> Edit Product</div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="row">
                                <form id="mainform" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

                                    <input name="id" id="id" class="form-control" value="<?php echo $id; ?>" type="hidden" />
                                    <div class="col-lg-6">
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <label>Category</label>
                                                <select id="cat" name="cat" class="form-control">
                                                    <option <?php  echo $type == "Packaged" ? "selected":"" ?>>Packaged</option>
                                                    <option <?php  echo $type == "Non Packaged" ? "selected":"" ?>>Non Packaged</option>
                                                </select>
                                            </div>

                                            <div class="col-lg-12">
                                                <label>Name</label>
                                                <input placeholder="e.g. American Lays - M" value="<?php echo $name; ?>" type="text" class="form-control" name="name">
                                            </div>

                                            <div class="col-lg-12">
                                                <label>Unit</label>
                                                <select name="unit" class="form-control">
                                                    <option <?php  echo $unit == "Kg" ? "selected":"" ?>>Kgs</option>
                                                    <option <?php  echo $unit == "No" ? "selected":"" ?>>No</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <label>Alert Quantity</label>
                                                <input placeholder="e.g. 5" type="text" value="<?php echo $alert; ?>" class="form-control" name="alertQnty">
                                            </div>

                                            <div id="barcode" class="col-lg-12">
                                                <label>Barcode</label>
                                                <input placeholder="Scan Here" value="<?php echo $barcode; ?>" type="text" class="form-control" name="barcode">
                                            </div>

                                            <div class="col-lg-12">
                                                <input type="submit" name="submit" value="Save Changes" class="btn btn-success pull-right">
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
                alertQnty : {
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
                alertQnty : {
                    required : "Please enter an alert quantity",
                    number : "Alert quantity can only be a number",
                    maxlength: "Alert Quantity can only contain 10 digits"
                }
            }
        });

    });

</script>


</body>
</html>