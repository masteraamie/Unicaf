<?php
include_once 'connection.php';
include_once 'validations.php';

class AdminLogin
{
    function check_login($username , $password)
    {
        $validate = new Validation();

        $password = $validate->encrypt_item($password);
        $connection = new mysqli(HOST , USER , PASSWORD , DB_NAME);

        $query = "SELECT Username FROM ".TBL_ADMIN." WHERE Username = ? AND Password = ?";

        $command = $connection->prepare($query);
        $command->bind_param("ss" , $username , $password);
        $command->execute();
        $command->bind_result($id);
        $command->fetch();
        $connection->close();
        if($id)
        {
            return "ADMIN";
        }
        else
        {
            $connection = new mysqli(HOST , USER , PASSWORD , DB_NAME);

            $query = "SELECT Username FROM ".TBL_USERS." WHERE Username = ? AND Password = ?";

            $command = $connection->prepare($query);
            $command->bind_param("ss" , $username , $password);
            $command->execute();
            $command->bind_result($name);
            $command->fetch();
            $connection->close();
            if(!empty($name))
            {
                return "USER";
            }
            return false;
        }
    }
}

?>