<?php
// 경기 상태에 따른 경기 결과 처리 모델
include_once(__DIR__ . "/../model/model_result_by_state.php");
include_once(__DIR__ . "/../model/model_match_info_by_state.php");
include(__DIR__ . "/../database/dbconnect.php");

// $id : 스케줄 id
$sports_category = trim($_GET["sports_category"]);
$s_id = trim($_GET["schedule_id"]);
$result_array = getResultByState($s_id);
$match_info_array = getMatchInfoByState($s_id);

$sql =
    "SELECT DISTINCT schedule_round,schedule_status,schedule_name,schedule_sports FROM list_record INNER JOIN list_schedule ON schedule_id= record_schedule_id AND schedule_id = '$s_id'";
$result = $db->query($sql);
$rows = mysqli_fetch_assoc($result);
$judgesql = "select distinct judge_name from list_judge  join list_record ON  record_judge = judge_id INNER JOIN list_schedule ON schedule_id= record_schedule_id AND schedule_id = '$s_id'";
$judgeresult = $db->query($judgesql);
$judgerow = mysqli_fetch_array($judgeresult);
?>
<h3 class="intro">RESULT</h3>
<div class="table-wrap">
    <table>
        <colgroup>
            <colgroup>
                <col style="width: auto" />
            </colgroup>
        </colgroup>
        <thead>
            <!-- 윗 부분 : 레인,이름,높이(기록),통과,등수 -->
            <tr id="col1">
                <th rowspan="2">RANK</th>
                <th rowspan="2">ORDER</th>
                <th rowspan="2">NAME</th>
                <!-- <th>HEIGHT</th>
                <th>HEIGHT</th>
                <th>HEIGHT</th>
                <th>HEIGHT</th>
                <th>HEIGHT</th>
                <th>HEIGHT</th>
                <th>HEIGHT</th>
                <th>HEIGHT</th>
                <th>HEIGHT</th>
                <th>HEIGHT</th>
                <th>HEIGHT</th>
                <th>HEIGHT</th> -->
                <?php
                // 높이 찾는 쿼리
                $highresult = $db->query("SELECT DISTINCT record_live_record FROM list_record INNER JOIN list_schedule 
					ON list_schedule.schedule_id= list_record.record_schedule_id AND list_schedule.schedule_id = '$s_id' limit 12");
                $cnt1 = 0;
                while ($highrow = mysqli_fetch_array($highresult)) {
                    $highrow["record_live_record"] = is_null($highrow["record_live_record"]) ? "HEIGHT" : $highrow["record_live_record"];
                    // $highrow["record_live_record"] = is_null($highrow["record_live_record"]) ? "높이" : ($highrow["record_live_record"] ?? null);
                    echo '<th>' . $highrow["record_live_record"] . '</th>';
                    $cnt1++;
                    // echo '<th style="background: none"><input placeholder="높이" type="text" name="trial[]"
                    // 	class="input_trial" id="trial" value="' .
                    //     $highrow["record_live_record"] .
                    //     '" maxlength="4" 
                    // 	onkeyup="heightFormat(this)"></th>';
                    // $cnt1++;
                }
                for ($j = 0; $j < 12 - $cnt1; $j++) {
                    echo '<th>HEIGHT</th>';
                    // echo '<th style="background: none"><input placeholder="높이" type="text" name="trial[]"
                    // 	class="input_trial" id="trial" value="" maxlength="4" 
                    // 	onkeyup="heightFormat(this)"></th>';
                }
                ?>
                <th rowspan="2">FINAL</th>
                <th>REMARK</th>
            </tr>
            <!-- 아랫부분 :: 높이(기록),비고,신기록 -->
            <tr id="col2">
                <!-- <th>HEIGHT</th>
                <th>HEIGHT</th>
                <th>HEIGHT</th>
                <th>HEIGHT</th>
                <th>HEIGHT</th>
                <th>HEIGHT</th>
                <th>HEIGHT</th>
                <th>HEIGHT</th>
                <th>HEIGHT</th>
                <th>HEIGHT</th>
                <th>HEIGHT</th>
                <th>HEIGHT</th> -->
                <?php if ($cnt1 == 12) {
                    $cnt2 = 0;
                    $highresult = $db->query("SELECT DISTINCT record_live_record FROM list_record INNER JOIN list_schedule 
					ON list_schedule.schedule_id= list_record.record_schedule_id AND list_schedule.schedule_id = '$s_id' limit 12,12");
                    while ($highrow = mysqli_fetch_array($highresult)) {
                        $highrow["record_live_record"] = is_null($highrow["record_live_record"]) ? "HEIGHT" : $highrow["record_live_record"];
                        echo '<th>' . $highrow["record_live_record"] . '</th>';
                        $cnt2++;
                        // echo '<th style="background: none"><input placeholder="높이" type="text" name="trial[]"
                        // class="input_trial" id="trial" value="' .
                        //     $highrow["record_live_record"] .
                        //     '" maxlength="4" 
                        // onkeyup="heightFormat(this)"></th>';
                        // $cnt2++;
                    }
                    for ($j = 0; $j < 12 - $cnt2; $j++) {
                        echo '<th></th>';
                        // echo '<th style="background: none"><input placeholder="높이" type="text" name="trial[]"
                        // class="input_trial" id="trial" value="" maxlength="4" 
                        // onkeyup="heightFormat(this)"></th>';
                    }
                } else {
                    for ($j = 0; $j < 12; $j++) {
                        echo '<th>HEIGHT</th>';
                    }
                } ?>
                <th>NEW RECORD</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($rows["schedule_status"] === "y") {
                $order = "record_live_result";
                $obj = "record_live_result,record_memo,athlete_id,record_live_record,";
                $jo = "WHERE record_live_result>0";
            } else {
                $order = "record_order";
                $obj = "";
                $jo = "";
            }
            $result = $db->query(
                "SELECT DISTINCT " .
                    $obj .
                    "record_order,record_new,athlete_name FROM list_record 
                            INNER JOIN list_athlete ON athlete_id = record_athlete_id 
                            INNER JOIN list_schedule ON schedule_id= record_schedule_id 
                            AND schedule_id = '$s_id'" . $jo . "
                            ORDER BY " . $order . " ASC , record_live_record ASC"
            );
            $cnt = 1;
            while ($row = mysqli_fetch_array($result)) {
                echo '<tr id=col1 class="col1_' . $cnt . '">';
                // RANK
                echo '<td rowspan="2">' . ($row["record_live_result"] ?? null) . '</td>';
                // ORDER
                echo '<td rowspan="2">' . ($row["record_order"] ?? null) . '</td>';
                // NAME
                echo '<td rowspan="2">' . ($row["athlete_name"] ?? null) . '</td>';
                $cnt3 = 1;
                if ($rows["schedule_status"] === "y") {
                    $record = $db->query(
                        "SELECT record_trial FROM list_record
                                                INNER JOIN list_athlete ON record_athlete_id=" .
                            $row["athlete_id"] .
                            " AND athlete_id= record_athlete_id
                                                INNER JOIN list_schedule ON schedule_id= record_schedule_id
                                                AND schedule_id = '$s_id'
                                                ORDER BY record_live_record ASC limit 12"
                    ); //선수별 기록 찾는 쿼리
                    while ($recordrow = mysqli_fetch_array($record)) {
                        echo "<td>" . $recordrow["record_trial"] . "</td>";
                        $cnt3++;
                    }
                }
                for ($a = $cnt3; $a <= 12; $a++) {
                    //기록을 제외한 빈칸으로 생성
                    echo "<td></td>";
                }
                echo '<td rowspan="2">' . ($row["record_live_record"] ?? null) . "</td>";
                echo '<td>' . ($row["record_memo"] ?? null) . "</td>";
                echo '<tr id=col2 class="col2_' . $cnt . '">';
                if ($rows["schedule_status"] === "y" && $cnt3 == 12) {
                    //13번째 기록부터
                    $record = $db->query(
                        "SELECT record_trial,record_athlete_id FROM list_record
                                                INNER JOIN list_athlete ON record_athlete_id=" .
                            $row["athlete_id"] .
                            " AND athlete_id= record_athlete_id
                                                INNER JOIN list_schedule ON schedule_id= record_schedule_id
                                                AND schedule_id = '$s_id'
                                                ORDER BY record_live_record ASC limit 12,12"
                    ); //선수별 기록 찾는 쿼리
                    while ($recordrow = mysqli_fetch_array($record)) {
                        echo "<td>" . $recordrow["record_trial"] . "</td>";
                        $cnt3++;
                    }
                } else {
                    $cnt3 = 13;
                }
                for ($a = $cnt3; $a <= 24; $a++) {
                    //기록을 제외한 빈칸으로 생성
                    echo "<td></td>";
                }
                if (($row['record_new'] && null) == 'y') {
                    $newrecord = $db->query("SELECT worldrecord_athletics FROM list_worldrecord WHERE worldrecord_athlete_name ='" . $row['athlete_name'] . "' AND worldrecord_sports='" . $rows['schedule_sports'] . "'");
                    echo "SELECT worldrecord_athletics FROM list_worldrecord WHERE worldrecord_athlete_name ='" . $row['athlete_name'] . "' AND worldrecord_sports='" . $rows['schedule_sports'] . "'" . '<br>';
                    //추후에 태블릿용 페이지를 만든 후 일정과 연결 시 스포츠이름 받아와야함
                    $newathletics = array();
                    while ($athletics = mysqli_fetch_array($newrecord)) {
                        $newathletics[] = $athletics[0];
                    }
                    if (($newathletics[0] ?? null) === 'w') {
                        echo '<td><input placeholder=""  type="text" name="newrecord[]" class="input_result" value="WR';
                        if (count($newathletics) > 1) {
                            echo ' 외 ' . (count($newathletics) - 1) . '개';
                        }
                        echo '" maxlength="100" ath="' . $row['athlete_name'] . '" sports=' . $rows['schedule_sports'] . ' schedule_id="' . $s_id . '" readonly/></td>';
                    } else if (($newathletics[0] ?? null) === 'u') {
                        echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_result" value="WR U20';
                        if (count($newathletics) > 1) {
                            echo ' 외 ' . (count($newathletics) - 1) . '개';
                        }
                        echo '" maxlength="100" ath="' . $row['athlete_name'] . '" sports=' . $rows['schedule_sports'] . ' schedule_id="' . $s_id . '" readonly/></td>';
                    } else if (($newathletics[0] ?? null) === 'a') {
                        echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_result" value="AR';
                        if (count($newathletics) > 1) {
                            echo ' 외 ' . (count($newathletics) - 1) . '개';
                        }
                        echo '" maxlength="100" ath="' . $row['athlete_name'] . '" sports=' . $rows['schedule_sports'] . ' schedule_id="' . $s_id . '" readonly/></td>';
                    } else if (($newathletics[0] ?? null) === 's') {
                        echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_result" value="AR U20';
                        if (count($newathletics) > 1) {
                            echo ' 외 ' . (count($newathletics) - 1) . '개';
                        }
                        echo '" maxlength="100" ath="' . $row['athlete_name'] . '" sports=' . $rows['schedule_sports'] . ' schedule_id="' . $s_id . '" readonly/></td>';
                    } else if (($newathletics[0] ?? null) === 'c') {
                        echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_result" value="CR';
                        if (count($newathletics) > 1) {
                            echo ' 외 ' . (count($newathletics) - 1) . '개';
                        }
                        echo '" maxlength="100" ath="' . $row['athlete_name'] . '" sports=' . $rows['schedule_sports'] . ' schedule_id="' . $s_id . '" readonly/></td>';
                    } else {
                        echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_result" value="" maxlength="100" ath="' . $row['athlete_name'] . '" sports=' . $rows['schedule_sports'] . ' schedule_id="' . $s_id . '" readonly/></td>';
                    }
                } else {
                    echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_result" value="" maxlength="100" ath="' . $row['athlete_name'] . '" sports=' . $rows['schedule_sports'] . ' schedule_id="' . $s_id . '" readonly/></td>';
                }
                $cnt++;
            }
            ?>
        </tbody>
    </table>
</div>

<div class="container_postbtn">
    <div class="postbtn_like">
        <div class="like_btn">
            <?php
            echo "<a href='view_input_result.php?sports_category=high_jump&schedule_id=" . trim($s_id) . "' class=\"btn_navy a_button\">UPDATE</a>";
            ?>
            </button>
        </div>
    </div>
</div>