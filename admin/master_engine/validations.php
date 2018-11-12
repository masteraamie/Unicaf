<?php
require_once 'connection.php';
require_once 'database_io.php';
class Validation
{

    function validate_attendence($id , $name , $status , $date)
    {
        $errors = array();

        if($this->validate_empty($id))
            $errors['id'] = "ID Not Available";

        if($this->validate_empty($name))
            $errors['name'] = "Name is Required";

        if($this->validate_empty($status))
            $errors['status'] = "Status is Required";

        try {
            $connection = new mysqli(HOST , USER , PASSWORD , DB_NAME);
            $name = "";
            $query = "SELECT Name FROM ".TBL_ATTEND." WHERE ID = ? and Date = ?";
            $command = $connection->prepare($query);
            $command->bind_param("is", $id , $date);
            $command->bind_result($name);
            $command->execute();
            while ($command->fetch()) {
            }

            if(!empty($name))
               $errors['attend'] = "Attendence Already Done For Today";

        }
        catch(Exception $ex)
        {
            $errors['attend'] = "Database Error";
        }

        if(!($status == "Present" || $status == "Absent" || $status == "Leave"))
            $errors['status'] = "Invalid Status";

        return $errors;
    }
    function validate_salary($id , $name , $salary)
    {
        $errors = array();

        if($this->validate_empty($id))
            $errors['id'] = "ID Not Available";

        if($this->validate_empty($name))
            $errors['name'] = "Name is Required";

        if($this->validate_empty($salary))
            $errors['status'] = "Status is Required";

        return $errors;
    }
    function validate_expenditure($name , $quantity , $amount , $paid)
    {
        $errors = array();
        if($this->validate_empty($name))
            $errors['name'] = "Name is Required";
        if($this->validate_empty($quantity))
            $errors['quantity'] = "Quantity is Required";
        if($this->validate_empty($amount))
            $errors['amount'] = "Amount is Required";
        if($this->validate_empty($paid))
            $errors['paid'] = "Paid is Required";

        if($this->validate_length($name , 50))
            $errors['name'] = "Name Cannot Exceed 50 Characters";

        if($this->validate_name($name))
            $errors['name'] = "Name Can Only Contain Alphabets";

        if($this->validate_numeric($quantity))
            $errors['quantity'] = "Quantity Must Be a Number";
        if($this->validate_numeric($amount))
            $errors['amount'] = "Amount Must Be a Number";
        if($this->validate_numeric($paid))
            $errors['paid'] = "Paid Must Be a Number";

        return $errors;

    }
    function validate_item($name , $cost , $price , $serial)
    {
        $errors = array();
        if($this->validate_empty($name))
            $errors['name'] = "Name is Required";
        else
        {
            try {

                $dbIO = new DatabaseIO();

                $name = $dbIO->get_entry(TBL_ITEMS , "Name" , "Name" , $name);
                if (!empty($name))
                    $errors['name'] = "Food Item with this Name Already Present in Database ";

            } catch (Exception $ex) {
                $errors['name'] = "Database Error";
            }
        }

        if($this->validate_empty($cost))
            $errors['cost'] = "Cost is Required";
        if($this->validate_empty($price))
            $errors['price'] = "Price is Required";

        if($this->validate_empty($serial))
            $errors['serial'] = "Serial is Required";
        else
        {
            try {

                $dbIO = new DatabaseIO();

                $name = $dbIO->get_entry(TBL_ITEMS , "Name" , "Serial" , $serial);
                if (!empty($name))
                    $errors['serial'] = "Food Item with this Serial Already Present in Database ";

            } catch (Exception $ex) {
                $errors['serial'] = "Database Error";
            }
        }

        if($this->validate_length($name , 50))
            $errors['name'] = "Name Cannot Exceed 50 Characters";

        if($this->validate_name($name))
            $errors['name'] = "Name Can Only Contain Alphabets";

        if($this->validate_numeric($cost))
            $errors['cost'] = "Cost Must Be a Number";
        if($this->validate_numeric($price))
            $errors['price'] = "Price Must Be a Number";
        if($this->validate_numeric($serial))
            $errors['serial'] = "Serial Must Be a Number";

        return $errors;

    }
    function validate_property($name , $quantity , $value)
    {
        $errors = array();
        if ($this->validate_empty($name))
            $errors['name'] = "Name is Required";


        if ($this->validate_empty($quantity))
            $errors['cost'] = "Quantity is Required";


        if ($this->validate_empty($value))
            $errors['serial'] = "Value is Required";

        return $errors;
    }

    function validate_edit_item($name , $cost , $price , $serial)
    {
        $errors = array();
        if($this->validate_empty($name))
            $errors['name'] = "Name is Required";


        if($this->validate_empty($cost))
            $errors['cost'] = "Cost is Required";
        if($this->validate_empty($price))
            $errors['price'] = "Price is Required";

        if($this->validate_empty($serial))
            $errors['serial'] = "Serial is Required";

        if($this->validate_length($name , 50))
            $errors['name'] = "Name Cannot Exceed 50 Characters";

        if($this->validate_name($name))
            $errors['name'] = "Name Can Only Contain Alphabets";

        if($this->validate_numeric($cost))
            $errors['cost'] = "Cost Must Be a Number";
        if($this->validate_numeric($price))
            $errors['price'] = "Price Must Be a Number";
        if($this->validate_numeric($serial))
            $errors['serial'] = "Serial Must Be a Number";

        return $errors;

    }

    function validate_user($username , $password , $confirm)
    {
        $errors = array();
        if($this->validate_empty($username))
            $errors['name'] = "Username is Required";
        if($this->validate_empty($password))
            $errors['password'] = "Password is Required";
        if($this->validate_empty($confirm))
            $errors['confirm'] = "Confirm Password is Required";


        if($this->validate_length($username , 50))
            $errors['name'] = "Username Cannot Exceed 50 Characters";

        if(!$this->validate_empty($password) && !$this->validate_empty($confirm))
        {
            if($password != $confirm)
                $errors['password'] = "Passwords Do Not Match";
        }


        return $errors;

    }


    function validate_admin($name , $username ,  $oldPassword  , $newPassword , $confirm)
    {
        $errors = array();
        if($this->validate_empty($name))
            $errors['name'] = "Name is Required";
        if($this->validate_empty($username))
            $errors['username'] = "Username is Required";



        if($this->validate_length($username , 50))
            $errors['name'] = "Username Cannot Exceed 50 Characters";

        if(!$this->validate_empty($newPassword) && !$this->validate_empty($confirm))
        {
            if($newPassword != $confirm)
                $errors['password'] = "Passwords Do Not Match";
            else {
                $oldPassword = $this->encrypt_item($oldPassword);
                $db = new DatabaseIO();
                $password = $db->get_entry(TBL_ADMIN , 'Password' , 'Password' , $oldPassword);
                if($password != $oldPassword)
                {
                    $errors['password'] = "Invalid Credentials";
                }
            }
        }


        return $errors;

    }

    function validate_staff($name , $parentage , $address , $contact , $designation , $salary , $image)
    {
        $errors = array();

        if($this->validate_empty($name))
            $errors['name'] = "Name is Required";
        if($this->validate_empty($parentage))
            $errors['parentage'] = "Parentage is Required";
        if($this->validate_empty($address))
            $errors['address'] = "Address is Required";
        if($this->validate_empty($contact))
            $errors['contact'] = "Contact is Required";
        if($this->validate_empty($designation))
            $errors['designation'] = "Designation is Required";
        if($this->validate_empty($salary))
            $errors['salary'] = "Salary is Required";
        if($this->validate_empty($image))
            $errors['image'] = "Image is Required";


        if($this->validate_length($name , 50))
            $errors['name'] = "Name Cannot Exceed 50 Characters";

        if($this->validate_length($parentage , 50))
            $errors['parentage'] = "Name Cannot Exceed 50 Characters";

        if(!preg_match("/^[a-zA-Z ]*$/" , $name) && !$this->validate_empty($name))
            $errors['name'] = "Name Can Only Contain Alphabets";


        if($this->validate_name($parentage))
            $errors['parentage'] = "Parentage Can Only Contain Alphabets";

        if($this->validate_numeric($contact))
            $errors['contact'] = "Contact Can Only Contain Numbers";

        if($this->validate_numeric($salary))
            $errors['salary'] = "Salary Can Only Contain Numbers";


        return $errors;
    }
    public function validate_edit_product($name, $type, $barcode, $unit, $alert)
    {
        $errors = array();

        if($this->validate_empty($name))
            $errors['name'] = "Name is Required";

        if($this->validate_empty($type))
            $errors['type'] = "Type is Required";
        if($this->validate_empty($barcode))
            $errors['barcode'] = "Barcode is Required For Packaged Items";
        if($this->validate_empty($unit))
            $errors['unit'] = "Unit is Required";
        if($this->validate_empty($alert))
            $errors['alert'] = "Alert is Required";

        if($this->validate_length($name , 50))
            $errors['name'] = "Name Cannot Exceed 50 Characters";

        if($this->validate_name($name))
            $errors['name'] = "Name Can Only Contain Alphabets";

        if(!($type == "Packaged" || $type == "Non Packaged"))
            $errors['type'] = "Type is Invalid";

        if($this->validate_numeric($alert))
            $errors['alert'] = "Alert Can Only Contain Numbers";

        return $errors;
    }
    function validate_product($name , $type , $barcode , $unit , $alert)
    {
        $errors = array();

        if($this->validate_empty($name))
            $errors['name'] = "Name is Required";
        else
        {
            try {

                $dbIO = new DatabaseIO();

                $name = $dbIO->get_entry(TBL_PRODUCTS , "Name" , "Name" , $name);
                if (!empty($name))
                    $errors['name'] = "Product with this Name Already Present in Database ";

            } catch (Exception $ex) {
                $errors['name'] = "Database Error";
            }
        }
        if($this->validate_empty($type))
            $errors['type'] = "Type is Required";

        if($this->validate_empty($unit))
            $errors['unit'] = "Unit is Required";

        if(!$this->validate_empty($barcode)) {
            try {
                $dbIO = new DatabaseIO();
                $name = $dbIO->get_entry(TBL_PRODUCTS , "Name" , "Barcode" , $barcode);
                if (!empty($name))
                    $errors['barcode'] = "Product with this Barcode Already Present in Database";
            } catch (Exception $ex) {
                $errors['barcode'] = "Database Error";
            }

        }
        if($this->validate_length($name , 50))
            $errors['name'] = "Name Cannot Exceed 50 Characters";

        if($this->validate_name($name))
            $errors['name'] = "Name Can Only Contain Alphabets";

        if($this->validate_numeric($alert))
            $errors['alert'] = "Alert Can Only Contain Numbers";


        return $errors;
    }

    function validate_barcode($barcode , $quantity , $amount , $paid , $sup_id , $sup_name)
    {
        $errors = array();

        if ($this->validate_empty($quantity))
            $errors['quantity'] = "Quantity is Required";

        if ($this->validate_numeric($quantity))
            $errors['quantity'] = "Quantity Can Only Contain Numbers";

        if ($this->validate_empty($amount))
            $errors['amount'] = "Amount is Required";

        if ($this->validate_empty($paid))
            $errors['paid'] = "Paid is Required";

        if ($this->validate_empty($sup_id))
            $errors['id'] = "Supplier ID not found";
        else {
            try {

                $dbIO = new DatabaseIO();

                $name = $dbIO->get_entry(TBL_SUPPLIER , "Name" , "ID" , $sup_id);
                if (empty($name))
                    $errors['name'] = "Supplier with this Name Not Present in Database ";

            } catch (Exception $ex) {
                $errors['name'] = "Database Error";
            }
        }


        if ($this->validate_empty($sup_name))
            $errors['sup_name'] = "Please select a supplier";

        if ($this->validate_empty($paid))
            $errors['paid'] = "Paid is Required";
        if ($this->validate_numeric($amount))
            $errors['amount'] = "Amount Can Only Contain Numbers";

        if ($this->validate_numeric($paid))
            $errors['paid'] = "Paid Can Only Contain Numbers";

        if ($barcode == "" || $barcode == "NA" || $barcode == "na" || $barcode == "Na" || $barcode == "nA")
            $errors['barcode'] = "Barcode is Required";
        else {
            try {
                $dbIO = new DatabaseIO();
                $name = $dbIO->get_entry(TBL_PRODUCTS , "Name" , "Barcode" , $barcode);
                if (empty($name))
                    $errors['barcode'] = "Product with this Barcode Not Present in Database";

            } catch (Exception $ex) {
                $errors['barcode'] = "Database Error";
            }
        }

        return $errors;
    }


    function validate_stock($id, $quantity, $amount, $paid, $sup_id, $sup_name)
    {
        $errors = array();

        if($this->validate_empty($id))
            $errors['id'] = "No ID Available";

        if($this->validate_empty($quantity))
            $errors['quantity'] = "Quantity is Required";

        if ($this->validate_empty($amount))
            $errors['amount'] = "Amount is Required";

        if ($this->validate_empty($paid))
            $errors['paid'] = "Paid is Required";

        if ($this->validate_empty($sup_id))
            $errors['id'] = "Supplier ID not found";
        else {
            try {


                $dbIO = new DatabaseIO();

                $name = $dbIO->get_entry(TBL_SUPPLIER , "Name" , "ID" , $sup_id);
                if (empty($name))
                    $errors['name'] = "Supplier with this Name Not Present in Database ";

            } catch (Exception $ex) {
                $errors['id'] = "Database Error";
            }
        }


        if ($this->validate_empty($sup_name))
            $errors['sup_name'] = "Please select a supplier";

        if ($this->validate_empty($paid))
            $errors['paid'] = "Paid is Required";
        if ($this->validate_numeric($amount))
            $errors['amount'] = "Amount Can Only Contain Numbers";

        if ($this->validate_numeric($paid))
            $errors['paid'] = "Paid Can Only Contain Numbers";


        if($this->validate_numeric($quantity))
            $errors['quantity'] = "Quantity Can Only Contain Numbers";

        return $errors;
    }


    function validate_release_barcode($barcode , $quantity)
    {
        $errors = array();

        if ($this->validate_empty($quantity))
            $errors['quantity'] = "Quantity is Required";

        if ($this->validate_numeric($quantity))
            $errors['quantity'] = "Quantity Can Only Contain Numbers";

        if ($barcode == "" || $barcode == "NA" || $barcode == "na" || $barcode == "Na" || $barcode == "nA")
            $errors['barcode'] = "Barcode is Required";
        else {
            try {
                $dbIO = new DatabaseIO();
                $name = $dbIO->get_entry(TBL_PRODUCTS , "Name" , "Barcode" , $barcode);
                if (empty($name))
                    $errors['barcode'] = "Product with this Barcode Not Present in Database";

            } catch (Exception $ex) {
                $errors['barcode'] = "Database Error";
            }
        }

        return $errors;

    }

    function validate_release_stock($id  , $quantity)
    {
        $errors = array();

        if($this->validate_empty($id))
            $errors['id'] = "No ID Available";

        if($this->validate_empty($quantity))
            $errors['quantity'] = "Quantity is Required";

        if ($this->validate_numeric($quantity))
            $errors['quantity'] = "Quantity Can Only Contain Numbers";

        return $errors;
    }

    function validate_numeric($number)
    {
        if(!is_numeric($number) && !$this->validate_empty($number))
            return true;

        return false;
    }

    function validate_name($name)
    {
        if(!preg_match("/^[a-zA-Z ]*$/" , $name) && !$this->validate_empty($name))
            return true;

        return false;
    }

       function validate_length($input , $length = 50)
    {
        return !(strlen($input) <= $length);
    }

    function validate_empty($input)
    {
        $input = trim($input);
        return  !(!isset($input) || $input !== "");
    }

    //this function displays errors to the user
    function displayErrors($errors)
    {
        $output = "";
        if (!empty($errors)) {
            foreach ($errors as $error)
                $output .= "<li><span class='fa fa-warning'></span> $error</li>";
        }
        return $output;
    }

    function imageUpload($image_destination)
    {
        if (move_uploaded_file($_FILES["img"]["tmp_name"], $image_destination)) {
            return true;
        }
        return false;
    }

    function makeDirectories($directories)
    {
        if (!is_dir($directories))
            mkdir($directories , 0777 , true);
    }
    function imageValidate($file)
    {
        $image = basename($file['name']);
        $size = $file['size'];
        $imageType = pathinfo($image, PATHINFO_EXTENSION);

        $uploadStatus = 1;
        //Checking Image
        try {
            //upload error check
            if(!is_array($file) || empty($file) || !$file)
            {
                $uploadStatus = 0;
                echo "<script>alert('No file to Upload');</script>";
            }
            //checking php errors
            if($file['error'] != 0)
            {
                $uploadStatus = 0;
            }

            //checking file size
            if ($size > 2000000) {
                echo "<script>alert('File too large');</script>";
                $uploadStatus = 0;
            }
            //checking image format
            if ($imageType != "jpg" && $imageType != "jpeg" && $imageType != "png" && $imageType != "gif"
                && $imageType != "JPG" && $imageType != "JPEG" && $imageType != "PNG" && $imageType != "GIF"
            ) {
                echo "<script>alert('File format invalid ( use .PNG / .JPG / .GIF )');</script>";
                $uploadStatus = 0;
            }

        } catch (Exception $e) {
            $uploadStatus = 0;
            echo "<script>alert('Error  Uploading Image');</script>";
        }
        return $uploadStatus;
    }


    function resizeImage($image, $h = 250, $w = 200)
    {

        try {
            $info = getimagesize($image);
            $mime = $info['mime'];

            switch ($mime) {
                case 'image/jpeg':
                    $image_create_func = 'imagecreatefromjpeg';
                    $image_save_func = 'imagejpeg';

                    break;

                case 'image/jpg':
                    $image_create_func = 'imagecreatefromjpg';
                    $image_save_func = 'imagejpg';

                    break;

                case 'image/png':
                    $image_create_func = 'imagecreatefrompng';
                    $image_save_func = 'imagepng';

                    break;

                case 'image/gif':
                    $image_create_func = 'imagecreatefromgif';
                    $image_save_func = 'imagegif';

                    break;

                default:
                    throw Exception('Unknown Image Type');
            }

            $img = $image_create_func($image);
            list($width, $height) = getimagesize($image);

            $tmp = imagecreatetruecolor($w, $h);
            imagecopyresampled($tmp, $img, 0, 0, 0, 0, $w, $h, $width, $height);
            $image_save_func($tmp, "$image");
        } catch (Exception $ex) {
            echo "<script>alert('Error Resizing Image');</script>";
        }
    }

    function populate_album($dirs)
    {
        if (is_dir($dirs)) {
            $albums = array();
            $folders = scandir($dirs, 1);

            foreach ($folders as $name) {
                if ($name != "." && $name != "..")
                    $albums[] = $name;
            }

            return $albums;
        }
        return null;
    }
    function encrypt_item($value)
    {
        $value = md5(sha1(md5(sha1($value))));
        return $value;
    }

    public function validate_bill($id)
    {
        $errors = array();
        try {
            $dbIO = new DatabaseIO();
            $name = $dbIO->get_entry(TBL_BILLING , "ID" , "ID" , $id);
            if (empty($name))
                $errors['id'] = "Bill with this ID Not Present in Database";

        } catch (Exception $ex) {
            $errors['id'] = "Database Error";
        }

        return $errors;
    }


}

?>