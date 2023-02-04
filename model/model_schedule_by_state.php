<?php
include_once(__DIR__ . "/model_schedule.php");
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
        $row["schedule_name"] = $row["schedule_name"];
        $row["schedule_gender"] = translateGender($row["schedule_gender"]);
        $row["schedule_round"] = $row["schedule_round"];
        $row["schedule_group"] = $row["schedule_group"];
        $row["schedule_division"] = translateScheduleDivision($row["schedule_division"]);
        $row["schedule_location"] = $row["schedule_location"];
        $row["schedule_date"] = $row["schedule_date"];
        $row["schedule_start"] = $row["schedule_start"];
        $row["schedule_result"] = translateStatus($row["schedule_result"]);
        $row["schedule_id"] = $row["schedule_id"];
        $rows[] = $row;
    }
    return $rows;
}
