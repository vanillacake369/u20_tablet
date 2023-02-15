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
    <form action="../model/model_result_long_jump.php" method="post" class="form">
        <!-- 라운드 -->
        <input type="hidden" name="round" value="<?= $rows['schedule_round'] ?>">
        <!-- 경기 이름 -->
        <input type="hidden" name="gamename" value="<?= $rows['schedule_name'] ?>">
        <!-- 스케줄 id -->
        <input type="hidden" name="schedule_id" value="<?= $s_id ?>">
        <!-- 심판 이름 -->
        <input type="hidden" name="refereename" class="input_text" value="<?= $judgerow['judge_name'] ?>" maxlength="30" required="" readonly />
        <div style="display:inline">
            <h3 class="intro" style="margin-bottom: 10px; float:left; margin-right: 30px;">RESULT</h3>
            <?php
            if ($rows["schedule_status"] != "y") {
                if ($rows['schedule_name'] != '10종경기(남)' || $rows['schedule_name'] != '7종경기(여)') {
                    echo '<button type="submit" class="btn_resort btn_grey" formaction="three_try_after_reverse.php"
                            style="width:auto; padding-left:5px; padding-right:5px;"><span>순서 재정렬</span></button>';
                }
            } else {
                // echo ' <div class="btn_base base_mar col_left">
                //             <input type="button" onclick="" class="btn_excel bold" value="엑셀 출력" />
                //         </div>
                //         <button type="submit" class="btn_add bold" formaction="pdfout3.php"><span>PDF 출력</span></button>';
            }
            if ($_POST['check'] ?? null === '3') {
                echo '<input type="hidden" name="count" value= "5">';
            } else {
                echo '<input type="hidden" name="count" value= "3">';
            }
            ?>
        </div>
        <table>
            <colgroup>
                <col class="col_view_rank">
                <col class="col_view_lane">
                <col class="col_view_name" style="width: 10%;">
                <col class="col_view_result_th" style="width: 7%;">
                <col class="col_view_result_th" style="width: 7%;">
                <col class="col_view_result_th" style="width: 7%;">
                <col class="col_view_result_th" style="width: 7%;">
                <col class="col_view_result_th" style="width: 7%;">
                <col class="col_view_result_th" style="width: 7%;">
                <col class="col_view_pass" style="width: 8%">
                <col class="col_view_remark">
            </colgroup>
            <thead>
                <!-- 윗 부분 : 레인,이름,차수별기록,통과,등수 -->
                <tr id="col1">
                    <th rowspan="2">RANK</th>
                    <th rowspan="2">ORDER</th>
                    <th rowspan="2">NAME</th>
                    <th>1st</th>
                    <th>2nd</th>
                    <th>3rd</th>
                    <th>4th</th>
                    <th>5th</th>
                    <th>6th</th>
                    <th>FINAL</th>
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
                $i = 1;
                $count = 0; //신기록시 셀렉트 박스 찾는 용도
                $trial = 0;
                $order = "record_order";
                $obj = "record_live_result,record_memo,record_live_record,record_wind,";
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
                    echo '<td rowspan="2"><input type="number" name="rank[]" class="input_result" id="rank" value="' .
                        ($id["record_live_result"] ?? null) .
                        '" min="1" max="12" required="" /></td>';
                    echo '<td rowspan="2"><input type="number" name="rain[]" class="input_result" value="' .
                        $id["record_order"] .
                        '" min="1" max="12" required="" readonly /></td>';
                    echo '<td rowspan="2"><input placeholder="선수 이름" type="text" name="playername[]" class="input_result"
                                  value="' .
                        $id["athlete_name"] .
                        '" maxlength="30" required="" readonly /></td>';
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
                            echo "<td>";
                            echo '<input placeholder="경기 결과" type="text" name="gameresult' .
                                $i .
                                '[]" class="input_result" value="' .
                                ($row["record_live_record"] ?? null) .
                                '"
                                  maxlength="5" onkeyup="field2Format(this)"
                                  style="float: left; width: auto; padding-right: 5px" />';
                            echo "</td>";
                            $i++;
                        }
                    }
                    if ($rows['schedule_name'] === '10종경기(남)' || $rows['schedule_name'] === '7종경기(여)') {
                        $k = 3;
                    } else {
                        $k = 6;
                    }
                    for ($j = $i; $j <= $k; $j++) {
                        echo "<td>";
                        echo '<input placeholder="경기 결과" type="text" name="gameresult' .
                            $j .
                            '[]" class="input_result" value=""
                                            maxlength="5" onkeyup="field2Format(this)"
                                            style="float: left; width: auto; padding-right: 5px" />';
                        echo "</td>";
                    }
                    echo "<td>";
                    echo '<input placeholder="경기 결과" id="result" type="text" name="gameresult[]" class="input_result"
                                    value="' .
                        ($id["record_live_record"] ?? null) .
                        '" maxlength="5" required="" onkeyup="field2Format(this)"
                                    style="float: left; width: auto; padding-right: 5px" />';
                    echo "</td>";
                    echo '<input type="hidden" name="compresult[]" value="' . ($id["record_live_record"] ?? null) . '"/>';
                    echo '<td><input type="text" placeholder ="비고"name="bigo[]" class="input_result" value="' .
                        ($id["record_memo"] ?? null) .
                        '" maxlength="100" /></td>';
                    echo "<tr>";
                    $wind = $db->query("SELECT record_wind FROM list_record
                              INNER JOIN list_athlete ON record_athlete_id=" .
                        $id["athlete_id"] .
                        " AND athlete_id= record_athlete_id
                              INNER JOIN list_schedule ON schedule_id= record_schedule_id
                              AND schedule_id = '$s_id'
                              ORDER BY record_trial ASC limit 6 ");
                    for ($j = 0; $j <= $k; $j++) {
                        $windrow = mysqli_fetch_array($wind);
                        // if ($rows["schedule_status"] === "y") {
                        // $windrow = mysqli_fetch_array($wind);
                        // }
                        if ($j % 7 == $k) {
                            echo "<td>";
                            echo '<input placeholder="풍속" type="text" name="lastwind[]" class="input_result" value="' .
                                ($id["record_wind"] ?? null) .
                                '"
                                            maxlength="5" required="" onkeyup="windFormat(this)"
                                            style="float: left; width: auto; padding-right: 5px" />';
                            echo "</td>";
                        } else {
                            echo "<td>";
                            echo '<input placeholder="풍속" type="text" name="wind' .
                                ($j + 1) .
                                '[]" class="input_result" value="' . ($windrow["record_wind"] ?? null) . '"
                                                maxlength="5" onkeyup="windFormat(this)"
                                                style="float: left; width: auto; padding-right: 5px"';
                            if ($j < 3) {
                                echo 'required=""';
                            }
                            echo  '/>';
                            echo "</td>";
                        }
                    }
                    if (($id['record_new'] ?? null) == 'y') {
                        $newrecord = $db->query("SELECT worldrecord_athletics FROM list_worldrecord WHERE worldrecord_athlete_name ='" . $id['athlete_name'] . "' AND worldrecord_sports='" . $id['schedule_sports'] . "'");
                        // echo "SELECT worldrecord_athletics FROM list_worldrecord WHERE worldrecord_athlete_name ='".$id['athlete_name']."' AND worldrecord_sports='".$id['schedule_sports']."'".'<br>';
                        //추후에 태블릿용 페이지를 만든 후 일정과 연결 시 스포츠이름 받아와야함
                        $newathletics = array();
                        while ($athletics = mysqli_fetch_array($newrecord)) {
                            $newathletics[] = $athletics[0];
                        }
                        if (($newathletics[0] ?? null) === 'w') {
                            echo '<td><input placeholder=""  type="text" name="newrecord[]" class="input_result" value="세계신기록';
                            if (count($newathletics) > 1) {
                                echo ' 외 ' . (count($newathletics) - 1) . '개';
                            }
                            echo '" maxlength="100" ath="' . $id['athlete_name'] . '" sports=' . $id['schedule_sports'] . ' schedule_id="' . $s_id . '" readonly/></td>';
                        } else if (($newathletics[0] ?? null) === 'u') {
                            echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_result" value="세계U20신기록';
                            if (count($newathletics) > 1) {
                                echo ' 외 ' . (count($newathletics) - 1) . '개';
                            }
                            echo '" maxlength="100" ath="' . $id['athlete_name'] . '" sports=' . $id['schedule_sports'] . ' schedule_id="' . $s_id . '" readonly/></td>';
                        } else if (($newathletics[0] ?? null) === 'a') {
                            echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_result" value="아시아신기록';
                            if (count($newathletics) > 1) {
                                echo ' 외 ' . (count($newathletics) - 1) . '개';
                            }
                            echo '" maxlength="100" ath="' . $id['athlete_name'] . '" sports=' . $id['schedule_sports'] . ' schedule_id="' . $s_id . '" readonly/></td>';
                        } else if (($newathletics[0] ?? null) === 's') {
                            echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_result" value="아시아U20신기록';
                            if (count($newathletics) > 1) {
                                echo ' 외 ' . (count($newathletics) - 1) . '개';
                            }
                            echo '" maxlength="100" ath="' . $id['athlete_name'] . '" sports=' . $id['schedule_sports'] . ' schedule_id="' . $s_id . '" readonly/></td>';
                        } else if (($newathletics[0] ?? null) === 'c') {
                            echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_result" value="대회신기록';
                            if (count($newathletics) > 1) {
                                echo ' 외 ' . (count($newathletics) - 1) . '개';
                            }
                            echo '" maxlength="100" ath="' . $id['athlete_name'] . '" sports=' . $id['schedule_sports'] . ' schedule_id="' . $s_id . '" readonly/></td>';
                        } else {
                            echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_result" value="" maxlength="100" ath="' . $id['athlete_name'] . '" sports=' . $id['schedule_sports'] . ' schedule_id="' . $s_id . '" readonly/></td>';
                        }
                    } else {
                        echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_result" value="" maxlength="100" ath="' . $id['athlete_name'] . '" sports=' . $id['schedule_sports'] . ' schedule_id="' . $s_id . '" readonly/></td>';
                    }
                    echo "</tr>";
                    echo "</tr>";
                    $count++;
                    $i = 1;
                }
                ?>
                </tr>
                </tr>
            </tbody>
        </table>

        <div class="container_postbtn">
            <div class="postbtn_like">
                <div class="like_btn">
                    <button type="submit" class="btn_navy btn_update" name="addresult">
                        <span class="span_like_h3">CONFIRM</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>