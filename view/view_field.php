<?php
// 경기 상태에 따른 경기 결과 처리 모델
include_once(__DIR__ . "/../model/model_result_by_state.php");
include_once(__DIR__ . "/../model/model_match_info_by_state.php");
// $id : 스케줄 id
$sports_category = trim($_GET["sports_category"]);
$schedule_id = trim($_GET["schedule_id"]);
$result_array = getResultByState($schedule_id);
$match_info_array = getMatchInfoByState($schedule_id);
?>

<h3 class="intro">WEIGHT</h3>
<div class="input_row">
    <span>용기구 KG</span>>
</div>

<div class="table-wrap">
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
                <th>PASS</th>
                <th>RANK</th>
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
                // 선수 성별
                echo "<td>" . $result["athlete_gender"] . "</td>";
                // 국가
                echo "<td>" . $result["athlete_country"] . "</td>";
                // 소속
                echo "<td>" . $result["athlete_division"] . "</td>";
                // 기록
                echo "<td>" . $result["record_record"] . "</td>";
                // 순위
                echo "<td>" . $result["record_result"] . "</td>";
                // 통과
                echo "<td>" . $result["record_pass"] . "</td>";
                // 경기 상태(Official, Result..)
                echo "<td>" . $result["record_status"] . "</td>";
                if (trim($result["record_id"]) != "") {
                    // 경기 결과 입력
                    echo "<td><a href='view_input_result.php?result_id=" . trim($result["record_id"]) . "'>결과 입력</a></td>";
                    // 경기 비고
                    echo "<td><a href='view_input_remark.php?remark_category=result&result_id=" . trim($result["record_id"]) . "'>비고 입력</a></td>";
                } else {
                    echo "<td></td>";
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
            if (trim($result["record_id"]) != "") {
                echo
                "<button type=\"button\" class=\"btn_navy btn_update\" 
                    onclick=\"'view_input_result.php
                    ?result_category=field
                    &record_id=" . trim($result["record_id"]) . "'>";
            } ?>
            <span class=" bold">UPDATE</span>
            </button>
        </div>
    </div>
</div>