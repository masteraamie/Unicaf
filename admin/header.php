<?php

require_once 'master_engine/connection.php';
require_once 'master_engine/database_io.php';
$alerts = 0;

$dbIO = new DatabaseIO();
$admin = $dbIO->get_entry(TBL_ADMIN , "Name" , "1" , "1");
$_SESSION['admin'] = $admin;


$dbIO = new DatabaseIO();
$alerts = $dbIO->get_alerts(TBL_PRODUCTS , "COUNT(ID)" , "Quantity");


$_SESSION['alerts'] = $alerts;
?>
<noscript>
    <META HTTP-EQUIV="Refresh" CONTENT="0;URL=index.php">
</noscript>

<div class="header">

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6" style="color: #ffffff">
                Last Login : <a class="btn btn-sm btn-success"><span class="fa fa-clock-o"></span> <?php echo $_SESSION['time'];?></a>
            </div>
            <div class="col-lg-6">
                <div class="dropdown pull-right">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <?php echo $_SESSION['admin'];?>
                        <span class="fa fa-caret-down" style="padding-left: 10px"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="account_settings.php"><span class="fa fa-cogs"></span> Account Settings</a></li>
                        <li><a href="logout.php"><span class="fa fa-sign-out"></span> Sign out</a></li>
                    </ul>
                </div>

                <a href="alerts/alerts.php" class="btn btn-warning pull-right" style="margin-right: 8px"><span class="fa fa-bell"></span> <?php echo $_SESSION['alerts'];?></a>
            </div>
        </div>
    </div>

</div>