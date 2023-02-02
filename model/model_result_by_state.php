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
        $row["athlete_country"] = $row["athlete_country"];
        $row["athlete_division"] = $row["athlete_division"];
        $row["record_status"] = $row["record_status"];
        $row["record_pass"] = $row["record_pass"];
        $pass = $row["record_pass"];
        if ($pass == 'p') {
            $row["record_pass"] = "통과";
        } else if ($pass == 'l') {
            $row["record_pass"] = "탈락";
        } else if ($pass == 'd') {
            $row["record_pass"] = "실격";
        } else if ($pass == 'w') {
            $row["record_pass"] = "기권";
        } else {
            $row["record_pass"] = "시작안함";
        }
        $gender = $row["schedule_gender"];
        if ($gender == 'm') {
            $row["schedule_gender"] = "남성";
        } else if ($gender == 'f') {
            $row["schedule_gender"] = "여성";
        } else {
            $row["schedule_gender"] = "혼성";
        }
        $status = $row["record_status"];
        // official state
        if ($status == 'o') {
            $row["record_status"] = "공식 결과";
            $row["record_record"] = $row["record_official_record"];
            $row["record_result"] = $row["record_official_result"];
            $row["schedule_id"] = "";
        }
        // live state
        else if ($status == 'l') {
            $row["record_status"] = "실시간 결과";
            $row["record_record"] = $row["record_live_record"];
            $row["record_result"] = $row["record_live_result"];
            $row["schedule_id"] = $row["schedule_id"];
        }
        // not started state
        else {
            $row["record_status"] = "시작안함";
            $row["record_record"] = "";
            $row["record_result"] = "";
            $row["schedule_id"] = "";
        }
        $rows[] = $row;
    }
    return $rows;
}
