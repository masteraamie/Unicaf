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
$name = $parentage = $address = $contact = $designation = $salary = $image = "";

$errors = array();

$validate = new Validation();

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

    $name = trim($_POST["name"]);
    $parentage = trim($_POST["parentage"]);
    $address =trim($_POST["address"]);
    $contact = trim($_POST["contact"]);
    $designation = trim($_POST["designation"]);
    $salary = trim($_POST["salary"]);
    $image = basename($_FILES["img"]["name"]);

    $errors = $validate->validate_staff($name , $parentage , $address , $contact , $designation , $salary , $image);

    if(empty($errors))
    {
        $validate->makeDirectories(STAFF_DIR);

        $database_io = new DatabaseIO();
        $last_id = $database_io->get_last_id(TBL_STAFF);

        $last_id++;

        $imgType = pathinfo($image, PATHINFO_EXTENSION);

        $image = STAFF_DIR . $name."_".$last_id.".".$imgType;


        $uploadStatus = $validate->imageValidate($_FILES['img']);

        if($uploadStatus == 1) {

            if ($validate->imageUpload($image))
            {
                $upload = new Upload();
                if($upload->add_staff($name , $parentage , $address , $contact , $designation , $salary , $image) == 1)
                    echo "<script>alert('Staff Member Added Successfully');</script>";
                else
                    echo "<script>alert('Error Uploading Staff Member');</script>";
            }
            else
            {
                echo "<script>alert('Error Uploading Image');</script>";
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
                            <a href="add_member.php" class="btn btn-primary"><span class="fa fa-plus"></span> Add Staff Member</a>
                            <a href="manage_staff.php" class="btn btn-default"><span class="fa fa-hand-pointer-o"></span> Manage Staff</a>
                        </div>
                        <div class="btn-group btn-group-sm">
                            <a href="do_attendance.php" class="btn btn-default"><span class="fa fa-clock-o"></span> Do Attendance</a>
                            <a href="check_attendance.php" class="btn btn-default"><span class="fa fa-bar-chart-o"></span> Check Attendance</a>
                        </div>
                        <div class="btn-group btn-group-sm">
                            <a href="pay_salary.php" class="btn btn-default"><span class="fa fa-dollar"></span> Pay Salary</a>
                            <a href="view_salary.php" class="btn btn-default"><span class="fa fa-line-chart"></span> View Salary</a>
                        </div>
                    </div>
                </div>




                <div class="panel panel-primary">
                    <div class="panel-heading"><span class="fa fa-plus"></span>  Add Member</div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="row">

                                <form id="mainform" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"
                                      enctype="multipart/form-data">

                                    <div class="col-lg-6">
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <label>Photo (Passport Size)</label>
                                                <input type="file" name="img" class="form-control">
                                            </div>

                                            <div class="col-lg-12">
                                                <label>Name</label>
                                                <input placeholder="e.g. Mushtaq Ahmed" type="text" class="form-control" name="name">
                                            </div>

                                            <div class="col-lg-12">
                                                <label>Parentage</label>
                                                <input placeholder="Mohammad Ayoub Khan" type="text" class="form-control" name="parentage">
                                            </div>

                                            <div class="col-lg-12">
                                                <label>Salary (in rupees)</label>
                                                <input placeholder="e.g. 10000" type="text" class="form-control" name="salary">
                                            </div>

                                            <div class="col-lg-12">
                                                <label>Designation</label>
                                                <input placeholder="e.g. Accountant" type="text" class="form-control" name="designation">
                                            </div>


                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <label>Contact</label>
                                                <input placeholder="e.g. 8491981132" type="text" class="form-control" name="contact">
                                            </div>

                                            <div class="col-lg-12">
                                                <label>Address</label>
                                                <textarea name="address" class="form-control" style="height: 100px;resize: none"></textarea>
                                            </div>

                                            <div class="col-lg-12">
                                                <input type="submit" name="submit"  value="Add Member" class="btn btn-success pull-right">
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
                name : {
                    required: true,
                    maxlength : 30
                },
                img : {
                    required: true,
                    extension: "jpeg|jpg|png|JPEG|JPG|PNG"
                },
                address : {
                    required: true,
                    maxlength : 120
                },
                parentage : {
                    required: true,
                    maxlength : 40
                },
                designation : {
                    required: true,
                    maxlength : 40
                },
                salary : {
                    required: true,
                    number : true,
                    maxlength : 10
                },
                contact : {
                    required: true,
                    number : true,
                    maxlength : 12
                }

            },
            messages: {
                name : {
                    required : "Please enter a name",
                    maxlength: "Name can only contain 30 characters"
                },
                img : {
                    required : "Please select an image",
                    extension: "Unsupported Image Format"
                },
                address : {
                    required : "Please enter an address",
                    maxlength: "Address only contain 120 characters"
                },
                parentage : {
                    required : "Please enter parentage",
                    maxlength: "Parentage only contain 40 characters"
                },
                designation : {
                    required : "Please enter a designation",
                    maxlength: "Designation only contain 40 characters"
                },
                salary : {
                    required : "Please enter a salary",
                    number : "Salary can only be a number",
                    maxlength: "Salary can only contain 10 digits"
                },
                contact : {
                    required : "Please enter a contact no",
                    number : "Contact no can only be a number",
                    maxlength: "Contact no can only contain 12 digits"
                }
            }
        });

    });

</script>

</body>
</html>