<?php
include_once(__DIR__ .  "/database/dbconnect.php");

global $db;

/** @Potatoeunbi
 * 로그 남기는 함수
 *
 * @param [type] $db
 * @param [type] $id
 * @param [type] $activity
 * @param [type] $sub_activity
 * @return void
 */
function logInsert($db, $id, $activity, $sub_activity)
{

    $currentDate = date('Y-m-d H:i:s');
    // SQL INJECTION 방지(지훈 작성)
    $id = mysqli_real_escape_string($db, $id);
    $adminsql = " SELECT * FROM list_admin WHERE admin_account = '" . $id . "';";
    $adminrow = $db->query($adminsql);

    // $judgesql = " SELECT * FROM list_judge WHERE judge_account = '".$id."';";
    // $judgerow = $db->query($judgesql);

    if (($admindata = mysqli_fetch_array($adminrow))) {
        $division = "a";
        $sql = "INSERT into list_log (log_account, log_name, log_ip, log_division, log_activity,log_sub_activity,log_datetime) values (?,?,?,?,?,?,?);";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("sssssss", $admindata['admin_account'], $admindata['admin_name'], $admindata['admin_latest_ip'], $division, $activity, $sub_activity, $currentDate);
        $stmt->execute();
    }
    // else if($judgedata = mysqli_fetch_array($judgerow)){

    //     $division="j";
    //     $sql = "INSERT into list_log (log_account, log_name, log_ip, log_division,log_activity, log_sub_activity, log_datetime) values (?,?,?,?,?,?,?);";
    //     $stmt=$db->prepare($sql);
    //     $stmt->bind_param("sssssss",$judgedata['admin_account'], $judgedata['admin_name'],$judgedata['judge_latest_ip'],$division,$activity,$sub_activity, $currentDate);
    //     $stmt->execute();

    // }

}
