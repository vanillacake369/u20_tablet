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

<div class="table-wrap">
    <table>
        <colgroup>
            <col style="width: auto" />
        </colgroup>
        <thead>
            <tr>
                <th>레인번호</th>
                <th>선수명(팀명)</th>
                <th>성별</th>
                <th>국가</th>
                <th>소속</th>
                <th>기록</th>
                <th>순위</th>
                <th>통과</th>
                <th>상태</th>
                <th>입력</th>
                <th>비고</th>
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
            <button type="submit" class="btn_navy btn_update" name="done">
                <span class="bold">확인</span>
            </button>
        </div>
    </div>
</div>