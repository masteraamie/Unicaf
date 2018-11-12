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
$name = $parentage = $address = $contact = $designation = $salary = $image = "";

$errors = array();

$validate = new Validation();

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['ID']))
{
    $id = $_GET["ID"];
    if($id != "" &&  is_numeric($id))
    {
        $query = "SELECT Name , Parentage , Address , Contact , Designation , Salary , Image from ".TBL_STAFF." WHERE ID = ?";
        $connection = new mysqli(HOST , USER , PASSWORD , DB_NAME);
        $statement = $connection->prepare($query);
        $statement->bind_param("i" , $id);
        $statement->execute();
        $statement->bind_result($name , $parentage , $address , $contact , $designation , $salary , $image);
        $statement->store_result();
        while($statement->fetch()){}

    }
}
else if($_SERVER["REQUEST_METHOD"] == "GET" && !isset($_GET['ID']))
    header("Location:manage_staff.php");

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

    $id = $_POST["id"];
    $name =trim($_POST["name"]);
    $parentage = trim($_POST["parentage"]);
    $address = trim($_POST["address"]);
    $contact =trim($_POST["contact"]);
    $designation =trim($_POST["designation"]);
    $salary =trim($_POST["salary"]);
    $current_image = $_POST["current_image"];
    $image = basename($_FILES["img"]["name"]);
    $current_name = $_POST["current_name"];

    $errors = $validate->validate_staff($name , $parentage , $address , $contact , $designation , $salary , "image");

    if(empty($errors))
    {
        if($image != "") {

            $validate->makeDirectories(STAFF_DIR);

            $imageType1 = pathinfo($current_image, PATHINFO_EXTENSION);
            $imageType2 = pathinfo($image, PATHINFO_EXTENSION);


            unlink(STAFF_DIR . $current_name . "_" . $id . "." . $imageType1);

            $image = STAFF_DIR . $name . "_" . $id . "." . $imageType2;

            $uploadStatus = $validate->imageValidate($_FILES['img']);

            if ($uploadStatus == 1) {

                if ($validate->imageUpload($image)) {
                    $validate->resizeImage($image);
                    $update = new Update();
                    if($update->update_staff($name , $parentage , $address , $contact , $designation , $salary , $image , $id) == 1) {
                        echo "<script>alert('Staff Member Updated Successfully');</script>";
                        echo "<script>window.location='manage_staff.php';</script>";
                    }
                    else
                        echo "<script>alert('Error Updating Staff Member');</script>";
                } else {
                    echo "<script>alert('Error Uploading Image');</script>";
                }
            }
        }
        else {
            $imageType1 = pathinfo($current_image, PATHINFO_EXTENSION);
            $image = STAFF_DIR . $name . "_" . $id . "." . $imageType1;

            rename($current_image , $image);

            $update = new Update();
            if($update->update_staff($name , $parentage , $address , $contact , $designation , $salary , $image , $id) == 1) {
                echo "<script>alert('Staff Member Updated Successfully');</script>";
                echo "<script>window.location='manage_staff.php';</script>";
            }
            else
                echo "<script>alert('Error Updating Staff Member');</script>";
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
    <link rel="icon" href="../../image/favicon.png">
    <link href="../../css/font-awesome.css" rel="stylesheet">
    <link href="../../bootstrap/css/bootstrap.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href="../main.css" rel="stylesheet">
    <link media="print" href="print.css" rel="stylesheet">
</head>
<body>

<noscript>
    <META HTTP-EQUIV="Refresh" CONTENT="0;URL=index.php">
</noscript>

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



                <div class="panel panel-primary dontprint">
                    <div class="panel-heading"><span class="fa fa-navicon"></span> Navigation</div>
                    <div class="panel-body" style="text-align: center">
                        <div class="btn-group btn-group-sm">
                            <a href="add_member.php" class="btn btn-default"><span class="fa fa-plus"></span> Add Staff Member</a>
                            <a href="manage_staff.php" class="btn btn-primary"><span class="fa fa-hand-pointer-o"></span> Manage Staff</a>
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
                    <div class="panel-heading dontprint"><span class="fa fa-edit"></span>  Edit Member</div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="row">

                                <form id="mainform" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

                                    <input name="id" id="id" value="<?php echo $id; ?>" type="hidden"/>
                                    <input name="current_image" id="image" value="<?php echo $image; ?>" type="hidden"/>
                                    <input name="current_name" id="curname" value="<?php echo $name; ?>" type="hidden"/>
                                    <div class="col-lg-6">
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <label class="dontprint">Existing Image</label>
                                                <image id="imgmem" src="<?php echo $image; ?>" style="width: 30%">
                                            </div>

                                            <div class="col-lg-12 dontprint">
                                                <label>New Photo (Passport Size) - If Nescessary</label>
                                                <input type="file" name="img" class="form-control">
                                            </div>

                                            <div class="col-lg-12">
                                                <label>Name</label>
                                                <input placeholder="e.g. Mushtaq Ahmed" value="<?php echo $name; ?>" type="text" class="form-control" name="name">
                                            </div>



                                            <div class="col-lg-12">
                                                <label>Parentage</label>
                                                <input placeholder="Mohammad Ayoub Khan" value="<?php echo $parentage; ?>" type="text" class="form-control" name="parentage">
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <label>Salary (in rupees)</label>
                                                <input placeholder="e.g. 10000" value="<?php echo $salary; ?>" type="text" class="form-control" name="salary">
                                            </div>

                                            <div class="col-lg-12">
                                                <label>Designation</label>
                                                <input placeholder="e.g. Accountant" type="text" value="<?php echo $designation; ?>" class="form-control" name="designation">
                                            </div>

                                            <div class="col-lg-12">
                                                <label>Contact</label>
                                                <input placeholder="e.g. 8491111111" value="<?php echo $contact; ?>"  type="text" class="form-control" name="contact">
                                            </div>

                                            <div class="col-lg-12">
                                                <label>Address</label>
                                                <textarea name="address" class="form-control"  style="height: 100px;resize: none"><?php echo $address; ?></textarea>
                                            </div>

                                            <div class="col-lg-12">
                                                <input type="submit" name="submit" value="Save Changes" class="btn dontprint btn-success pull-right">
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-6 dontprint pull-right" style="text-align: right;padding-right: 40px">
                                        <a href="#" class="btn btn-warning" id="exportpdf">Print / Save PDF</a>
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


        $("#exportpdf").click(function(){
            window.print();
        });


        $("#mainform").validate({
            rules: {
                name : {
                    required: true,
                    maxlength : 30
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