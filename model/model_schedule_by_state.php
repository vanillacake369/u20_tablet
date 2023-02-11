<?php
include_once(__DIR__ . "/model_schedule.php");
// 값 변환 함수
include_once(__DIR__ . "/filter.php");
// DB에 저장된 코드(key)=>값(value)
include_once(__DIR__ . "/dictionary.php");
/**
 * @uses model_schedule::function getSchedule
 * 원하는 상태에 따라 결과값을 변경하는 함수
 *
 * @param [type] $id
 * @return array
 */
function getScheduleByState($id)
{
    // get schedule
    $schedule = getSchedule($id);
    // change value by state
    $rows = [];
    while ($row = mysqli_fetch_array($schedule)) {
        $row["schedule_match"] = strtoupper(trim($row["schedule_sports"]));
        $row["schedule_gender"] = translateGender(trim($row["schedule_gender"]));
        $row["schedule_sports"] = trim($row["schedule_sports"]);
        // 종합 경기는 라운드 ==> 경기한글명 =(치환)=> 경기코드
        if ($row["schedule_sports"] == "decathlon" || $row["schedule_sports"] == "heptathlon") {
            global $sports_code_dic;
            $row["schedule_sports"] = array_search($row["schedule_round"], $sports_code_dic);
        }
        $row["schedule_round"] = ($row["schedule_round"]);
        $row["schedule_round"] = strtoupper(translateRound(trim($row["schedule_round"])));
        $row["schedule_group"] = trim($row["schedule_group"]);
        $row["schedule_location"] = translateLocation(trim($row["schedule_location"]));
        $date_time = explode(" ", $row["schedule_start"]);
        $row["schedule_date"] = trim($date_time[0]);
        $row["schedule_time"] = trim($date_time[1]);
        $row["schedule_start"] = trim($row["schedule_start"]);
        $row["schedule_result"] = translateStatus(trim($row["schedule_result"]));
        $row["schedule_id"] = trim($row["schedule_id"]);
        $rows[] = $row;
    }
    return $rows;
}
