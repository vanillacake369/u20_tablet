<?php
// 경기 상태에 따른 경기 결과 처리 모델
include(__DIR__ . "/../database/dbconnect.php");
include_once(__DIR__ . "/../model/model_result_by_state.php");
include_once(__DIR__ . "/../model/model_match_info_by_state.php");
include_once(__DIR__ . "/module_change_state.php");
// $id : 스케줄 id
$sports_category = trim($_GET["sports_category"]);
$schedule_id = trim($_GET["schedule_id"]);
$result_array = getResultByState($schedule_id);
$match_info_array = getMatchInfoByState($schedule_id);
$weight = "";
if (isset($result_array[0])) {
    $weight = $result_array[0]["record_weight"];
}
$is_not_official_status = (trim($match_info_array[0]["schedule_result"]) != "o");
?>
<div class="table-wrap">
    <h3 class="intro">WEIGHT</h3>
    <div class="input_row">
        <input placeholder="WEIGHT" type="text" name="wind" class="input_text" value="<?php echo $weight; ?>" maxlength="16" required="" readonly>
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
            <col class="col_view_pass">
            <col class="col_view_rank">
            <col class="col_view_new_record">
            <col class="col_view_remark">
        </colgroup>
        <thead>
            <tr>
                <th>LANE</th>
                <th>NAME</th>
                <th>1th</th>
                <th>2th</th>
                <th>3th</th>
                <th>4th</th>
                <th>5th</th>
                <th>6th</th>
                <th>RANK</th>
                <th>PASS</th>
                <th>NEW RECORD</th>
                <th>REMARK</th>
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
                // 1th
                // 2th
                // 3th
                // 4th
                // 5th
                // 6th
                // 순위
                echo "<td>" . $result["record_result"] . "</td>";
                // 통과
                echo "<td>" . $result["record_pass"] . "</td>";
                // 신기록
                echo "<td>" . $result["record_new"] . "</td>";
                // 경기 상태(Official, Result..)
                echo "<td>" . $result["record_status"] . "</td>";
                // 경기 비고 : official이 아니라면 입력 제한
                if ($is_not_official_status) {
                    $placeholder = trim($result["record_memo"]);
                    if (!(strlen($placeholder) > 0)) {
                        $placeholder = "-";
                    }
                    echo "<td><a href='view_input_remark.php?remark_category=result&record_id=" . trim($result["record_id"]) . "'>" . $placeholder . "</a></td>";
                } else {
                    echo "<td>" . trim($result["record_memo"]) . "</td>";
                }
                echo "</tr>";
            }

            ?>
        </tbody>
    </table>
    <?php
    if ($is_not_official_status) {
        echo '<div class="container_postbtn">';
        echo '<div class="postbtn_like">';
        echo '<div class="like_btn">';
        echo "<a href='view_input_result.php?sports_category=field&schedule_id=" . trim($schedule_id) . "' class=\"btn_navy a_button\">UPDATE</a>";
        echo '</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    ?>
</div>