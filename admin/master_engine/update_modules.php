<?php

class Update
{
    public $connection;
    public $validator;
    function __construct()
    {
        $this->connection = new mysqli(HOST , USER , PASSWORD , DB_NAME);
    }

    function update_staff($name , $parentage , $address , $contact , $designation , $salary , $image , $id)
    {
        try {
            $query = "UPDATE ".TBL_STAFF." SET `Name`= ? ,`Parentage`= ? ,`Address`= ?,";
            $query .= "`Contact`= ? ,`Designation`= ? ,`Salary`=  ? ,`Image`= ?  WHERE  ID = ?";

            $command = $this->connection->prepare($query);
            $command->bind_param("sssisisi", $name , $parentage , $address , $contact , $designation , $salary , $image , $id);

            if($command->execute()) {
                $this->connection->close();
                return 1;
            }
            else
            {
                $this->connection->close();
                unlink($image);
                return 0;
            }
        }
        catch(Exception $ex)
        {
            return 0;
        }
    }


    function update_quantity($itemID , $prodID , $quantity)
    {
        try {
            if($quantity == 0)
            {
                $query = "DELETE FROM " .TBL_QUANTITY . " WHERE (itemID = ? and prodID = ?)";
                $command = $this->connection->prepare($query);
                $command->bind_param("ii",  $itemID , $prodID);
            }
            else
            {
                $query = "UPDATE " . TBL_QUANTITY . " SET `Quantity`= ? ";
                $query .= "  WHERE (itemID = ? and prodID = ?)";
                $command = $this->connection->prepare($query);
                $command->bind_param("dii", $quantity , $itemID , $prodID);
            }

            $command->execute();

            return 1;
        }
        catch(Exception $ex)
        {
            return 0;
        }
    }

    function update_expenditure($name , $quantity , $amount , $paid , $balance , $id)
    {
        try {
            $query = "UPDATE ".TBL_EXPENDITURE." SET `Name`= ? , `Quantity`= ?, ";
            $query .= " `Amount`= ? , `Paid`= ? , `Balance`= ? WHERE ID = ?";

            $command = $this->connection->prepare($query);
            $command->bind_param("siiiii", $name , $quantity , $amount , $paid , $balance , $id);
            $command->execute();

            return 1;
        }
        catch(Exception $ex)
        {
            return 0;
        }
    }

    function update_product($name , $type , $barcode , $unit , $alert , $id)
    {
        try {
            $query = "UPDATE ".TBL_PRODUCTS." SET `Name`= ? ,`Barcode`= ? , ";
            $query .= "`Unit`= ? ,`Type`= ? ,`Alert`= ?  WHERE ID = ?";
            $command = $this->connection->prepare($query);
            $command->bind_param("sssssi", $name , $barcode  , $unit , $type , $alert , $id);
            $command->execute();

            return 1;
        }
        catch(Exception $ex)
        {
            return 0;
        }
    }

    function update_payment($id, $amount , $mode , $chqNumber , $date)
    {
        try {

            $month = date("m");
            $year = date("Y");

            $query = "SELECT Paid , Balance FROM ".TBL_DEPT_BILLS." WHERE (deptID = ? and Month = ? and Year = ?)";
            $command3 = $this->connection->prepare($query);
            $command3->bind_param("iii", $id , $month , $year);
            $command3->bind_result($prevPaid , $prevBal);
            $command3->execute();
            $command3->fetch();

            if($prevBal != "")
            {
                $newPaid = $prevPaid + $amount;
                $newBal = $prevBal - $amount;

                $connection = new mysqli(HOST , USER , PASSWORD , DB_NAME);
                $query2 = "UPDATE ".TBL_DEPT_BILLS." SET `Paid`= ?,`Balance`= ? ";
                $query2 .= " WHERE (deptID = ? and Month = ? and Year = ?)";
                $command2 = $connection->prepare($query2);
                $command2->bind_param("iiiii", $newPaid, $newBal, $id, $month, $year);
                $command2->execute();


                $db = new DatabaseIO();
                $deptName = $db->get_entry(TBL_DEPARTMENT , "Name" , "ID" , $id);

                $connection = new mysqli(HOST , USER , PASSWORD , DB_NAME);
                $query2 = "INSERT INTO  ".TBL_PAYMENT." (`deptName`, `deptID`, `Payment`, `Mode`, `Date`, `chqNumber` , `Month` , `Year`) ";
                $query2 .= " VALUES ( ? , ? , ? , ? , ? , ? , ? , ?)";
                $command2 = $connection->prepare($query2);
                $command2->bind_param("siisssii", $deptName , $id , $amount , $mode , $date , $chqNumber , $month  , $year);
                $command2->execute();

                return 1;
            }
            else
            {
                return 0;
            }
        }
        catch(Exception $ex)
        {
            return 0;
        }
    }

    function update_item($name , $cost , $price , $serial , $id)
    {
        try {
            $query = "UPDATE ".TBL_ITEMS." SET `Name`= ? ,`Cost`= ? , `Price` = ? , ";
            $query .= "`Serial`= ? WHERE ID = ?";
            $command = $this->connection->prepare($query);
            $command->bind_param("siiii", $name ,  $cost , $price , $serial , $id);
            $command->execute();

            return 1;
        }
        catch(Exception $ex)
        {
            return 0;
        }
    }

    function update_property($name , $quantity , $value , $id)
    {
        try {
            $query = "UPDATE ".TBL_PROPERTY." SET `Name`= ? ,`Quantity`= ? , `Value` = ? ";
            $query .= " WHERE ID = ?";
            $command = $this->connection->prepare($query);
            $command->bind_param("siii", $name ,  $quantity , $value , $id);
            $command->execute();

            return 1;
        }
        catch(Exception $ex)
        {
            return 0;
        }
    }

    function update_attendance($id , $date , $status)
    {
        try {
            $query = "UPDATE ".TBL_ATTEND." SET `Status`= ? ";
            $query .= " WHERE (ID = ? and Date = ?)";
            $command = $this->connection->prepare($query);
            $command->bind_param("sis", $status, $id , $date);
            $command->execute();

            return 1;
        }
        catch(Exception $ex)
        {
            return 0;
        }
    }

    function edit_admin($name , $username , $password)
    {
        try {

            $query = "UPDATE ".TBL_ADMIN." SET `Name`= ? ,`Username`= ? , `Password` = ?";
            $command = $this->connection->prepare($query);
            $command->bind_param("sss", $name , $username , $password);
            $command->execute();

            return 1;
        }
        catch(Exception $ex)
        {
            return 0;
        }
    }

    function update_vat($vat)
    {
        try {

            $query = "UPDATE ".TBL_VAT." SET `VAT`= ?";
            $command = $this->connection->prepare($query);
            $command->bind_param("d", $vat);
            $command->execute();

            return 1;
        }
        catch(Exception $ex)
        {
            return 0;
        }
    }

    function update_percent($percent)
    {
        try {

            $query = "UPDATE ".TBL_PERCENT." SET `Percent`= ?";
            $command = $this->connection->prepare($query);
            $command->bind_param("d", $percent);
            $command->execute();

            return 1;
        }
        catch(Exception $ex)
        {
            return 0;
        }
    }

    function release_stock_barcode($barcode , $quantity)
    {
        try {

            $query = "SELECT Quantity , Name from ".TBL_PRODUCTS." WHERE Barcode = ?";
            $command = $this->connection->prepare($query);
            $command->bind_param("i", $barcode);
            $command->bind_result($o_quantity , $name);
            $command->execute();
            while($command->fetch()){}

            $new_quantity = $o_quantity - $quantity;
            if($new_quantity > 0)
            {
                $query = "UPDATE " . TBL_PRODUCTS . " SET `Quantity` = ? WHERE ID = ?";
                $command = $this->connection->prepare($query);
                $command->bind_param("di", $new_quantity, $id);
                $command->execute();
                return 1;
            }
            else
            {
                echo "<script>alert('$name not enough in stock to serve the request !!!');</script>";
                return 0;
            }
        } catch (Exception $ex) {
            return 0;
        }
    }

    function release_stock_id($id , $quantity)
    {
        try {

            $query = "SELECT Quantity , Name from ".TBL_PRODUCTS." WHERE ID = ?";
            $command = $this->connection->prepare($query);
            $command->bind_param("i", $id);
            $command->bind_result($old_quantity , $name);
            $command->execute();
            while($command->fetch()){}

            $new_quantity = $old_quantity - $quantity;


            if($new_quantity > 0)
            {
                $query = "UPDATE " . TBL_PRODUCTS . " SET `Quantity` = ? WHERE ID = ?";
                $command = $this->connection->prepare($query);
                $command->bind_param("di", $new_quantity, $id);
                $command->execute();
                return 1;
            }
            else
            {
                echo "<script>alert('$name not enough in stock to serve the request   !!!');</script>";
                return 0;
            }


        } catch (Exception $ex) {
            return 0;
        }
    }

    public function pay_bill($id)
    {
        try {

            $query = "UPDATE ".TBL_BILLING." SET `Status`= 1 WHERE ID = ?";
            $command = $this->connection->prepare($query);
            $command->bind_param("i", $id);
            $command->execute();

            return 1;
        }
        catch(Exception $ex)
        {
            return 0;
        }
    }

    public function update_salary($paid, $newBalance, $month , $year , $id)
    {
        try {

            $query = "UPDATE ".TBL_SALARY." SET `Paid`= ? , Balance = ?  WHERE (staffID = ? and Month = ? and Year = ?)";
            $command = $this->connection->prepare($query);
            $command->bind_param("iiiii", $paid , $newBalance , $id , $month , $year);
            $command->execute();

            return 1;
        }
        catch(Exception $ex)
        {
            return 0;
        }
    }
    public function update_supplier($name , $id)
    {
        try {

            $query = "UPDATE ".TBL_SUPPLIER." SET `Name`= ? WHERE ID = ?";
            $command = $this->connection->prepare($query);
            $command->bind_param("si", $name , $id);
            $command->execute();

            return 1;
        }
        catch(Exception $ex)
        {
            return 0;
        }
    }

    public function update_department($name , $serial , $id)
    {
        try {

            $query = "UPDATE ".TBL_DEPARTMENT." SET `Name`= ? , `Serial` = ? WHERE ID = ?";
            $command = $this->connection->prepare($query);
            $command->bind_param("sii", $name , $serial , $id);
            $command->execute();

            return 1;
        }
        catch(Exception $ex)
        {
            return 0;
        }
    }
}

?>