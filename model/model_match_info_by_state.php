<?php
include_once(__DIR__ . "/model_match_info.php");
include_once(__DIR__ . "/dictionary.php");
/**
 * 경기 관련 모든 정보 가져오는 함수
 *
 * @param [type] $id
 * @return void
 */
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
        $row["schedule_gender"] = translateGender($row["schedule_gender"]);
        $rows[] = $row;
    }
    return $rows;
}
