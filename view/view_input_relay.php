<?php
// 경기 상태에 따른 경기 결과 처리 모델
include(__DIR__ . "/../database/dbconnect.php");
include_once(__DIR__ . "/../model/model_result_by_state.php");
include_once(__DIR__ . "/../model/model_match_info_by_state.php");
// $id : 스케줄 id
$sports_category = trim($_GET["sports_category"]);
$id = trim($_GET["schedule_id"]);
$result_array = getResultByState($id);
$wind = $result_array[0]["record_wind"];
$judge_id = trim($_SESSION['Id']);
$sql = "SELECT DISTINCT schedule_name,schedule_round,schedule_status,record_wind,schedule_sports FROM list_record  INNER JOIN list_schedule ON schedule_id= record_schedule_id AND schedule_id = '$id'";
$result = $db->query($sql);
$rows = mysqli_fetch_assoc($result);
$judgesql = "SELECT DISTINCT judge_name from list_judge WHERE judge_account = '" . $judge_id . "'";
$judgeresult = $db->query($judgesql);
$judgerow = mysqli_fetch_array($judgeresult);
?>
<div class="table-wrap">
    <form action="../model/model_result_relay.php" method="post" class="form">
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
                $count = 0;
                if ($rows['schedule_status'] == 'y') {
                    $order = 'record_live_result';
                } else {
                    $order = 'record_order';
                }
                $sql = "SELECT  * FROM list_record 
                        INNER JOIN list_athlete ON athlete_id = record_athlete_id 
                        INNER JOIN list_schedule ON schedule_id= record_schedule_id AND schedule_id = '$id' 
                        ORDER BY " . $order . " ASC,athlete_name ASC ";
                $result = $db->query($sql);
                $count = 0;
                $cnt = 0;
                $athrecord = array();
                // count % 4 : 4명 당 한 행

                while ($row = mysqli_fetch_array($result)) {
                    $athrecord[$count % 4] = $row['record_live_record'];
                    if ($count % 4 == 0) {
                        echo '<tr id="rane' . $row['record_order'] . '">';
                        // 레인
                        echo '<td><input type="number" name="rain[]" class="input_result" value="' . $row['record_order'] . '" min="1" max="12" required="" readonly /></td>';
                        echo '<td>';
                    }
                    if ($count % 4 == 3) {
                        // 이름
                        echo '<input placeholder="선수 이름" type="text" name="playername[]"
                                class="input_result" value="' . $row['athlete_name'] . '" maxlength="30" required="" readonly/></td>';
                        // 성별
                        echo '<td>' . $row['schedule_gender'] . '</td>';
                        // 국가
                        echo '<td>' . $row['athlete_country'] . '</td>';
                        // 소속
                        echo '<td><input placeholder="소속" type="text" name="division" class="input_result" value="' . $row['athlete_country'] . '"maxlength="50" required="" readonly/></td>';
                        // 기록
                        echo '<td>
                            <input placeholder="경기 결과" type="text" name="gameresult[]" id="result" class="input_result"
                                value="' . ($athrecord[3] ? $athrecord[3] : 0) . '" maxlength="8" required="" onkeyup="trackFinal(this)"
                                     />
                                </div>
                                </div></td>';

                        // 등수
                        echo '<td><input type="number" name="rank[]" id="rank" class="input_result" value="' . $row['record_live_result'] . '" min="1" max="12" required="" /></td>';
                        // 통과 여부
                        echo '<td><input placeholder="경기 통과 여부" type="text" name="gamepass[]" class="input_result" value="' . $row['record_pass'] . '" maxlength="1" required="" /></td>';
                        // 신기록 여부 
                        //추후에 태블릿용 페이지를 만든 후 일정과 연결 시 스포츠이름 받아와야함
                        $newrecord = $db->query("SELECT worldrecord_athletics FROM list_worldrecord WHERE worldrecord_athlete_name ='" . $row['athlete_country'] . "' AND worldrecord_sports='" . $rows['schedule_sports'] . "'");
                        $sql1 = "SELECT worldrecord_athletics FROM list_worldrecord WHERE worldrecord_athlete_name ='" . $row['athlete_name'] . "' AND worldrecord_sports='" . $rows['schedule_sports'] . "'";
                        $newathletics = array();
                        while ($athletics = mysqli_fetch_array($newrecord)) {
                            $newathletics[] = $athletics[0];
                        }
                        if (($newathletics[0] ?? null) === 'w') {
                            echo '<td><input placeholder=""  type="text" name="newrecord[]" class="input_result" value="세계신기록';
                            if (count($newathletics) > 1) {
                                echo ' 외 ' . (count($newathletics) - 1) . '개';
                            }
                            echo '" maxlength="100" ath="' . $row['athlete_country'] . '" sports=' . $rows['schedule_sports'] . ' schedule_id="' . $id . '" readonly/></td>';
                        } else if (($newathletics[0] ?? null) === 'u') {
                            echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_result" value="세계U20신기록';
                            if (count($newathletics) > 1) {
                                echo ' 외 ' . (count($newathletics) - 1) . '개';
                            }
                            echo '" maxlength="100" ath="' . $row['athlete_country'] . '" sports=' . $rows['schedule_sports'] . ' schedule_id="' . $id . '" readonly/></td>';
                        } else if (($newathletics[0] ?? null) === 'a') {
                            echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_result" value="아시아신기록';
                            if (count($newathletics) > 1) {
                                echo ' 외 ' . (count($newathletics) - 1) . '개';
                            }
                            echo '" maxlength="100" ath="' . $row['athlete_country'] . '" sports=' . $rows['schedule_sports'] . ' schedule_id="' . $id . '" readonly/></td>';
                        } else if (($newathletics[0] ?? null) === 's') {
                            echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_result" value="아시아U20신기록';
                            if (count($newathletics) > 1) {
                                echo ' 외 ' . (count($newathletics) - 1) . '개';
                            }
                            echo '" maxlength="100" ath="' . $row['athlete_country'] . '" sports=' . $rows['schedule_sports'] . ' schedule_id="' . $id . '" readonly/></td>';
                        } else if (($newathletics[0] ?? null) === 'c') {
                            echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_result" value="대회신기록';
                            if (count($newathletics) > 1) {
                                echo ' 외 ' . (count($newathletics) - 1) . '개';
                            }
                            echo '" maxlength="100" ath="' . $row['athlete_country'] . '" sports=' . $rows['schedule_sports'] . ' schedule_id="' . $id . '" readonly/></td>';
                        } else {
                            echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_result" value="" maxlength="100" ath="' . $row['athlete_country'] . '" sports=' . $rows['schedule_sports'] . ' schedule_id="' . $id . '" readonly/></td>';
                        }
                        $cnt++;

                        // 상태
                        echo '<td>' . $row['record_status'] . '</td>';
                        // 비고
                        echo '<td><input placeholder="비고" type="text" name="bigo[]" class="input_result" value="" maxlength="100" /></td>';
                    } else {
                        echo '<input placeholder="선수 이름" type="text" name="playername[]"
                                class="input_result" value="' . $row['athlete_name'] . '" maxlength="30" required="" readonly style="margin-bottom: 10px;"/>';
                    }
                    $count++;
                }
                ?>
            </tbody>
        </table>
        <div class="container_postbtn">
            <div class="postbtn_like">
                <div class="like_btn">
                    <button type="submit" class="btn_navy btn_update">
                        <span class="span_like_h3">CONFIRM</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>