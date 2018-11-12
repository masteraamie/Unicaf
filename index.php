<?php
session_start();
date_default_timezone_set("Asia/Calcutta");
if(isset($_SESSION['user']))
{
    header("Location: admin/index.php");
}
elseif(isset($_SESSION['employee']))
{
    header("Location: employee/index.php");
}

include_once 'admin/master_engine/validations.php';
include_once 'admin/master_engine/check_login.php';
//variables
$username = $password = "";


$errors = array();

$validate = new Validation();

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"]))
{
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);


    $check = new AdminLogin();
    $result = $check->check_login($username , $password);

    if($result == "ADMIN")
    {
        echo "<script>alert('Admin Login Successful');</script>";
        $_SESSION["user"] = $username;
        $_SESSION['time'] = date('h:i:s a', time());

        echo "<script>window.location='admin/index.php';</script>";
    }
    elseif($result == "USER")
    {
        echo "<script>alert('Employee Login Successful');</script>";
        $_SESSION["employee"] = $username;
        echo "<script>window.location='employee/index.php';</script>";
    }
    else
    {
        echo "<script>alert('Invalid Credentials');</script>";
    }
}

?>


<!DOCTYPE html>
<html>
<head lang="en">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">

    <link rel="icon" type="image/png" href="img/favicon.png">
    <link rel="stylesheet" href="css/login.css">

    <title>Unicaf Sign in</title>


</head>
<body>

<div class="main_panel">

    <div class="center" style="background: transparent !important;">
        <img src="img/signin_hanger.png" style="margin-bottom: -5px">
    </div>

    <div class="row center">
        <img src="img/logo.png" id="logo">
    </div>

    <div class="row">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <label style="letter-spacing: 2px">USERNAME</label>
            <input type="text" name="username">
            <label style="letter-spacing: 2px">PASSWORD</label>
            <input type="password" name="password">

            <input type="submit" name="submit" value="Sign in">
        </form>
    </div>

</div>

</body>
</html>