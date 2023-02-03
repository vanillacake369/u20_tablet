<?php
include_once(__DIR__ . "/../database/dbconnect.php");
/**
 * DB 내에 현재 세션값과 최근 세션값이 다르면 View 제한
 *
 * @param [type] $db
 * @param [type] $session
 * @return void
 */
function isLatestSession($db, $session)
{

    $sql = "SELECT judge_schedule FROM list_judge WHERE judge_latest_session = '" . $session . "';";
    $row = $db->query($sql);
    $result = mysqli_fetch_array($row);

    if (!isset($result)) {
        return false;
    } else {
        return true;
    }
}
/**
 * 현재 세션값이 없으면 View 제한
 *
 * @param [type] $session
 * @return void
 */
function isSetSession($session)
{
    if (!isset($session)) {
        return false;
    } else {
        return true;
    }
}
