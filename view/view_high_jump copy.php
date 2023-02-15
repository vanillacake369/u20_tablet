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

<div class="table-wrap">
    <table>
        <colgroup>
            <colgroup>
                <col style="width: auto" />
            </colgroup>
        </colgroup>
        <tr id="col1">
            <th style="background: none" rowspan="2">등수</th>
            <th style="background: none" rowspan="2">순서</th>
            <th style="background: none" rowspan="2">이름</th>
            <?php
            // 높이 찾는 쿼리
            $highresult = $db->query("SELECT DISTINCT record_live_record FROM list_record INNER JOIN list_schedule 
                                ON list_schedule.schedule_id= list_record.record_schedule_id AND list_schedule.schedule_id = '$s_id' limit 12");
            $cnt1 = 0;
            while ($highrow = mysqli_fetch_array($highresult)) {
                echo '<th style="background: none"><input placeholder="높이" type="text" name="trial[]"
                                    class="input_trial" id="trial" value="' .
                    $highrow["record_live_record"] .
                    '" maxlength="4" 
                                    onkeyup="heightFormat(this)"></th>';
                $cnt1++;
            }
            for ($j = 0; $j < 12 - $cnt1; $j++) {
                echo '<th style="background: none"><input placeholder="높이" type="text" name="trial[]"
                                    class="input_trial" id="trial" value="" maxlength="4" 
                                    onkeyup="heightFormat(this)"></th>';
            }
            ?>
            <th style="background: none" rowspan="2">기록</th>
            <th style="background: none">비고</th>

        </tr>
        <tr id="col2">
            <?php if ($cnt1 == 12) {
                $cnt2 = 0;
                $highresult = $db->query("SELECT DISTINCT record_live_record FROM list_record INNER JOIN list_schedule 
                                ON list_schedule.schedule_id= list_record.record_schedule_id AND list_schedule.schedule_id = '$s_id' limit 12,12");
                while ($highrow = mysqli_fetch_array($highresult)) {
                    echo '<th style="background: none"><input placeholder="높이" type="text" name="trial[]"
                                    class="input_trial" id="trial" value="' .
                        $highrow["record_live_record"] .
                        '" maxlength="4" 
                                    onkeyup="heightFormat(this)"></th>';
                    $cnt2++;
                }
                for ($j = 0; $j < 12 - $cnt2; $j++) {
                    echo '<th style="background: none"><input placeholder="높이" type="text" name="trial[]"
                                    class="input_trial" id="trial" value="" maxlength="4" 
                                    onkeyup="heightFormat(this)"></th>';
                }
            } else {
                for ($j = 0; $j < 12; $j++) {
                    echo '<th style="background: none"><input placeholder="높이" type="text" name="trial[]"
                                        class="input_trial" id="trial" value="" maxlength="4" 
                                        onkeyup="heightFormat(this)"></th>';
                }
            } ?>
            <th style="background: none">신기록</th>
        </tr>
        </thead>
        <tbody id="body">
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
                echo '<td rowspan="2"><input type="number" name="rank[]" class="input_text" id="rank" value="' .
                    ($row["record_live_result"] ?? null) .
                    '"min="1" max="12" required="" /></td>';
                echo '<td rowspan="2"><input type="number" name="rain[]" class="input_text" value="' .
                    $row["record_order"] .
                    '" min="1" max="12" required="" readonly /></td>';
                echo '<td rowspan="2" ><input placeholder="선수 이름" type="text" name="playername[]" id="name" class="input_text"
                                 value="' .
                    $row["athlete_name"] .
                    '" maxlength="30" required="" readonly/></td>';
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
                        echo "<td>";
                        echo '<input placeholder="" type="text" name="gameresult' .
                            $cnt3 .
                            '[]" class="input_text" value="' .
                            $recordrow["record_trial"] .
                            '"
                              maxlength="3" onkeyup="highFormat(this)"
                              style="float: left; width: auto; padding-right: 5px" />';
                        echo "</td>";
                        $cnt3++;
                    }
                }
                for ($a = $cnt3; $a <= 12; $a++) {
                    //기록을 제외한 빈칸으로 생성
                    echo "<td>";
                    echo '<input placeholder="" type="text" name="gameresult' .
                        $a .
                        '[]" class="input_text" value=""
                                      maxlength="3" onkeyup="highFormat(this)"
                                      style="float: left; width: auto; padding-right: 5px" />';
                    echo "</td>";
                }

                //
                echo '<td rowspan="2">';
                echo '<input placeholder="결과" id="result" type="text" name="gameresult[]" class="input_text"
                                    value="' .
                    ($row["record_live_record"] ?? null) .
                    '" maxlength="3" required=""
                                    style="float: left; width: auto; padding-right: 5px" />';
                echo "</td>";
                echo '<input type="hidden" name="compresult[]" value="' . ($row["record_live_record"] ?? null) . '"/>';
                echo '<td><input placeholder="비고" type="text" name="bigo[]" class="input_text" value="' .
                    ($row["record_memo"] ?? null) .
                    '" maxlength="100" /></td>';
                //
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
                        echo "<td>";
                        echo '<input placeholder="" type="text" name="gameresult' .
                            $cnt3 .
                            '[]" class="input_text" value="' .
                            $recordrow["record_trial"] .
                            '"
                              maxlength="3" onkeyup="highFormat(this)"
                              style="float: left; width: auto; padding-right: 5px" />';
                        echo "</td>";
                        $cnt3++;
                    }
                } else {
                    $cnt3 = 13;
                }
                for ($a = $cnt3; $a <= 24; $a++) {
                    //기록을 제외한 빈칸으로 생성
                    echo "<td>";
                    echo '<input placeholder="" type="text" name="gameresult' .
                        $a .
                        '[]" class="input_text" value=""
                                        maxlength="3" onkeyup="highFormat(this)"
                                        style="float: left; width: auto; padding-right: 5px" />';
                    echo "</td>";
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
                        echo '<td><input placeholder=""  type="text" name="newrecord[]" class="input_text" value="세계신기록';
                        if (count($newathletics) > 1) {
                            echo ' 외 ' . (count($newathletics) - 1) . '개';
                        }
                        echo '" maxlength="100" ath="' . $row['athlete_name'] . '" sports=' . $rows['schedule_sports'] . ' schedule_id="' . $s_id . '" readonly/></td>';
                    } else if (($newathletics[0] ?? null) === 'u') {
                        echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_text" value="세계U20신기록';
                        if (count($newathletics) > 1) {
                            echo ' 외 ' . (count($newathletics) - 1) . '개';
                        }
                        echo '" maxlength="100" ath="' . $row['athlete_name'] . '" sports=' . $rows['schedule_sports'] . ' schedule_id="' . $s_id . '" readonly/></td>';
                    } else if (($newathletics[0] ?? null) === 'a') {
                        echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_text" value="아시아신기록';
                        if (count($newathletics) > 1) {
                            echo ' 외 ' . (count($newathletics) - 1) . '개';
                        }
                        echo '" maxlength="100" ath="' . $row['athlete_name'] . '" sports=' . $rows['schedule_sports'] . ' schedule_id="' . $s_id . '" readonly/></td>';
                    } else if (($newathletics[0] ?? null) === 's') {
                        echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_text" value="아시아U20신기록';
                        if (count($newathletics) > 1) {
                            echo ' 외 ' . (count($newathletics) - 1) . '개';
                        }
                        echo '" maxlength="100" ath="' . $row['athlete_name'] . '" sports=' . $rows['schedule_sports'] . ' schedule_id="' . $s_id . '" readonly/></td>';
                    } else if (($newathletics[0] ?? null) === 'c') {
                        echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_text" value="대회신기록';
                        if (count($newathletics) > 1) {
                            echo ' 외 ' . (count($newathletics) - 1) . '개';
                        }
                        echo '" maxlength="100" ath="' . $row['athlete_name'] . '" sports=' . $rows['schedule_sports'] . ' schedule_id="' . $s_id . '" readonly/></td>';
                    } else {
                        echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_text" value="" maxlength="100" ath="' . $row['athlete_name'] . '" sports=' . $rows['schedule_sports'] . ' schedule_id="' . $s_id . '" readonly/></td>';
                    }
                } else {
                    echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_text" value="" maxlength="100" ath="' . $row['athlete_name'] . '" sports=' . $rows['schedule_sports'] . ' schedule_id="' . $s_id . '" readonly/></td>';
                }
                $cnt++;
            }
            ?>
            </tr>
            </tr>
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