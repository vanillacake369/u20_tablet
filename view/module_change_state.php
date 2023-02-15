<?php
// DB 연결
include_once(__DIR__ . "/../database/dbconnect.php");
include_once(__DIR__ . "/../model/filter.php");
//@vanillacake369
/**
 * select box의 이전 선택값 유지하기 위한 함수
 *
 * @param [type] $value : get/post로 넘어온 값
 * @return array|NULL
 */
function maintainSelected($value)
{
    $isSelected = [];
    if (isset($value) && ($value != "non")) {;
        $isSelected[$value] = ' selected';
        return $isSelected;
    } else {
        return NULL;
    }
}

/**
 * 선수이름과 이벤트명을 통해 모든 신기록을 가져오는 함수
 * @depends translateNewRecord(:: /model/filter.php)
 * 
 * @param [type] $record_name
 * @param [type] $schedule_sports
 * @return void
 */
function getNewRecord($athlete_name, $schedule_sports)
{
    global $db;
    $all_new_records_str = "";

    $sql =
        "SELECT * 
        FROM list_worldrecord 
        WHERE worldrecord_athlete_name = '" . trim($athlete_name) .
        "' AND worldrecord_sports= '" . trim($schedule_sports) . "';";
    $query_result = $db->query($sql);
    $query_result_cnt = $query_result->num_rows;

    $new_records = array();
    $cnt = 1;
    while ($new_records = mysqli_fetch_array($query_result)) {
        $new_record = ($new_records["worldrecord_athletics"]);
        $new_record = translateNewRecord($new_records["worldrecord_athletics"]);
        if ($cnt == $query_result_cnt) {
            $all_new_records_str = $all_new_records_str . $new_record;
        } else {
            $all_new_records_str = $all_new_records_str . $new_record . " / ";
        }
    }

    return $all_new_records_str;
}
