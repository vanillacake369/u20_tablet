<?php

/**
 * 경기 관련 모든 정보 가져오는 함수
 *
 * @param [type] $id
 * @return void
 */
// DB
include_once(__DIR__ . "/../database/dbconnect.php");
function getMatchInfo($id)
{
    global $db;
    // $id : 스케줄 id(<= view_result의 GET[id])
    $sql = "SELECT *
        FROM list_judge AS j
		LEFT JOIN list_schedule AS sc
		ON j.judge_attendance REGEXP CONCAT('\\\\b',sc.schedule_sports,'\\\\b')
		LEFT JOIN list_sports AS sp
		ON sc.schedule_sports = sp.sports_code
		WHERE sc.schedule_id = $id";
    $result = $db->query($sql);
    return $result;
}
