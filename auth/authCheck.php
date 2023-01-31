<?php
include_once "../database/dbconnect.php";
function authCheck($db, $schedule)
{

    $sql = " SELECT judge_schedule FROM list_judge WHERE judge_latest_session = '" . $_SESSION['Id'] . "';";
    $row = $db->query($sql);
    $result = mysqli_fetch_array($row);

    if (!in_array($schedule, explode(',', $result['judge_schedule']))) {
        return false;
        exit;
    } else {
        return true;
        exit;
    }
}
