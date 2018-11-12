<?php
require_once "connection.php";
require_once "validations.php";
class Upload
{
    public $connection;
    public $validator;

    function __construct()
    {
        $this->connection = new mysqli(HOST, USER, PASSWORD, DB_NAME);
        $this->validator = new Validation();
    }

    function add_staff($name, $parentage, $address, $contact, $designation, $salary, $image)
    {
        try {
            $query = "INSERT INTO " . TBL_STAFF . " (Name , Parentage , Address , Contact , Designation , Salary , Image)";
            $query .= " VALUES (? , ? , ? , ? , ? , ? , ? )";

            $command = $this->connection->prepare($query);
            $command->bind_param("sssisis", $name, $parentage, $address, $contact, $designation, $salary, $image);

            if ($command->execute()) {
                $this->connection->close();
                $this->validator->resizeImage($image);
                return 1;
            } else {
                $this->connection->close();
                unlink($image);
                return 0;
            }
        } catch (Exception $ex) {
            return 0;
        }
    }

    function add_attendence($id, $name, $status, $date)
    {
        try {

            $day = date('d');
            $month = date('m');
            $year = date('Y');

            $query = "INSERT INTO " . TBL_ATTEND . " (ID , Name , Status , Day , Month , Year , Date)";
            $query .= " VALUES (? , ? , ? , ? , ? , ? , ?)";

            $command = $this->connection->prepare($query);
            $command->bind_param("issiiis", $id, $name, $status, $day, $month, $year, $date);
            $command->execute();

            return 1;
        } catch (Exception $ex) {
            return 0;
        }
    }

    function add_expenditure($name, $quantity, $amount, $paid, $balance)
    {
        try {

            $day = date("Y-m-d");

            $query = "INSERT INTO " . TBL_EXPENDITURE . " (Name , Quantity , Amount , Paid , Balance , Date)";
            $query .= " VALUES (? , ? , ? , ? , ? , ?)";

            $command = $this->connection->prepare($query);
            $command->bind_param("siiiis", $name, $quantity, $amount, $paid, $balance , $day);
            $command->execute();

            return 1;
        } catch (Exception $ex) {
            return 0;
        }
    }

    function add_supplier($name)
    {
        try {

            $query = "INSERT INTO " . TBL_SUPPLIER . " (Name)";
            $query .= " VALUES (?)";

            $command = $this->connection->prepare($query);
            $command->bind_param("s", $name);
            $command->execute();

            return 1;
        } catch (Exception $ex) {
            return 0;
        }
    }

    function add_product($name , $type , $barcode , $unit , $alert , $quantity)
    {
        try {

            $query = "INSERT INTO " . TBL_PRODUCTS . " (`Name`, `Barcode`, `Unit`, `Type`, `Alert` , `Quantity`) ";
            $query .= " VALUES (? , ? , ? , ? , ? , ?)";

            $command = $this->connection->prepare($query);
            $command->bind_param("ssssid", $name, $barcode, $unit, $type, $alert , $quantity);
            $command->execute();

            return 1;
        } catch (Exception $ex) {
            return 0;
        }
    }
    function add_item($name, $cost, $price, $serial)
    {
        try {
            $query = "INSERT INTO " . TBL_ITEMS . " (`Name`, `Cost`, `Price`, `Serial`) ";
            $query .= " VALUES (? , ? , ? , ?)";

            $command = $this->connection->prepare($query);
            $command->bind_param("siii", $name, $cost, $price, $serial);
            $command->execute();

            return 1;
        } catch (Exception $ex) {
            return 0;
        }
    }
    function add_department($name , $serial)
    {
        try {
            $query = "INSERT INTO " . TBL_DEPARTMENT . " (`Name` , `Serial`) ";
            $query .= " VALUES (? , ?)";

            $command = $this->connection->prepare($query);
            $command->bind_param("si", $name , $serial);
            $command->execute();

            return 1;
        } catch (Exception $ex) {
            return 0;
        }
    }

    function add_property($name , $quantity , $value)
    {
        try {
            $query = "INSERT INTO " . TBL_PROPERTY . " (`Name` , `Quantity` , `Value`) ";
            $query .= " VALUES (? , ? , ?)";

            $command = $this->connection->prepare($query);
            $command->bind_param("sii", $name ,$quantity , $value);
            $command->execute();

            return 1;
        } catch (Exception $ex) {
            return 0;
        }
    }

    function add_user($username , $password)
    {
        try {

            $validate = new Validation();

            $password = $validate->encrypt_item($password);


            $query = "INSERT INTO " . TBL_USERS . " (`Username`, `Password`) ";
            $query .= " VALUES (? , ? )";

            $command = $this->connection->prepare($query);
            $command->bind_param("ss", $username , $password );
            $command->execute();

            return 1;
        } catch (Exception $ex) {
            return 0;
        }
    }
    function add_stock_barcode($barcode , $quantity , $amount , $paid , $sup_id , $sup_name)
    {
        try {

            $dbIO = new DatabaseIO();

            $name = $dbIO->get_entry(TBL_PRODUCTS , "Name" , "Barcode" , $barcode);
            $o_quantity = $dbIO->get_entry(TBL_PRODUCTS , "Quantity" , "Barcode" , $barcode);


            $quantity += $o_quantity;

            $query = "UPDATE " . TBL_PRODUCTS . " SET `Quantity` = ? WHERE Barcode = ?";
            $command = $this->connection->prepare($query);
            $command->bind_param("ds", $quantity, $barcode);
            $command->execute();


            $this->add_supplier_balance($sup_id , $name , $amount , $paid , $sup_name);

            return 1;
        } catch (Exception $ex) {
            return 0;
        }
    }


    function return_goods_barcode($barcode , $quantity , $amount , $sup_id)
    {
        $dbIO = new DatabaseIO();

        $name = $dbIO->get_entry(TBL_PRODUCTS , "Name" , "Barcode" , $barcode);
        $o_quantity = $dbIO->get_entry(TBL_PRODUCTS , "Quantity" , "Barcode" , $barcode);


        $newQuantity = $o_quantity - $quantity;


        if($newQuantity >= 0)
        {
            $query = "UPDATE " . TBL_PRODUCTS . " SET `Quantity` = ? WHERE Barcode = ?";
            $command = $this->connection->prepare($query);
            $command->bind_param("ds", $newQuantity, $barcode);
            $command->execute();

            $this->decrease_supplier_balance($sup_id , $name , $amount);

            return 1;
        }
        else
        {
            echo "<script>alert('Quantity entered is greater than Quantity in stock ! !');</script>";
            return 0;
        }
    }

    function return_goods_id($id , $quantity , $amount , $sup_id)
    {
        $dbIO = new DatabaseIO();

        $name = $dbIO->get_entry(TBL_PRODUCTS , "Name" , "ID" , $id);
        $o_quantity = $dbIO->get_entry(TBL_PRODUCTS , "Quantity" , "ID" , $id);


        $newQuantity = $o_quantity - $quantity;


        if($newQuantity >= 0)
        {
            $query = "UPDATE " . TBL_PRODUCTS . " SET `Quantity` = ? WHERE ID = ?";
            $command = $this->connection->prepare($query);
            $command->bind_param("ds", $newQuantity, $id);
            $command->execute();

            $this->decrease_supplier_balance($sup_id , $name , $amount);

            return 1;
        }
        else
        {
            echo "<script>alert('Quantity entered is greater than Quantity in stock ! !');</script>";
            return 0;
        }
    }

    function decrease_supplier_balance($sup_id , $name , $amount)
    {
        $query = "SELECT  Balance , supplierName FROM ".TBL_SUPPLIER_BAL." WHERE (supplierID = ? and Product = ?)";
        $command = $this->connection->prepare($query);
        $command->bind_param("is", $sup_id , $name);
        $command->bind_result($prevBalance , $supName);
        $command->execute();
        while($command->fetch()){}
        if(!empty($supName))
        {
            $newBal = $prevBalance - ($amount);

            $query = "UPDATE " . TBL_SUPPLIER_BAL . " SET Balance = ? WHERE (supplierID = ? and Product = ?)";
            $command = $this->connection->prepare($query);
            $command->bind_param("iis",$newBal , $sup_id , $name);
            $command->execute();
        }
        else
        {
            echo "<script>alert('Supplier with this product not present ! !');</script>";
            return 0;
        }
    }

    function add_supplier_balance($sup_id , $name , $amount , $paid , $sup_name)
    {
        $query = "SELECT Amount , Paid , Balance , supplierName FROM ".TBL_SUPPLIER_BAL." WHERE (supplierID = ? and Product = ?)";
        $command = $this->connection->prepare($query);
        $command->bind_param("is", $sup_id , $name);
        $command->bind_result($prevAmount , $prevPaid , $prevBalance , $supName);
        $command->execute();
        while($command->fetch()){}
        if(!empty($supName))
        {

            $newAmount = $prevBalance + $amount;
            $newBal = $prevBalance + ($amount - $paid);

            $query = "UPDATE " . TBL_SUPPLIER_BAL . " SET `Amount` = ? , `Paid` = ? , Balance = ? WHERE (supplierID = ? and Product = ?)";
            $command = $this->connection->prepare($query);
            $command->bind_param("iiiis", $newAmount, $paid , $newBal , $sup_id , $name);
            $command->execute();
        }
        else
        {
            $balance = $amount - $paid;
            $query = "INSERT INTO " . TBL_SUPPLIER_BAL . "(`supplierID`, `supplierName`, `Product`, `Amount`, `Paid`, `Balance`)";
            $query .= " VALUES( ? , ? , ? , ? , ? , ?)";
            $command = $this->connection->prepare($query);
            $command->bind_param("issiii", $sup_id , $sup_name , $name , $amount , $paid , $balance);
            $command->execute();
        }
    }

    function add_stock_id($id , $quantity , $amount , $paid, $sup_id , $sup_name)
    {
        try {

            $dbIO = new DatabaseIO();

            $name = $dbIO->get_entry(TBL_PRODUCTS , "Name" , "ID" , $id);
            $old_quantity = $dbIO->get_entry(TBL_PRODUCTS , "Quantity" , "ID" , $id);

            $quantity += $old_quantity;

            $query = "UPDATE " . TBL_PRODUCTS . " SET `Quantity` = ? WHERE ID = ?";
            $command = $this->connection->prepare($query);
            $command->bind_param("di", $quantity, $id);
            $command->execute();

            $this->add_supplier_balance($sup_id , $name , $amount , $paid , $sup_name);

            return 1;
        } catch (Exception $ex) {
            return 0;
        }
    }

    public function add_salary($id, $name, $salaryPaid, $current , $date , $balance)
    {
        try {
            $month = date('m');
            $year = date('Y');
            $status = 1;

            $db = new DatabaseIO();
            $prevPaid = $db->get_entry(TBL_SALARY , "Paid" , "Month = $month and Year = $year and staffID" , $id);


            if(empty($prevPaid))
            {

                $query = "INSERT INTO " . TBL_SALARY . " (staffID , staffName , Salary , Month , Year , Date , Balance , Status , Paid)";
                $query .= " VALUES (? , ? , ? , ? , ? , ? , ? , ? , ?)";

                $command = $this->connection->prepare($query);
                $command->bind_param("isiiisiii", $id, $name, $current, $month, $year, $date, $balance, $status, $salaryPaid);
                $command->execute();

                return 1;
            }
            else
            {
                $newPaid = $prevPaid + $salaryPaid;

                $newBalance = $current - $newPaid;

                $query = "UPDATE " . TBL_SALARY . " SET `Balance` = ? , `Paid` = ? ";
                $query .= " WHERE (Month = ? and Year = ? and staffID = ?)";


                $command = $this->connection->prepare($query);
                $command->bind_param("iiiii", $newBalance , $newPaid ,$month , $year , $id);
                $command->execute();

                return 1;
            }
        } catch (Exception $ex) {
            return 0;
        }
    }

}

?>