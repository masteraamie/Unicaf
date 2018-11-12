<?php
require_once '../admin/master_engine/connection.php';
require_once '../admin/master_engine/database_io.php';
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
        $waiter = $_POST['waiter'];
        $table = $_POST['table'];

        $day = date("Y-m-d");

        if(!empty($items) && !empty($quantities) && !empty($total) && !empty($waiter) && !empty($table))
        {
            for ($i = 0; $i < count($items); $i++) {

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
            for ($i = 0; $i < count($items); $i++) {
                $soldItems .= $items[$i] . " X " . $quantities[$i] . " , ";
                $total_cost = $total_cost + ($cost[$i]*$quantities[$i]);
            }


            if ($success) {

                $today = date("d");
                $month = date("m");
                $year = date("Y");

                $profit = $total - $total_cost;
                $status = 0;
                $query2 = "INSERT INTO " . TBL_BILLING . " (`Items`, `Total`, `Status`, `Date` , `Profit` , `Cost` , ";
                $query2 .= "`Day` , `Month` , `Year` , `Waiter` , `TableNo`)  VALUES ( ? , ? , ? , ?  , ? , ? , ? , ? , ? , ? , ?)";
                $connection2 = new mysqli(HOST, USER, PASSWORD, DB_NAME);
                $command2 = $connection->prepare($query2);
                $command2->bind_param("sdisddiiisi", $soldItems, $total, $status, $day, $profit, $total_cost, $today, $month, $year , $waiter ,$table);
                $command2->execute();
            }
            echo $flag;
        }
        else
            echo "FAILURE";
    }
    catch(Exception $ex)
    {
        echo "FAILURE";
    }

}

?>