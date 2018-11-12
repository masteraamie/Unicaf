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
$name = $quantity = $amount = $paid = $balance  = "";

$errors = array();

$validate = new Validation();


if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['ID']))
{
    $id = $_GET["ID"];
    if($id != "" &&  is_numeric($id))
    {
        $query = "SELECT Name , Quantity , Amount , Paid , Balance from ".TBL_EXPENDITURE." WHERE ID = ?";
        $connection = new mysqli(HOST , USER , PASSWORD , DB_NAME);
        $statement = $connection->prepare($query);
        $statement->bind_param("i" , $id);
        $statement->execute();
        $statement->bind_result($name , $quantity , $amount , $paid , $balance);
        $statement->store_result();
        while($statement->fetch()){}

    }
}
else if($_SERVER["REQUEST_METHOD"] == "GET" && !isset($_GET['ID']))
    header("Location:manage_exp.php");

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

    $id = $_POST["id"];
    $name = trim($_POST['name']);
    $quantity = trim($_POST['qnty']);
    $amount = trim($_POST['amt']);
    $paid = trim($_POST['paid']);

    $errors = $validate->validate_expenditure($name , $quantity , $amount , $paid);

    if(empty($errors))
    {
        $balance = $amount - $paid;
        $update = new Update();
        if($update->update_expenditure($name , $quantity , $amount , $paid , $balance , $id) == 1)
        {
            echo "<script>alert('Expenditure Updated Successfully');</script>";
            echo "<script>window.location='manage_exp.php';</script>";
        }
        else
            echo "<script>alert('Error Updating Expenditure');</script>";
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
            <a href="manage_exp.php">
                <li class="active"><span class="fa fa-money"></span> Expenditure</li>
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
                            <a href="add_exp.php" class="btn btn-default"><span class="fa fa-plus"></span> Add Expenditure</a>
                            <a href="manage_exp.php" class="btn btn-primary"><span class="fa fa-hand-pointer-o"></span> Manage Expenditure</a>
                        </div>
                    </div>
                </div>




                <div class="panel panel-primary">
                    <div class="panel-heading"><span class="fa fa-edit"></span> Edit Expenditure</div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="row">

                                <form id="mainform" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                    <input name="id" id="id" class="form-control" value="<?php echo $id; ?>" type="hidden" />
                                    <div class="col-lg-6">
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <label>Expenditure Name</label>
                                                <input placeholder="e.g. Electricity Bill" type="text" value="<?php echo $name; ?>" class="form-control" name="name">
                                            </div>


                                            <div class="col-lg-12">
                                                <label>Quantity</label>
                                                <input placeholder="e.g. 12" type="text" value="<?php echo $quantity; ?>" class="form-control" name="qnty">
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <label>Amount (in rupees)</label>
                                                <input placeholder="e.g. 220" type="text" value="<?php echo $amount; ?>" class="form-control" name="amt">
                                            </div>

                                            <div class="col-lg-12">
                                                <label>Paid (in rupees)</label>
                                                <input placeholder="e.g. 220" type="text" value="<?php echo $paid; ?>" class="form-control" name="paid">
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
                qnty : {
                    required: true,
                    number : true,
                    maxlength : 10
                },
                amt : {
                    required: true,
                    number : true,
                    maxlength : 10
                },
                paid : {
                    required: true,
                    number : true,
                    maxlength : 10
                }

            },
            messages: {
                name : {
                    required : "Please enter an expenditur name",
                    maxlength: "Expenditure name can only contain 40 characters"
                },
                qnty : {
                    required : "Please enter a quantity",
                    number : "Quantity can only be a number",
                    maxlength: "Quantity can only contain 10 digits"
                },
                amt : {
                    required : "Please enter an amount",
                    number : "Amount can only be a number",
                    maxlength: "Amount can only contain 10 digits"
                },
                paid : {
                    required : "Please enter a paid amount",
                    number : "Paid amount can only be a number",
                    maxlength: "Paid amount can only contain 10 digits"
                }
            }
        });

    });

</script>


</body>
</html>