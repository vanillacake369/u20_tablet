<?php
// 경기 상태에 따른 경기 결과 처리 모델
include(__DIR__ . "/../database/dbconnect.php");
include_once(__DIR__ . "/../model/model_result_by_state.php");
include_once(__DIR__ . "/../model/model_match_info_by_state.php");
include_once(__DIR__ . "/module_change_state.php");
// $id : 스케줄 id
$sports_category = trim($_GET["sports_category"]);
$s_id = trim($_GET["schedule_id"]);
$result_array = getResultByState($s_id);
$weight = "";
if (isset($result_array[0])) {
    $weight = $result_array[0]["record_weight"];
}
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
    <form action="../model/model_result_field.php" method="post" class="form">
        <!-- 라운드 -->
        <input type="hidden" name="round" value="<?= $rows['schedule_round'] ?>">
        <!-- 경기 이름 -->
        <input type="hidden" name="gamename" value="<?= $rows['schedule_name'] ?>">
        <!-- 스케줄 id -->
        <input type="hidden" name="schedule_id" value="<?= $s_id ?>">
        <!-- 심판 이름 -->
        <input type="hidden" name="refereename" class="input_result" value="<?= $judgerow['judge_name'] ?>" maxlength="30" required="" readonly />
        <!-- 무게 -->
        <h3 class="intro">WEIGHT</h3>
        <div class="input_row">
            <input placeholder="WEIGHT" type="text" name="weight" class="input_text" value="<?php echo $weight; ?>" maxlength="16" required="">
        </div>
        <h3 class="intro">RESULT</h3>
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
                <col class="col_view_final_result">
                <col class="col_view_rank">
                <col class="col_view_new_record">
                <col class="col_view_remark">
            </colgroup>
            <thead>
                <tr>
                    <th>ORDER</th>
                    <th>NAME</th>
                    <th>1th</th>
                    <th>2th</th>
                    <th>3th</th>
                    <th>4th</th>
                    <th>5th</th>
                    <th>6th</th>
                    <th>FINAL</th>
                    <th>RANK</th>
                    <th>NEW RECORD</th>
                    <th>REMARK</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $count = 0; //신기록 위치 관련 변수
                $trial = 0;
                $order = "record_order";
                $obj = "record_live_result,record_memo,athlete_id,record_live_record,record_wind,";
                if ($rows["schedule_status"] === "y") {
                    $order = "record_live_result";
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
                    "record_order,athlete_name,record_new,schedule_sports  FROM list_record
                                    INNER JOIN list_athlete ON athlete_id = record_athlete_id 
                                    INNER JOIN list_schedule ON schedule_id= record_schedule_id 
                                    where $check AND schedule_id = '$s_id'
                                    ORDER BY $order ASC";
                $result2 = $db->query($sql2);
                while ($id = mysqli_fetch_array($result2)) {
                    echo '<tr>';
                    echo '<td><input type="number" name="rain[]" class="input_result" value="' . $id['record_order'] . '" min="1" max="12" required="" readonly /></td>';
                    echo '<td><input placeholder="선수 이름" type="text" name="playername[]" class="input_result"
                                value="' . $id['athlete_name'] . '" maxlength="30" required="" readonly /></td>';
                    if ($_POST["check"] ?? null >= 3 || $rows["schedule_status"] === "y") {
                        $answer = $db->query("SELECT record_live_record FROM list_record join list_athlete ON athlete_id = record_athlete_id where record_athlete_id = '" . $id['athlete_id'] . "' AND record_schedule_id = '$s_id' ORDER BY record_trial ASC");
                        while ($row = mysqli_fetch_array($answer)) {
                            echo '<td>';
                            echo '<input placeholder="경기 결과" type="text" name="gameresult' . ($i) . '[]" class="input_result" value="' . ($row['record_live_record'] ?? null) . '"
                                        maxlength="5" required="" onkeyup="field1Format(this)"/>';
                            echo '</td>';
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
                                                    maxlength="5" onkeyup="field1Format(this)"/>';
                        echo "</td>";
                    }
                    echo '<td>';
                    echo '<input placeholder="경기 결과" id="result" type="text" name="gameresult[]" class="input_result"
                                    value="' . ($id["record_live_record"] ?? null) . '" maxlength="5" required="" onkeyup="field1Format(this)"/>';
                    echo '<input type="hidden" name="compresult[]" value="' . ($id["record_live_record"] ?? null) . '"/>';
                    echo '</td>';
                    echo '<td><input type="number" name="rank[]" class="input_result" id="rank" value="' . ($id['record_live_result'] ?? null) . '" min="1" max="12" required="" /></td>';
                    // if ($id['record_new'] == 'y') {
                    $newrecord = $db->query("SELECT worldrecord_athletics FROM list_worldrecord WHERE worldrecord_athlete_name ='" . $id['athlete_name'] . "' AND worldrecord_sports='" . $id['schedule_sports'] . "'");
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
                        echo '" maxlength="100" ath="' . $id['athlete_name'] . '" sports=' . $id['schedule_sports'] . ' schedule_id="' . $s_id . '" readonly/></td>';
                    } else if (($newathletics[0] ?? null) === 'u') {
                        echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_result" value="U20 WR';
                        if (count($newathletics) > 1) {
                            echo ' 외 ' . (count($newathletics) - 1) . '개';
                        }
                        echo '" maxlength="100" ath="' . $id['athlete_name'] . '" sports=' . $id['schedule_sports'] . ' schedule_id="' . $s_id . '" readonly/></td>';
                    } else if (($newathletics[0] ?? null) === 'a') {
                        echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_result" value="AR';
                        if (count($newathletics) > 1) {
                            echo ' 외 ' . (count($newathletics) - 1) . '개';
                        }
                        echo '" maxlength="100" ath="' . $id['athlete_name'] . '" sports=' . $id['schedule_sports'] . ' schedule_id="' . $s_id . '" readonly/></td>';
                    } else if (($newathletics[0] ?? null) === 's') {
                        echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_result" value="AR U20';
                        if (count($newathletics) > 1) {
                            echo ' 외 ' . (count($newathletics) - 1) . '개';
                        }
                        echo '" maxlength="100" ath="' . $id['athlete_name'] . '" sports=' . $id['schedule_sports'] . ' schedule_id="' . $s_id . '" readonly/></td>';
                    } else if (($newathletics[0] ?? null) === 'c') {
                        echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_result" value="CR';
                        if (count($newathletics) > 1) {
                            echo ' 외 ' . (count($newathletics) - 1) . '개';
                        }
                        echo '" maxlength="100" ath="' . $id['athlete_name'] . '" sports=' . $id['schedule_sports'] . ' schedule_id="' . $s_id . '" readonly/></td>';
                    } else {
                        echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_result" value="" maxlength="100" ath="' . $id['athlete_name'] . '" sports=' . $id['schedule_sports'] . ' schedule_id="' . $s_id . '" readonly/></td>';
                    }
                    // } else {
                    // echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_result" value="" maxlength="100" ath="' . $id['athlete_name'] . '" sports=' . $id['schedule_sports'] . ' schedule_id="' . $s_id . '" readonly/></td>';
                    // }
                    echo '<td><input type="text" placeholder ="비고"name="bigo[]" class="input_result" value="' .
                        ($id["record_memo"] ?? null) .
                        '" maxlength="100" /></td>';
                    $i = 1;
                    $count++;
                }
                ?>
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