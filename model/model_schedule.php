<?php
// DB
include_once(__DIR__ . "/../database/dbconnect.php");
// // 페이징
// require_once(__DIR__ . "pagination.php");
// // 외부 공격 방지 기능
// require_once(__DIR__ . "input_filtering.php");
// // 로그 기능
// require_once(__DIR__ . "log.php");
function getSchedule($id)
{
    global $db;
    $sql = "SELECT *
        FROM list_schedule
        WHERE schedule_sports IN (
            SELECT
            SUBSTRING_INDEX(SUBSTRING_INDEX(judge_attendance, ',', n.digit+1), ',', -1) 
            FROM
            list_judge
            INNER JOIN
            (SELECT 0 digit UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3) n
            ON LENGTH(REPLACE(judge_attendance, ',' , '')) <= LENGTH(judge_attendance)-n.digit
            WHERE 
                judge_account =\"" . $id . "\"" .  "ORDER BY judge_account, n.digit)";
    $result = $db->query($sql);
    return $result;
}
