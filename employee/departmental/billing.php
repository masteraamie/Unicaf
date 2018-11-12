<?php
require_once '../../admin/master_engine/connection.php';
require_once '../../admin/master_engine/database_io.php';
if($_SERVER["REQUEST_METHOD"] == "POST")
{

    try {

        $prodIds = array();

        $success = true;

        $flag = "";

        $cost = array();
        $total_cost = 0;

        $items = $_POST["items"];
        $quantities = $_POST["quantities"];
        $total = $_POST["total"];
        $deptID = $_POST["deptID"];
        $deptName = $_POST["deptName"];


        for ($i = 0; $i < count($items); $i++)
        {

            $query = "SELECT Cost  From " . TBL_ITEMS . " WHERE Name = ?";
            $connection = new mysqli(HOST, USER, PASSWORD, DB_NAME);
            $command = $connection->prepare($query);
            $command->bind_param("s", $items[$i]);
            $command->bind_result($cost[$i]);
            $command->execute();
            $command->store_result();
            $command->fetch();

        }

        $soldItems = "";
        $quantity = "";
        for ($i = 0; $i < count($items); $i++)
        {
            $soldItems .= $items[$i].",";
            $quantity .= $quantities[$i].",";
            $total_cost = $total_cost + ($cost[$i] * $quantities[$i]);
        }


        if($success)
        {

            $today = date("d");
            $month = date("m");
            $year = date("Y");



            $query2 = "SELECT Items , Quantity , Total , Profit , Cost , Balance FROM ".TBL_DEPT_BILLS." WHERE (deptID = ? and Month = ? and Year = ?)";
            $connection2 = new mysqli(HOST, USER, PASSWORD, DB_NAME);
            $command2 = $connection->prepare($query2);
            $command2->bind_param("iii" , $deptID , $month , $year);
            $command2->bind_result($prevItems , $prevQuantity , $prevTotal , $prevProfit, $prevCost , $prevBalance);
            $command2->execute();
            $command2->fetch();


            $profit = $total - $total_cost;

            if(empty($prevItems))
            {
                $paid = 0;
                $day = date("Y-m-d");
                $balance = $total;
                $query2 = "INSERT INTO " . TBL_DEPT_BILLS . "(`deptName`, `deptID`, `Items` , `Quantity` , `Total`, `Paid`, `Balance`, `Profit` , `Cost` , `Day`, `Month`, `Year`, `Date`)";
                $query2 .= " VALUES ( ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ?)";
                $connection2 = new mysqli(HOST, USER, PASSWORD, DB_NAME);
                $command2 = $connection->prepare($query2);
                $command2->bind_param("sissdddddiiis", $deptName, $deptID, $soldItems, $quantity, $total, $paid, $balance, $profit, $total_cost, $today, $month, $year, $day);
                $command2->execute();

                $flag = "SUCCESS";
            }
            else
            {

                $newItems = $prevItems.$soldItems;
                $newTotal = $total + $prevTotal;
                $newProfit = $profit + $prevProfit;
                $newCost = $total_cost + $prevCost;
                $paid = 0;
                $balance = $prevBalance + $total;

                $newQuantity = $prevQuantity.$quantity;

                $query = "UPDATE " . TBL_DEPT_BILLS . " SET `deptName` = ? , `Items` = ? , `Quantity` = ? , `Total` = ? , `Profit` = ? , `Cost` = ? , `Balance` = ? ";
                $query .= " WHERE (deptID = ? and Month = ? and Year = ?)";
                $conn = new mysqli(HOST, USER, PASSWORD, DB_NAME);
                $comm = $conn->prepare($query);
                $comm->bind_param("sssddddiii", $deptName, $newItems , $newQuantity , $newTotal , $newProfit , $newCost  ,$balance , $deptID , $month , $year);
                $comm->execute();

                $flag = "SUCCESS";
            }

        }
        echo $flag;
    }
    catch(Exception $ex)
    {
        echo "FAILURE";
    }
}

?>