<?php
// 경기 상태에 따른 경기 결과 처리 모델
include_once(__DIR__ . "/../model/model_result_by_state.php");
include_once(__DIR__ . "/../model/model_match_info_by_state.php");
// $id : 스케줄 id
$sports_category = trim($_GET["sports_category"]);
$schedule_id = trim($_GET["schedule_id"]);
$result_array = getResultByState($schedule_id);
$match_info_array = getMatchInfoByState($schedule_id);

echo '<div class="table-wrap">';
echo '<table>';
echo '<colgroup>';
echo '<col style="width: auto" />';
echo '</colgroup>';
echo '<thead>';
echo '<tr>';
echo '<th>레인번호</th>';
echo '<th>선수명(팀명)</th>';
echo '<th>성별</th>';
echo '<th>국가</th>';
echo '<th>소속</th>';
echo '<th>기록</th>';
echo '<th>순위</th>';
echo '<th>통과</th>';
echo '<th>상태</th>';
echo '<th>입력</th>';
echo '<th>비고</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';
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
