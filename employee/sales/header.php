<?php

require_once '../../admin/master_engine/connection.php';
require_once("../../admin/master_engine/validations.php");
require_once("../../admin/master_engine/update_modules.php");

$alerts = 0;

$dbIO = new DatabaseIO();
$alerts = $dbIO->get_alerts(TBL_PRODUCTS , "COUNT(ID)" , "Quantity");


$_SESSION['alerts'] = $alerts;


$dbIO = new DatabaseIO();
$date = date("Y-m-d");
$pendingBills = $dbIO->get_entries_where(TBL_BILLING , "ID" , "Date = '$date' and Status" , 0);


if($_SERVER["REQUEST_METHOD"] == "POST")
{

    $validate = new Validation();

    $id = trim($_POST['id']);

    $errors = $validate->validate_bill($id);

    if(empty($errors))
    {
        $update = new Update();

        if($update->pay_bill($id) == 1)
        {
            echo "<script>alert('Bill Paid Successfully')</script>";
            echo "<script>window.location='index.php';</script>";
        }
        else
        {
            echo "<script>alert('Bill Payment Not Successful')</script>";
        }

    }
    else
    {
        $err = $errors['id'];
        echo "<script>alert('$err')</script>";
    }


}
?>
<div class="container-fluid dontprint headerr">
    <div class="row">
        <div class="col-lg-3" style="text-indent: 20px;color: #ffffff;padding-top: 5px">
            Welcome <?php echo $_SESSION['employee'];?>
        </div>
        <div class="col-lg-9">

            <div class="dropdown pull-right justfocus" style="margin-right: 7px">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <?php echo $_SESSION['employee'];?>
                    <span class="fa fa-caret-down" style="padding-left: 10px"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li><a href="logout.php"><span class="fa fa-sign-out"></span> Sign out</a></li>
                </ul>
            </div>


            <a href="index.php" class="btn btn-success pull-right">
                <span class="fa fa-dollar"></span> Sales
            </a>


            <div class="dropdown pull-right justfocus"  style="margin-right: 10px !important;">
                <a href="../alerts.php" class="btn btn-warning pull-right" style="margin-right: 8px"><span class="fa fa-bell"></span> <?php echo $_SESSION['alerts'];?></a>
            </div>


            <a href="../pending_bills.php" class="btn btn-warning pull-right"><span class="fa fa-question-circle"></span> Pending Bills : <?php echo count($pendingBills);?></a>

            <div class="pull-right" style="margin-right: 10px">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <input placeholder="Scan Pending Bills Here" type="password" name="id" id="scan_barcode" style="display: inline !important;"  class="form-control">
                </form>
            </div>

            <div class="dropdown pull-right justfocus"  style="margin-right: 17px !important;">
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <span class="fa fa-keyboard-o" style="padding-right: 5px"></span>
                    Shortcut Keys
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li><a href="#"><span class="fa fa-key"></span> Ctrl + P (Print Bill)</a></li>
                    <li><a href="#"><span class="fa fa-key"></span> Ctrl + B (Scan Pending Bills)</a></li>
                    <li><a href="#"><span class="fa fa-key"></span> Tab (To Navigate)</a></li>
                </ul>
            </div>

        </div>
    </div>
</div>