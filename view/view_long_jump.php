<?php
// DB 연결
include(__DIR__ . "/../database/dbconnect.php");
// STATUS(공식/실시간)에 따른 값 변환 <= 경기기록 가져오기 <= DB
include_once(__DIR__ . "/../model/model_result_by_state.php");
// STATUS(공식/실시간)에 따른 값 변환 <= 경기관련내용 가져오기 <= DB
include_once(__DIR__ . "/../model/model_match_info_by_state.php");
// 값 변환 (PASS <= p,세계신기록 <= y)
include_once(__DIR__ . "/module_change_state.php");

// 값 가져오기
$sports_category = trim($_GET["sports_category"]);
$s_id = trim($_GET["schedule_id"]);
$result_array = getResultByState($s_id);
$match_info_array = getMatchInfoByState($s_id);
// 공식결과이면 입력 제한
$is_not_official_status = (trim($match_info_array[0]["schedule_result"]) != "o");

// 경기 정보 가져오기
$judge_id = trim($_SESSION['Id']);
$sql = "SELECT DISTINCT schedule_name,schedule_round,schedule_status,record_wind,schedule_sports FROM list_record  INNER JOIN list_schedule ON schedule_id= record_schedule_id AND schedule_id = '$s_id'";
$result = $db->query($sql);
$rows = mysqli_fetch_assoc($result);
// 심판 정보 가져오기
$judgesql = "SELECT DISTINCT judge_name from list_judge WHERE judge_account = '" . $judge_id . "'";
$judgeresult = $db->query($judgesql);
$judgerow = mysqli_fetch_array($judgeresult);
?>

<div class="table-wrap">
    <table>
        <colgroup>
            <col class="col_view_lane">
            <col class="col_view_name" style="width: 10%;">
            <col class="col_view_result_th">
            <col class="col_view_result_th">
            <col class="col_view_result_th">
            <col class="col_view_result_th">
            <col class="col_view_result_th">
            <col class="col_view_result_th">
            <col class="col_view_pass">
            <col class="col_view_rank">
            <col class="col_view_remark">
        </colgroup>
        <thead>
            <!-- 윗 부분 : 레인,이름,차수별기록,통과,등수 -->
            <tr id="col1">
                <th rowspan="2">ORDER</th>
                <th rowspan="2">NAME</th>
                <th>1st</th>
                <th>2nd</th>
                <th>3rd</th>
                <th>4th</th>
                <th>5th</th>
                <th>6th</th>
                <th rowspan="2">FINAL</th>
                <th rowspan="2">RANK</th>
                <th>REMARK</th>
            </tr>
            <!-- 아랫부분 :: 높이(기록),비고,신기록 -->
            <tr id="col2">
                <th colspan="7">WIND</th>
                <th>NEW RECORD</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($rows)) {
                $i = 1;
                $count = 0; //신기록시 셀렉트 박스 찾는 용도
                $trial = 0;
                $order = "record_order";
                $obj = "record_id,record_live_result,record_memo,record_live_record,record_wind,";
                if ($rows["schedule_status"] === "y") {
                    $order = "record_new,record_live_result";
                    $check = 'record_live_result>0';
                } elseif ($_POST["check"] ?? null === "5") {
                    $trial = 6;
                    $check = 'record_trial =' . $trial . '';
                } elseif ($_POST["check"] ?? null === "3") {
                    $trial = 4;
                    $check = 'record_trial =' . $trial . '';
                } else {
                    $trial = 1;
                    $obj = "";
                    $check = 'record_trial =' . $trial . '';
                }
                $sql2 =
                    "SELECT DISTINCT  " .
                    $obj .
                    "athlete_id,record_order,athlete_name,schedule_sports FROM list_record 
                                    INNER JOIN list_athlete ON athlete_id = record_athlete_id 
                                    INNER JOIN list_schedule ON schedule_id= record_schedule_id 
                                    where $check AND schedule_id = '$s_id'
                                    ORDER BY $order ASC";
                $result2 = $db->query($sql2);
                while ($id = mysqli_fetch_array($result2)) {
                    echo "<tr>";
                    // ORDER
                    echo '<td rowspan="2">' . $id["record_order"] . '</td>';
                    // NAME
                    echo '<td rowspan="2">' . $id["athlete_name"] . '</td>';
                    // RESULT
                    if ($_POST["check"] ?? null >= 3 || $rows["schedule_status"] === "y") {
                        $answer = $db->query(
                            "SELECT record_live_record,record_wind FROM list_record
                                INNER JOIN list_athlete ON record_athlete_id=" .
                                $id["athlete_id"] .
                                " AND athlete_id= record_athlete_id
                                INNER JOIN list_schedule ON schedule_id= record_schedule_id
                                AND schedule_id = '$s_id'
                                ORDER BY record_trial ASC"
                        );
                        while ($row = mysqli_fetch_array($answer)) {
                            echo "<td>" . ($row["record_live_record"] ?? null) . "</td>";
                            $i++;
                        }
                    }
                    for ($j = $i; $j <= 6; $j++) {
                        echo "<td></td>";
                    } // 최종 결과
                    echo '<td rowspan="2">' . ($id["record_live_record"] ?? null) . '</td>';
                    // RANK
                    echo '<td rowspan="2">' . ($id["record_live_result"] ?? null) . '</td>';

                    // 경기 비고
                    // if ($is_not_official_status) {
                    $placeholder = trim($id["record_memo"]);
                    if (!(strlen($placeholder) > 0)) {
                        $placeholder = "-";
                    }
                    echo "<td><a href='view_input_remark.php?remark_category=result&record_id=" . trim($id["record_id"]) . "'>" . $placeholder . "</a></td>";

                    // WIND
                    echo "<tr>";
                    $wind = $db->query("SELECT record_wind FROM list_record
                              INNER JOIN list_athlete ON record_athlete_id=" .
                        $id["athlete_id"] .
                        " AND athlete_id= record_athlete_id
                              INNER JOIN list_schedule ON schedule_id= record_schedule_id
                              AND schedule_id = '$s_id'
                              ORDER BY record_trial ASC limit 6 ");
                    for ($j = 0; $j <= 5; $j++) {
                        if ($rows["schedule_status"] === "y") {
                            $windrow = mysqli_fetch_array($wind);
                        }
                        if ($j % 7 == 6) {
                            echo "<td>" . ($id["record_wind"] ?? null) . '</td>';
                        } else {
                            echo "<td>" . ($windrow["record_wind"] ?? null) . '</td>';
                        }
                    }
                    // 신기록
                    if (($id['record_new'] ?? null) == 'y') {
                        $newrecord = $db->query("SELECT worldrecord_athletics FROM list_worldrecord WHERE worldrecord_athlete_name ='" . $id['athlete_name'] . "' AND worldrecord_sports='" . $id['schedule_sports'] . "'");
                        // echo "SELECT worldrecord_athletics FROM list_worldrecord WHERE worldrecord_athlete_name ='".$id['athlete_name']."' AND worldrecord_sports='".$id['schedule_sports']."'".'<br>';
                        //추후에 태블릿용 페이지를 만든 후 일정과 연결 시 스포츠이름 받아와야함
                        $newathletics = array();
                        while ($athletics = mysqli_fetch_array($newrecord)) {
                            $newathletics[] = $athletics[0];
                        }
                        if (($newathletics[0] ?? null) === 'w') {
                            echo '<td>' . 'WR';
                            if (count($newathletics) > 1) {
                                echo ' 외 ' . (count($newathletics) - 1) . '개';
                            }
                            echo '</td>';
                        } else if (($newathletics[0] ?? null) === 'u') {
                            echo '<td>' . 'U20 WR';
                            if (count($newathletics) > 1) {
                                echo ' 외 ' . (count($newathletics) - 1) . '개';
                            }
                            echo '</td>';
                        } else if (($newathletics[0] ?? null) === 'a') {
                            echo '<td>' . 'AR';
                            if (count($newathletics) > 1) {
                                echo ' 외 ' . (count($newathletics) - 1) . '개';
                            }
                            echo '</td>';
                        } else if (($newathletics[0] ?? null) === 's') {
                            echo '<td>' . 'U20 AR';
                            if (count($newathletics) > 1) {
                                echo ' 외 ' . (count($newathletics) - 1) . '개';
                            }
                            echo '</td>';
                        } else if (($newathletics[0] ?? null) === 'c') {
                            echo '<td>' . 'CR';
                            if (count($newathletics) > 1) {
                                echo ' 외 ' . (count($newathletics) - 1) . '개';
                            }
                            echo '</td>';
                        } else {
                            echo '<td></td>';
                        }
                    } else {
                        echo '<td></td>';
                    }
                    echo "</tr>";
                    echo "</tr>";
                    $count++;
                    $i = 1;
                }
            }
            ?>
            </tr>
            </tr>
        </tbody>
    </table>
    <?php
    if ($is_not_official_status) {
        echo '<div class="container_postbtn">';
        echo '<div class="postbtn_like">';
        echo '<div class="like_btn">';
        echo "<a href='view_input_result.php?sports_category=long_jump&schedule_id=" . trim($s_id) . "' class=\"btn_navy a_button\">UPDATE</a>";
        echo '</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    ?>
</div>