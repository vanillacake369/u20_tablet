<?php
// header
include_once(__DIR__ .  '/header.php');
// 경기 스케줄 가져오기
include_once(__DIR__ . "/../model/model_schedule.php");

// model_schedule_by_state에서 결과 가져오기
$judge_account = trim($_SESSION["Id"]);
$schedule_array = getScheduleByState($id);
?>

<div class="limiter">
    <div class="container-table100">
        <div class="wrap-table100">
            <div class="table-wrap">
                <table>
                    <colgroup>
                        <col style="width: auto" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th>번호</th>
                            <th>경기명</th>
                            <th>선수 성별</th>
                            <th>라운드</th>
                            <th>조</th>
                            <th>분류</th>
                            <th>장소</th>
                            <th>시작날짜</th>
                            <th>시작시간</th>
                            <th>상태</th>
                            <th>보기</th>
                            <th>비고</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $num = 0;
                        foreach ($schedule_array as $schedule) {
                            echo "<tr>";

                            // 번호
                            echo "<td>" . ++$num . "</td>";
                            // 경기 이름
                            echo "<td>" . $schedule["schedule_name"] . "</td>";
                            // 선수 성별
                            echo "<td>" . $schedule["schedule_gender"] . "</td>";
                            // 라운드
                            echo "<td>" . $schedule["schedule_round"] . "</td>";
                            // 경기 참가조
                            echo "<td>" . $schedule["schedule_group"] . "</td>";
                            // 경기 분류
                            echo "<td>" . $schedule["schedule_division"] . "</td>";
                            // 경기 장소
                            echo "<td>" . $schedule["schedule_location"] . "</td>";
                            // 경기 시작일
                            echo "<td>" . $schedule["schedule_date"] . "</td>";
                            // 경기 시작시간
                            echo "<td>" . $schedule["schedule_start"] . "</td>";
                            // 경기 상태(Official, Result..)
                            echo "<td>" . $schedule["schedule_result"] . "</td>";
                            // 경기 결과 입력
                            echo "<td><a href='/../controller_result.php?id=" . trim($schedule["schedule_id"]) . "'>결과 보기</a></td>";
                            // 경기 비고
                            echo "<td><a href='/../controller_input_remark.php?remark_category=schedule&id=" . trim($schedule["schedule_id"]) . "'>비고 보기</a></td>";

                            echo "</tr>";
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="vendor/bootstrap/js/popper.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/select2/select2.min.js"></script>
<script src="js/main.js"></script>