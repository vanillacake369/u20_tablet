<?php

/**
 * - model_result는 결과만을 가져옴
 * - view_result는 받아온 값만을 출력
 * - model_result_by_state에서 원하는 상태에 따라 결과값을 변경
 * 
 * "view_result에서 model_result에 직접적인 의존을 할 필요없음"
 * => SRP,DIP,OCP 한 방에 해결
 */
/**
 * 잉...다만 getResultByState가 넘겨받은 id를 getResult에 id를 연달아 넘기기에
 * 결합도가 너무 큼
 * :: 이걸 어떻게 해결할 방법이 없을까??
 */
/**
 * @uses model_result::function getResult
 * 원하는 상태에 따라 결과값을 변경하는 함수
 *
 * @param [type] $id
 * @return array
 */
function getResultByState($id)
{
    // get result
    include_once(__DIR__ . "/model_result.php");
    $result = getResult($id);
    // change value by state
    $rows = [];
    while ($row = mysqli_fetch_array($result)) {
        $row["record_order"] = $row["record_order"];
        $row["athlete_name"] = $row["athlete_name"];
        $row["schedule_gender"] = $row["schedule_gender"];
        $row["athlete_country"] = $row["athlete_country"];
        $row["athlete_division"] = $row["athlete_division"];
        $row["record_status"] = $row["record_status"];
        $status = $row["record_status"];
        // official state
        if ($status == 'o') {
            $row["record_record"] = $row["record_official_record"];
            $row["record_result"] = $row["record_official_result"];
        }
        // live state
        else if ($status == 'l') {
            $row["record_record"] = $row["record_live_record"];
            $row["record_result"] = $row["record_live_result"];
        }
        // not started state
        else {
            $row["record_record"] = "";
            $row["record_result"] = "";
        }
        $row["record_record"] = $row["record_live_record"];
        $row["record_result"] = $row["record_live_result"];
        $row["record_pass"] = $row["record_pass"];
        $row["schedule_id"] = $row["schedule_id"];
        $rows[] = $row;
    }
    return $rows;
}
