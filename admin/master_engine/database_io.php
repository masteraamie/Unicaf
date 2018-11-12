<?php
require_once 'connection.php';
class DatabaseIO
{
    public $connection;
    function __construct()
    {
        $this->connection = new mysqli(HOST , USER , PASSWORD , DB_NAME);
    }

    function get_last_id($table)
    {
        $countStatement = $this->connection->prepare("SELECT ID FROM ".$table." order by ID DESC limit 1");
        $countStatement->execute();
        $countStatement->store_result();
        $countStatement->bind_result($id);

        while ($countStatement->fetch()) {
        }

        $this->connection->close();
        return $id;
    }

    function get_count($table)
    {
        $countStatement = $this->connection->prepare("SELECT COUNT(ID) FROM ".$table);
        $countStatement->execute();
        $countStatement->store_result();
        $countStatement->bind_result($count);
        while ($countStatement->fetch()) {
        }
        $this->connection->close();
        return $count;
    }

    function delete_item($id , $table)
    {
        try {

            if($table == TBL_STAFF) {
                $query = "SELECT Image FROM " . $table . " WHERE ID = ?";
                $command = $this->connection->prepare($query);
                $command->bind_param("i", $id);
                $command->bind_result($image);
                $command->execute();
                while ($command->fetch()) {
                }
                if ($image != null)
                    unlink($image);
            }


            $query = "DELETE FROM " . $table . " WHERE ID = ?";

            $command = $this->connection->prepare($query);
            $command->bind_param("i", $id);
            if ($command->execute())
                return 1;
            else
                return 0;
        }
        catch(Exception $ex)
        {
            return 0;
        }
    }

    function get_entries($table , $column)
    {
        try {

            $rows = array();

            $sql = "SELECT ".$column." FROM ".$table;
            $command = $this->connection->prepare($sql);
            $command->bind_result($row);
            $command->execute();
            while ($command->fetch()) {
                $rows[] = $row;
            }

            return $rows;

        }
        catch(Exception $ex)
        {
            return 0;
        }
    }

    function get_entries_where($table , $column , $check , $value)
    {
        try {

            $rows = array();

            $sql = "SELECT ".$column." FROM ".$table." WHERE ".$check." = ".$value;
            $command = $this->connection->prepare($sql);
            $command->bind_result($row);
            $command->execute();
            while ($command->fetch()) {
                $rows[] = $row;
            }

            return $rows;

        }
        catch(Exception $ex)
        {
            return 0;
        }
    }

    function get_entries_with_id($table , $column)
    {
        try {

            $rows = array();

            $sql = "SELECT ID , ".$column." FROM ".$table;
            $command = $this->connection->prepare($sql);
            $command->bind_result($id , $row);
            $command->execute();
            while ($command->fetch()) {
                $rows[$id] = $row;
            }

            return $rows;

        }
        catch(Exception $ex)
        {
            return 0;
        }
    }

    function get_entry($table , $column , $check , $value)
    {
        try {


            $sql = "SELECT ".$column." FROM ".$table." WHERE ".$check." = ?";
            $command = $this->connection->prepare($sql);
            $command->bind_param("s", $value);
            $command->bind_result($row);
            $command->execute();
            while ($command->fetch()) {
            }
            return $row;

        }
        catch(Exception $ex)
        {
            return 0;
        }
    }

    function  get_alerts($table , $column , $check)
    {
        try {


            $sql = "SELECT ".$column." FROM ".$table." WHERE ".$check." <= Alert";
            $command = $this->connection->prepare($sql);
            $command->bind_result($row);
            $command->execute();
            while ($command->fetch()) {
            }

            return $row;

        }
        catch(Exception $ex)
        {
            return 0;
        }
    }

    function  get_entries_less($table , $column , $check , $value)
    {
        try {

            $rows = array();

            $sql = "SELECT ".$column." FROM ".$table." WHERE ".$check." <= ".$value." LIMIT 3";
            $command = $this->connection->prepare($sql);
            $command->bind_result($row);
            $command->execute();
            while ($command->fetch()) {
                $rows[] = $row;
            }
            return $rows;

        }
        catch(Exception $ex)
        {
            return 0;
        }
    }

}

?>