<?php
// 경기 상태에 따른 경기 결과 처리 모델
include_once(__DIR__ . "/../model/model_result_by_state.php");
include_once(__DIR__ . "/../model/model_match_info_by_state.php");
include_once(__DIR__ . "/module_change_state.php");
// $id : 스케줄 id
$sports_category = trim($_GET["sports_category"]);
$schedule_id = trim($_GET["schedule_id"]);
$result_array = getResultByState($schedule_id);
$match_info_array = getMatchInfoByState($schedule_id);
$wind = "";
if (isset($result_array[0])) {
    $wind = $result_array[0]["record_wind"];
}
$is_not_official_status = (trim($match_info_array[0]["schedule_result"]) != "o");
?>


<div class="table-wrap">
    <h3 class="intro">WIND</h3>
    <div class="input_row">
        <input placeholder="WIND" type="text" name="wind" class="input_text" value="<?php echo $wind ?>" maxlength="16" required="" readonly>
    </div>
    <h3 class="intro">RESULT</h3>
    <table>
        <colgroup>
            <col class="col_view_lane">
            <col class="col_view_name">
            <col class="col_view_gender">
            <col class="col_view_nation">
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
            $remark_link = "";
            foreach ($result_array as $result) {
                $placeholder = trim($result["record_memo"]);
                if (!(strlen($placeholder) > 0)) {
                    $placeholder = "-";
                }

                if ($count % 4 == 0) {
                    echo "<tr>";
                    // 레인번호
                    echo "<td>" . $result["record_order"] . "</td>";
                    echo "<td>";
                }
                if ($count % 4 == 3) {
                    // 선수명(팀명)
                    echo $result["athlete_name"] . "</td>";
                    // 선수 성별
                    echo "<td>" . $result["athlete_gender"] . "</td>";
                    // 국가
                    echo "<td>" . $result["athlete_country"] . "</td>";
                    // 기록
                    echo "<td>" . $result["record_record"] . "</td>";
                    // 순위
                    echo "<td>" . $result["record_result"] . "</td>";
                    // 통과
                    echo "<td>" . $result["record_pass"] . "</td>";
                    // 신기록
                    if (trim($result['record_new']) == 'y') {
                        echo '<td>' . getNewRecord($result['athlete_country'], $match_info_array[0]['schedule_sports']) . '</td>';
                    } else {
                        echo '<td>-</td>';
                    }
                    // 경기 상태(Official, Result..)
                    echo "<td>" . $result["record_status"] . "</td>";
                    // 경기 비고
                    if ($is_not_official_status) {
                        $remark_link = $remark_link . "<a href='view_input_remark.php?remark_category=result&record_id=" . trim($result["record_id"]) . "'>" . $placeholder . "</a><br>";
                        echo "<td>$remark_link</td>";
                        $remark_link = "";
                    } else {
                        echo "<td></td>";
                    }
                    echo "</tr>";
                } else {
                    // 선수명(팀명)
                    echo $result["athlete_name"] . "<br>";
                    $remark_link = $remark_link . "<a href='view_input_remark.php?remark_category=result&record_id=" . trim($result["record_id"]) . "'>" . $placeholder . "</a><br>";
                }
                $count++;
            }

            ?>
        </tbody>
    </table>
    <?php
    if ($is_not_official_status) {
        echo '<div class="container_postbtn">';
        echo '<div class="postbtn_like">';
        echo '<div class="like_btn">';
        echo "<a href='view_input_result.php?sports_category=relay&schedule_id=" . trim($schedule_id) . "' class=\"btn_navy a_button\">UPDATE</a>";
        echo '</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    ?>
</div>