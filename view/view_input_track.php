<?php
// DB 연결
include(__DIR__ . "/../database/dbconnect.php");
// STATUS(공식/실시간)에 따른 값 변환 <= 경기기록 가져오기 <= DB
include_once(__DIR__ . "/../model/model_result_by_state.php");
// STATUS(공식/실시간)에 따른 값 변환 <= 경기관련내용 가져오기 <= DB
include_once(__DIR__ . "/../model/model_match_info_by_state.php");
// 값 변환 (PASS <= p)
include_once(__DIR__ . "/module_change_state.php");

$sports_category = trim($_GET["sports_category"]);
$id = trim($_GET["schedule_id"]);
$result_array = getResultByState($id);
$wind = $result_array[0]["record_wind"];
// 경기 정보 가져오기
$judge_id = trim($_SESSION['Id']);
$sql = "SELECT DISTINCT schedule_name,schedule_round,schedule_status,record_wind,schedule_sports FROM list_record  INNER JOIN list_schedule ON schedule_id= record_schedule_id AND schedule_id = '$id'";
$result = $db->query($sql);
$rows = mysqli_fetch_assoc($result);
// 심판 정보 가져오기
$judgesql = "SELECT DISTINCT judge_name from list_judge WHERE judge_account = '" . $judge_id . "'";
$judgeresult = $db->query($judgesql);
$judgerow = mysqli_fetch_array($judgeresult);
?>

<div class="table-wrap">
    <form action="../model/model_result_track.php" method="post" class="form">
        <!-- 라운드 -->
        <input type="hidden" name="round" value="<?= $rows['schedule_round'] ?>">
        <!-- 경기 이름 -->
        <input type="hidden" name="gamename" value="<?= $rows['schedule_name'] ?>">
        <!-- 스케줄 id -->
        <input type="hidden" name="schedule_id" value="<?= $id ?>">
        <!-- 심판 이름 -->
        <input type="hidden" name="refereename" class="input_text" value="<?= $judgerow['judge_name'] ?>" maxlength="30" required="" readonly />
        <!-- 풍속 입력 -->
        <h3 class="intro">WIND</h3>
        <div class="input_row">
            <?php
            echo '<input placeholder="풍속을 입력해주세요." type="text" name="wind" class="input_text" value="' . $wind . '" maxlength="16" required="">';
            ?>
        </div>
        <h3 class="intro">RESULT</h3>
        <table>
            <colgroup>
                <col class="col_view_lane">
                <col class="col_view_name">
                <col class="col_view_gender">
                <col class="col_view_nation">
                <col class="col_view_team">
                <col class="col_view_result">
                <col class="col_view_rank">
                <col class="col_view_pass">
                <col class="col_view_new_record">
                <col class="col_view_status">
                <col class="col_view_remark">
            </colgroup>
            <thead>
                <tr>
                    <th>LANE</th>
                    <th>NAME</th>
                    <th>GENDER</th>
                    <th>NATION</th>
                    <th>TEAM</th>
                    <th>RESULT</th>
                    <th>RANK</th>
                    <th>PASS</th>
                    <th>NEW RECORD</th>
                    <th>STATUS</th>
                    <th>REMARK</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($rows['schedule_status'] == 'y') {
                    $order = 'record_live_result';
                } else {
                    $order = 'record_order';
                }
                $sql = "SELECT * FROM list_record 
                        INNER JOIN list_athlete ON list_athlete.athlete_id = list_record.record_athlete_id 
                        INNER JOIN list_schedule ON list_schedule.schedule_id= list_record.record_schedule_id 
                        AND list_schedule.schedule_id = '$id'
                        ORDER BY " . $order . " ASC ";
                // $sql = "SELECT " . $relm . " FROM list_record 
                //         INNER JOIN list_athlete ON list_athlete.athlete_id = list_record.record_athlete_id 
                //         INNER JOIN list_schedule ON list_schedule.schedule_id= list_record.record_schedule_id 
                //         AND list_schedule.schedule_id = '$id'
                //         ORDER BY " . $order . " ASC ";
                $count = 0;
                $result = $db->query($sql);
                while ($row = mysqli_fetch_array($result)) {
                    echo '<tr id="rane' . $row['record_order'] . '">';
                    // 레인
                    echo "<td>" . $row['record_order'] . "</td>";
                    echo '<input type="hidden" name="rain[]" value="' . $row['record_order'] . '">';
                    // 이름
                    echo "<td>" . $row['athlete_name'] . "</td>";
                    echo '<input type="hidden" name="playername[]" value="' . $row['athlete_name'] . '">';
                    // 성별
                    echo '<td>' . $row['schedule_gender'] . '</td>';
                    // 국가
                    echo '<td>' . $row['athlete_country'] . '</td>';
                    // 팀
                    echo '<td>' . $row['athlete_division'] . '</td>';
                    // 기록
                    echo '<td>
                            <input placeholder="경기 결과를 입력해주세요" type="text" name="gameresult[]" id="result" class="input_result" 
                            value="' . $row['record_live_record'] . '" maxlength="8"
                            required="" onkeyup="trackFinal(this)"/>
                        </td>';
                    // 순위
                    echo '<td>
                            <input type="number" name="rank[]" id="rank" class="input_result" 
                            value="' . $row['record_live_result'] . '" min="1" max="12" required="" />
                        </td>';
                    // 통과 여부
                    $pass_array = ["p", "l", "d", "w", "n"]; //DB 저장값
                    $pass_dic = []; //뷰 출력값
                    $pass_dic["p"] = "PASS";
                    $pass_dic["l"] = "FAIL";
                    $pass_dic["d"] = "DISQUALIFY";
                    $pass_dic["w"] = "RESIGN";
                    $pass_dic["n"] = "NOT STARTED";
                    $isPassSelected = maintainSelected($row['record_pass'] ?? NULL);
                    echo '<td>';
                    echo '<select class="d_select" name="gamepass[]">';
                    foreach ($pass_array as $key) {
                        $pass_str = $pass_dic[$key];
                        echo "<option value=$key" . $isPassSelected[$key] . ">$pass_str</option>";
                    }
                    echo '</select>';
                    echo '</td>';
                    // 신기록 여부
                    if ($row['record_new'] == 'y') {
                        $newrecord = $db->query("SELECT worldrecord_athletics FROM list_worldrecord WHERE worldrecord_athlete_name ='" . $row['athlete_name'] . "' AND worldrecord_sports='" . $rows['schedule_sports'] . "'");
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
                            echo '" maxlength="100" ath="' . $row['athlete_name'] . '" sports=' . $rows['schedule_sports'] . ' schedule_id="' . $id . '" readonly/></td>';
                        } else if (($newathletics[0] ?? null) === 'u') {
                            echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_result" value="WR U20';
                            if (count($newathletics) > 1) {
                                echo ' 외 ' . (count($newathletics) - 1) . '개';
                            }
                            echo '" maxlength="100" ath="' . $row['athlete_name'] . '" sports=' . $rows['schedule_sports'] . ' schedule_id="' . $id . '" readonly/></td>';
                        } else if (($newathletics[0] ?? null) === 'a') {
                            echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_result" value="AR';
                            if (count($newathletics) > 1) {
                                echo ' 외 ' . (count($newathletics) - 1) . '개';
                            }
                            echo '" maxlength="100" ath="' . $row['athlete_name'] . '" sports=' . $rows['schedule_sports'] . ' schedule_id="' . $id . '" readonly/></td>';
                        } else if (($newathletics[0] ?? null) === 's') {
                            echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_result" value="AR U20';
                            if (count($newathletics) > 1) {
                                echo ' 외 ' . (count($newathletics) - 1) . '개';
                            }
                            echo '" maxlength="100" ath="' . $row['athlete_name'] . '" sports=' . $rows['schedule_sports'] . ' schedule_id="' . $id . '" readonly/></td>';
                        } else if (($newathletics[0] ?? null) === 'c') {
                            echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_result" value="CR';
                            if (count($newathletics) > 1) {
                                echo ' 외 ' . (count($newathletics) - 1) . '개';
                            }
                            echo '" maxlength="100" ath="' . $row['athlete_name'] . '" sports=' . $rows['schedule_sports'] . ' schedule_id="' . $id . '" readonly/></td>';
                        } else {
                            echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_result" value="" maxlength="100" ath="' . $row['athlete_name'] . '" sports=' . $rows['schedule_sports'] . ' schedule_id="' . $id . '" readonly/></td>';
                        }
                    } else {
                        echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_result" value="" maxlength="100" ath="' . $row['athlete_name'] . '" sports=' . $rows['schedule_sports'] . ' schedule_id="' . $id . '" readonly/></td>';
                    }
                    // 상태
                    echo '<td>' . $row['record_status'] . '</td>';
                    // 비고
                    echo '<td><input placeholder="INSERT REMARK" type="text" name="bigo[]" class="input_result" value="' . ($row['record_memo'] ? $row['record_memo'] : '&nbsp') . '" maxlength="100" /></td>';
                    $count++;
                }
                ?>
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