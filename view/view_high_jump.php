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
        <thead>
            <!-- 윗 부분 : 레인,이름,높이(기록),통과,등수 -->
            <tr id="col1">
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
                <th rowspan="2">RANK</th>
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
                        echo '<th style="background: none"><input placeholder="높이" type="text" name="trial[]"
						class="input_trial" id="trial" value="" maxlength="4" 
						onkeyup="heightFormat(this)"></th>';
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
                echo "<td>" . $result["record_wind"] . "</td>";
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
            echo "<a href='view_input_result.php?sports_category=high_jump&schedule_id=" . trim($s_id) . "' class=\"btn_navy a_button\">UPDATE</a>";
            ?>
            </button>
        </div>
    </div>
</div>