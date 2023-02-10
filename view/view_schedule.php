<?php
// 접근 제한 컨트롤러 :: 공통
include_once(__DIR__ .  "/view_block.php");
?>

<!-- head 태그에 각 컨트롤러가 직접 추가할 수 있도록 head를 따로 독립 -->

<head>
    <?php
    include_once(__DIR__ .  "/head.php");
    ?>
</head>

<!-- body 태그에 각 컨트롤러가 직접 추가할 수 있도록 body 따로 독립 -->

<body>
    <?php
    // header
    include_once(__DIR__ .  '/view_header.php');

    // 경기 스케줄 가져오기
    include_once(__DIR__ . "/../model/model_schedule_by_state.php");
    // 번역 딕셔너리 사용
    include_once(__DIR__ . "/../model/dictionary.php");
    // 경기 종목에 따른 결과 보기 페이지 지정
    include_once(__DIR__ . "/view_result_config.php");

    // model_schedule_by_state에서 결과 가져오기
    $judge_account = trim($_SESSION["Id"]);
    $schedule_array = getScheduleByState($judge_account);
    ?>

    <div class="limiter">
        <div class="container-table100">
            <div class="wrap-table100">
                <div class="table-wrap">
                    <h1 class="intro">MATCHES</h1>
                    <table>
                        <!-- <colgroup>
                            <col style="width: auto" />
                        </colgroup> -->
                        <colgroup>
                            <col class="col_number">
                            <col class="col_match_name">
                            <col class="col_match_gender">
                            <col class="col_match_round">
                            <col class="col_match_group">
                            <col class="col_match_place">
                            <col class="col_match_date">
                            <col class="col_match_time">
                            <col class="col_match_state">
                            <col class="col_match_view">
                            <col class="col_match_memo">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>MATCH</th>
                                <th>GENDER</th>
                                <th>ROUND</th>
                                <th>GROUP</th>
                                <th>PLACE</th>
                                <th>DATE</th>
                                <th>TIME</th>
                                <th>STATUS</th>
                                <th>RESULT</th>
                                <th>REMARK</th>
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
                                echo "<td>" . $schedule["schedule_match"] . "</td>";
                                // 선수 성별
                                echo "<td>" . $schedule["schedule_gender"] . "</td>";
                                // 라운드
                                echo "<td>" . $schedule["schedule_round"] . "</td>";
                                // 경기 참가조
                                echo "<td>" . $schedule["schedule_group"] . "</td>";
                                // 경기 장소
                                echo "<td>" . $schedule["schedule_location"] . "</td>";
                                // 경기 시작일
                                echo "<td>" . $schedule["schedule_date"]  . "</td>";
                                // 경기 시작시간
                                echo "<td>" . $schedule["schedule_time"] . "</td>";
                                // 경기 상태(Official, Result..)
                                echo "<td>" . $schedule["schedule_result"] . "</td>";
                                // 경기 결과 보기
                                $schedule_sports = $schedule["schedule_sports"];
                                $schedule_id = $schedule["schedule_id"];
                                echo getResultLink($schedule_sports, $schedule_id);
                                // 경기 비고
                                echo "<td><a href='view_input_remark.php?remark_category=schedule&schedule_id=" . trim($schedule["schedule_id"]) . "'>" . trim($schedule["schedule_memo"]) . "</a></td>";
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
</body>

</html>