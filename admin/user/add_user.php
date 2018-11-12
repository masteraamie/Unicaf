<?php
session_start();

if(!isset($_SESSION['user']))
{
    header("Location: ../index.php");
}
require_once("../master_engine/validations.php");
require_once("../master_engine/upload_modules.php");
require_once("../master_engine/database_io.php");

//defining variables
$username = "";

$errors = array();

$validate = new Validation();

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm =  trim($_POST['cpass']);

    $errors = $validate->validate_user($username , $password , $confirm);

    if(empty($errors))
    {

        $upload = new Upload();
        if($upload->add_user($username , $password) == 1)
        {
            echo "<script>alert('User Added Successfully');</script>";
        }
        else
            echo "<script>alert('Error Adding User');</script>";
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
            <a href="../staff/index.php">
                <li><span class="fa fa-users"></span> Staff</li>
            </a>
            <a href="manage_user.php">
                <li class="active"><span class="fa fa-user"></span> User</li>
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
                            <a href="add_user.php" class="btn btn-primary"><span class="fa fa-plus"></span> Add User</a>
                            <a href="manage_user.php" class="btn btn-default"><span class="fa fa-hand-pointer-o"></span> Manage User</a>
                        </div>
                    </div>
                </div>




                <div class="panel panel-primary">
                    <div class="panel-heading"><span class="fa fa-plus-circle"></span> Add User</div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="row">
                                <form id="mainform" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

                                    <div class="col-lg-6">
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <label>Username</label>
                                                <input type="text" name="username" class="form-control" placeholder="e.g. employee">
                                            </div>

                                            <div class="col-lg-12">
                                                <label>Password</label>
                                                <input type="password" id="password" name="password" class="form-control">
                                            </div>


                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="row">


                                            <div class="col-lg-12">
                                                <label>Confirm Password</label>
                                                <input type="password" name="cpass" class="form-control">
                                            </div>

                                            <div class="col-lg-12">
                                                <input type="submit" name="submit" value="Add User" class="btn btn-success pull-right">
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
<script src="../../js/additional-methods.js"></script>
<script src="../../bootstrap/js/bootstrap.min.js"></script>

<script>


    $(document).ready(function(){


        $("#mainform").validate({
            rules: {
                username : {
                    required: true,
                    maxlength : 50
                },
                password : {
                    required: true,
                    maxlength : 50
                },
                cpass : {
                    required : true,
                    equalTo : "#password"

                }
            },
            messages: {
                username : {
                    required : "Please enter a username",
                    maxlength: "Username name can only contain 50 characters"
                },
                password : {
                    required : "Please enter a password",
                    maxlength: "Password can only contain a maximum of 50 characters"
                },
                cpass : {
                    required : "Please enter a password",
                    maxlength: "Password can only contain a maximum of 50 characters",
                    equalTo : "This must be same as the above password"
                }
            }
        });

    });

</script>


</body>
</html>