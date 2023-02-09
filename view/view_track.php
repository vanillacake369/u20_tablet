<?php
// 경기 상태에 따른 경기 결과 처리 모델
include_once(__DIR__ . "/../model/model_result_by_state.php");
include_once(__DIR__ . "/../model/model_match_info_by_state.php");
// $id : 스케줄 id
$sports_category = trim($_GET["sports_category"]);
$schedule_id = trim($_GET["schedule_id"]);
$result_array = getResultByState($schedule_id);
$match_info_array = getMatchInfoByState($schedule_id);
$wind = $result_array[0]["record_wind"];
?>

<h3 class="intro">WIND</h3>
<div class="input_row">
    <span><?php echo $wind ?></span>
</div>

<div class="table-wrap">
    <table>
        <colgroup>
            <col class="col_view_lane">
            <col class="col_view_name">
            <col class="col_view_gender">
            <col class="col_view_nation">
            <col class="col_view_team">
            <!-- <col class="col_view_wind"> -->
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
                <!-- <th>WIND</th> -->
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
<<<<<<< HEAD
            $relm = 'record_live_result,record_live_record,record_pass,record_memo,record_new,athlete_name, record_order';
            if ($rows['schedule_status'] == 'y') {
                $order = 'record_live_result';
            } else {
                $order = 'record_order';
            }
            $sql = "SELECT " . $relm . " FROM list_record 
                        INNER JOIN list_athlete ON list_athlete.athlete_id = list_record.record_athlete_id 
                        INNER JOIN list_schedule ON list_schedule.schedule_id= list_record.record_schedule_id 
                        AND list_schedule.schedule_id = '$id'
                        ORDER BY " . $order . " ASC ";
            $count = 0;
            $result = $db->query($sql);
            while ($row = mysqli_fetch_array($result)) {
                echo '<tr id="rane' . $row['record_order'] . '">';
                echo '<td><input type="number" name="rank[]" id="rank" class="input_text" value="' . trim($row['record_live_result']) . '" min="1" max="12" required="" /></td>';
                echo '<td><input type="number" name="rain[]" class="input_text" value="' . trim($row['record_order']) . '" min="1" max="12" required="" readonly /></td>';
                echo '<td><input placeholder="선수 이름" type="text" name="playername[]" 
                                class="input_text" value="' . trim($row['athlete_name']) . '" maxlength="30" required="" readonly /></td>';
                echo '<td><input placeholder="경기 통과 여부" type="text" name="gamepass[]" class="input_text" value="' . trim($row['record_pass']) . '" maxlength="50" required="" /></td>';
                echo '<td><input placeholder="경기 결과를 입력해주세요" type="text" name="gameresult[]" id="result" class="input_text" value="' . trim($row['record_live_record']) . '" maxlength="8"
                                 required="" onkeyup="trackFinal(this)" style="float: left; width: auto; padding-right: 5px" /></td>';
                echo '<td><input placeholder="비고를 입력해주세요" type="text" name="bigo[]" class="input_text" value="' . (trim($row['record_memo']) ? trim($row['record_memo']) : '&nbsp') . '" maxlength="100" /></td>';

                if ($row['record_new'] == 'y') {
                    $newrecord = $db->query("SELECT worldrecord_athletics FROM list_worldrecord WHERE worldrecord_athlete_name ='" . trim($row['athlete_name']) . "' AND worldrecord_sports='" . trim($rows['schedule_sports']) . "'");
                    //추후에 태블릿용 페이지를 만든 후 일정과 연결 시 스포츠이름 받아와야함
                    $newathletics = array();
                    while ($athletics = mysqli_fetch_array($newrecord)) {
                        $newathletics[] = $athletics[0];
                    }
                    switch (($newathletics[0] ?? null)) {
                        case 'w':
                            echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_text" value="세계신기록';
                            if (count($newathletics) > 1) {
                                echo ' 외 ' . (count($newathletics) - 1) . '개';
                            }
                            echo '" maxlength="100" ath="' . $row['athlete_name'] . '" sports=' . $rows['schedule_sports'] . ' readonly/></td>';
                            break;
                        case 'u':
                            echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_text" value="세계U20신기록';
                            if (count($newathletics) > 1) {
                                echo ' 외 ' . (count($newathletics) - 1) . '개';
                            }
                            echo '" maxlength="100" ath="' . $row['athlete_name'] . '" sports=' . $rows['schedule_sports'] . ' readonly/></td>';
                            break;
                        case 'a':
                            echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_text" value="아시아신기록';
                            if (count($newathletics) > 1) {
                                echo ' 외 ' . (count($newathletics) - 1) . '개';
                            }
                            echo '" maxlength="100" ath="' . $row['athlete_name'] . '" sports=' . $rows['schedule_sports'] . ' readonly/></td>';
                            break;
                        case 's':
                            echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_text" value="아시아U20신기록';
                            if (count($newathletics) > 1) {
                                echo ' 외 ' . (count($newathletics) - 1) . '개';
                            }
                            echo '" maxlength="100" ath="' . $row['athlete_name'] . '" sports=' . $rows['schedule_sports'] . ' readonly/></td>';
                            break;
                        case 'c':
                            echo '<td<input placeholder="" type="text" name="newrecord[]" class="input_text" value=">대회신기록';
                            if (count($newathletics) > 1) {
                                echo ' 외 ' . (count($newathletics) - 1) . '개';
                            }
                            echo '" maxlength="100" ath="' . $row['athlete_name'] . '" sports=' . $rows['schedule_sports'] . ' readonly/></td>';
                            break;
                        default:
                            echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_text" value="" maxlength="100" ath="' . $row['athlete_name'] . '" sports=' . $rows['schedule_sports'] . ' readonly/></td>';
                            break;
                    }
=======
            foreach ($result_array as $result) {
                echo "<tr>";
                // 레인번호
                echo "<td>" . $result["record_order"] . "</td>";
                // 선수명(팀명)
                echo "<td>" . $result["athlete_name"] . "</td>";
                // 선수 성별
                echo "<td>" . $result["athlete_gender"] . "</td>";
                // 국가
                echo "<td>" . $result["athlete_country"] . "</td>";
                // 소속
                echo "<td>" . $result["athlete_division"] . "</td>";
                // 풍향
                // echo "<td>" . $result["record_wind"] . "</td>";
                // 기록
                echo "<td>" . $result["record_record"] . "</td>";
                // 순위
                echo "<td>" . $result["record_result"] . "</td>";
                // 통과
                echo "<td>" . $result["record_pass"] . "</td>";
                // 신기록
                echo "<td>" . $result["record_new"] . "</td>";
                // 경기 상태(Official, Result..)
                echo "<td>" . $result["record_status"] . "</td>";
                if (trim($result["record_id"]) != "") {
                    // 경기 비고
                    echo "<td><a href='view_input_remark.php?remark_category=result&record_id=" . trim($result["record_id"]) . "'>" . trim($result["record_memo"]) . "</a></td>";
>>>>>>> 40b877c28ec6980c980b0272fcbe6fd00ea2d6f1
                } else {
                    echo "<td></td>";
                }
                echo "</tr>";
            }

            ?>
        </tbody>
    </table>
</div>

<div class="container_postbtn">
    <div class="postbtn_like">
        <div class="like_btn">
            <?php
            echo "<a href='view_input_result.php?sports_category=track&schedule_id=" . trim($schedule_id) . "' class=\"btn_navy a_button\">UPDATE</a>";
            ?>
            <span class=" bold">UPDATE</span>
            </button>
        </div>
    </div>
</div>