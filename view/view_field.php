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
        <span><?php echo $weight ?></span>
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
                <th>LANE</th>
                <th>NAME</th>
                <th>1th</th>
                <th>2th</th>
                <th>3th</th>
                <th>4th</th>
                <th>5th</th>
                <th>6th</th>
                <th>FINAL RESULT</th>
                <th>RANK</th>
                <th>NEW RECORD</th>
                <th>REMARK</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $s_id = $_GET['schedule_id'];
            $sql = "SELECT DISTINCT record_weight,schedule_name,schedule_round,schedule_status FROM list_record INNER JOIN list_schedule ON schedule_id= record_schedule_id AND schedule_id = '$s_id'";
            $result = $db->query($sql);
            $rows = mysqli_fetch_assoc($result);
            if (isset($rows)) {
                $i = 1;
                $count = 0; //신기록 위치 관련 변수
                $trial = 0;
                $order = "record_order";
                $obj = "record_id,record_live_result,record_memo,athlete_id,record_live_record,record_wind,";
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
                    "SELECT * FROM list_record
                                    INNER JOIN list_athlete ON athlete_id = record_athlete_id 
                                    INNER JOIN list_schedule ON schedule_id= record_schedule_id 
                                    where $check AND schedule_id = '$s_id'
                                    ORDER BY $order ASC";
                // "SELECT DISTINCT  " .
                // $obj .
                // "record_order,athlete_name,record_new,schedule_sports  FROM list_record
                //                 INNER JOIN list_athlete ON athlete_id = record_athlete_id 
                //                 INNER JOIN list_schedule ON schedule_id= record_schedule_id 
                //                 where $check AND schedule_id = '$s_id'
                //                 ORDER BY $order ASC";
                $result2 = $db->query($sql2);
                while ($id = mysqli_fetch_array($result2)) {
                    echo '<tr>';
                    // LANE
                    echo '<td>' . $id['record_order'] . '</td>';
                    // NAME
                    echo '<td>' . $id['athlete_name'] . '</td>';
                    // 'n'th TRIAL
                    if ($_POST["check"] ?? null >= 3 || $rows["schedule_status"] === "y") {
                        $answer = $db->query("SELECT record_live_record FROM list_record join list_athlete ON athlete_id = record_athlete_id where record_athlete_id = '" . $id['athlete_id'] . "' AND record_schedule_id = '$s_id' ORDER BY record_trial ASC");
                        while ($row = mysqli_fetch_array($answer)) {
                            echo '<td>';
                            echo ($row['record_live_record'] ?? null);
                            echo '</td>';
                            $i++;
                        }
                    }
                    for ($j = $i; $j <= 6; $j++) {
                        echo "<td>";
                        // echo $j;
                        echo "</td>";
                    }
                    // FINAL RESULT
                    echo '<td>';
                    echo ($id["record_live_record"] ?? null);
                    echo '</td>';
                    // RANK
                    echo '<td>' . ($id['record_live_result'] ?? null) . '</td>';
                    // NEW RECORD
                    if ($id['record_new'] == 'y') {
                        echo '<td>' . getNewRecord($id['athlete_name'], $match_info_array[0]['schedule_sports']) . '</td>';
                    } else {
                        echo '<td>-</td>';
                    }
                    // 경기 비고
                    if ($is_not_official_status) {
                        $placeholder = trim($id["record_memo"]);
                        if (!(strlen($placeholder) > 0)) {
                            $placeholder = "-";
                        }
                        echo "<td><a href='view_input_remark.php?remark_category=result&record_id=" . trim($id["record_id"]) . "'>" . $placeholder . "</a></td>";
                    } else {
                        echo "<td>" . trim($id["record_memo"]) . "</td>";
                    }
                    echo "</tr>";

                    $i = 1;
                    $count++;
                }
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