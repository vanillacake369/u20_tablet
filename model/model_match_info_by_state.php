<?php

/**
 * 경기 관련 모든 정보 가져오는 함수
 *
 * @param [type] $id
 * @return void
 */
// DB
// get result
include_once(__DIR__ . "/model_match_info.php");
function getMatchInfoByState($id)
{
    $matchInfo = getMatchInfo($id);
    global $db;
    // $id : 스케줄 id(<= view_result의 GET[id])
    $rows = [];
    while ($row = mysqli_fetch_array($matchInfo)) {
        $row["sports_category"] = $row["sports_category"];
        $row["sports_name_kr"] = $row["sports_name_kr"];
        $row["schedule_date"] = $row["schedule_date"];
        $row["schedule_start"] = $row["schedule_start"];
        $row["schedule_round"] = $row["schedule_round"];
        $row["judge_name"] = $row["judge_name"];
        $row["judge_duty"] = $row["judge_duty"];
        $row["schedule_gender"] = $row["schedule_gender"];
        $gender = $row["schedule_gender"];
        if ($gender == 'm') {
            $row["schedule_gender"] = "남성";
        } else if ($gender == 'f') {
            $row["schedule_gender"] = "여성";
        } else {
            $row["schedule_gender"] = "혼성";
        }
        $rows[] = $row;
    }
    return $rows;
}
