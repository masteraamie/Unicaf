<?php
session_start();

if(!isset($_SESSION['user']))
{
    header("Location: ../index.php");
}
$ID = $TABLE = "";

require_once '../master_engine/database_io.php';
if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["ID"]) && isset($_GET["TABLE"]))
{
    $ID = is_numeric($_GET["ID"]) ? $_GET["ID"] : 0;
    $TABLE = $_GET["TABLE"];

    $dataIO = new DatabaseIO();
    if($dataIO->delete_item($ID , $TABLE) == 1) {
        echo "<script>alert('Item Deleted Successfully');</script>";
        echo "<script>window.history.back();</script>";
    }
}


?>