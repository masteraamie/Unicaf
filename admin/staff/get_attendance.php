<?php

require_once("../master_engine/validations.php");
require_once("../master_engine/database_io.php");
$validate = new Validation();

try {
    $id = $_POST['id'];
    $day = $_POST['day'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $type = $_POST['type'];
    $name = "";
    $status = "";
    $date = $year . "-" . $month . "-" . $day;

    $leaves = 0;



    if($type == "monthly")
    {
        $connection = new mysqli(HOST, USER, PASSWORD, DB_NAME);
        $query = "SELECT COUNT(ID) from " . TBL_ATTEND . " WHERE (ID = ?  and Month = ? and Year = ? and Status = 'Leave')";
        $command = $connection->prepare($query);
        $command->bind_param('iii', $id, $month, $year);
        $command->bind_result($leaves);
        $command->execute();
        $command->fetch();

        $connection = new mysqli(HOST, USER, PASSWORD, DB_NAME);
        $query = "SELECT COUNT(ID) from " . TBL_ATTEND . " WHERE (ID = ?  and Month = ? and Year = ? and Status = 'Present')";
        $command = $connection->prepare($query);
        $command->bind_param('iii', $id, $month, $year);
        $command->bind_result($present);
        $command->execute();
        $command->fetch();

        $connection = new mysqli(HOST, USER, PASSWORD, DB_NAME);
        $query = "SELECT COUNT(ID) from " . TBL_ATTEND . " WHERE (ID = ?  and Month = ? and Year = ? and Status = 'Absent')";
        $command = $connection->prepare($query);
        $command->bind_param('iii', $id, $month, $year);
        $command->bind_result($absent);
        $command->execute();
        $command->fetch();

        echo "<tr>";
        echo "<td><label class='label label-info'>No of Leaves in this Month : $leaves</label></td>";
        echo "<td><label class='label label-success'>Days Present in this Month : $present</label></td>";
        echo "<td><label class='label label-danger'>Days Absent in this Month : $absent</label></td>";
        echo "</tr>";
    }

    $connection = new mysqli(HOST, USER, PASSWORD, DB_NAME);
    if ($type == "daily") {
        $query = "SELECT Name , Status , Date from " . TBL_ATTEND . " WHERE (ID = ? and Date = ?)";
        $command = $connection->prepare($query);
        $command->bind_param('is', $id, $date);
        $command->execute();
        $command->bind_result($name, $status , $date);
    } elseif ($type == "monthly") {
        $query = "SELECT Name , Status , Date from " . TBL_ATTEND . " WHERE (ID = ?  and Month = ? and Year = ?)";
        $command = $connection->prepare($query);
        $command->bind_param('iii', $id, $month, $year);

        $command->execute();
        $command->bind_result($name, $status , $date);

    }



    while ($command->fetch()) {
        if($name != "") {
            echo "<tr>";
            echo "<td>$date</td>";
            echo "<td><label>";
            if($status == "Present")
                echo "<label class='label label-success'>".$status."</label>";
            elseif($status == "Absent")
                echo "<label  class='label label-danger'>".$status."</label>";
            elseif($status == "Leave")
                echo "<label  class='label label-default'>".$status."</label>";
            echo  '</label></td>';
            echo '<td>';
            echo '<a href="edit_attendance.php?ID='.$id.'&Date='.$date.'" class="btn btn-sm btn-primary">Edit</a>';
            echo '</td></tr>';
        }
        else
            echo "";
    }
    $connection->close();
}
catch(Exception $e)
{
    echo "Error Occurred";
}

?>