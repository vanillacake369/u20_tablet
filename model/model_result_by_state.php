<?php

include_once(__DIR__ . "/model_result.php");
include_once(__DIR__ . "/dictionary.php");
/**
 * - model_result는 결과만을 가져옴
 * - view_result는 받아온 값만을 출력
 * - model_result_by_state에서 원하는 상태에 따라 결과값을 변경
 */
/**
 * 
 * @uses model_result::function getResult
 * 원하는 상태에 따라 결과값을 변경하는 함수
 *
 * @param [type] $id
 * @return array
 */
function getResultByState($id)
{
    // get result
    $result = getResult($id);
    // change value by state
    $rows = [];
    while ($row = mysqli_fetch_array($result)) {
        $row["record_order"] = $row["record_order"];
        $row["athlete_name"] = $row["athlete_name"];
        $row["athlete_gender"] = translateGender($row["athlete_gender"]);
        $row["athlete_country"] = $row["athlete_country"];
        $row["athlete_division"] = $row["athlete_division"];
        $row["record_record"] = changeRecordByStatus($row["record_status"], $row["record_live_record"], $row["record_official_record"]);
        $row["record_result"] = changeResultByStatus($row["record_status"], $row["record_live_result"], $row["record_official_result"]);
        $row["record_pass"] = translatePass($row["record_pass"]);
        $row["record_id"] = changeIdByStatus($row["record_status"], $row["record_id"]);
        $row["record_status"] = translateStatus($row["record_status"]);
        $rows[] = $row;
    }
    return $rows;
}
