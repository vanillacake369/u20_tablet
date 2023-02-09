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
<<<<<<< HEAD
                    <h2 class="intro">경기 일정</h2>
=======
                    <h1 class="intro">MATCHES</h1>
>>>>>>> 40b877c28ec6980c980b0272fcbe6fd00ea2d6f1
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
                            <col class="col_match_division">
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
                                <th>DIVISION</th>
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
<<<<<<< HEAD
                                echo "<td>" . trim($schedule["schedule_name"]) . "</td>";
=======
                                echo "<td>" . trim(strtoupper($schedule["schedule_sports"])) . "</td>";
>>>>>>> 40b877c28ec6980c980b0272fcbe6fd00ea2d6f1
                                // 선수 성별
                                echo "<td>" . trim($schedule["schedule_gender"]) . "</td>";
                                // 라운드
                                echo "<td>" . trim($schedule["schedule_round"]) . "</td>";
                                // 경기 참가조
                                echo "<td>" . trim($schedule["schedule_group"]) . "</td>";
                                // 경기 분류
                                echo "<td>" . trim($schedule["schedule_division"]) . "</td>";
                                // 경기 장소
                                echo "<td>" . trim($schedule["schedule_location"]) . "</td>";
                                // 시작날짜 & 시작 시간 구하기
                                $date_time = explode(" ", $schedule["schedule_start"]);
                                $time = $date_time[1];
                                $date = $date_time[0];
                                // 경기 시작일
                                echo "<td>" . trim($date) . "</td>";
                                // 경기 시작시간
                                echo "<td>" . trim($time) . "</td>";
                                // 경기 상태(Official, Result..)
                                echo "<td>" . trim($schedule["schedule_result"]) . "</td>";
<<<<<<< HEAD
                                // 경기 결과 입력
=======
                                // 경기 결과 보기
>>>>>>> 40b877c28ec6980c980b0272fcbe6fd00ea2d6f1
                                $schedule_sports = $schedule["schedule_sports"];
                                $schedule_id = $schedule["schedule_id"];
                                if ($schedule["schedule_sports"] == "decathlon" || $schedule["schedule_sports"] == "heptathlon") {
                                    // 종합 경기는 라운드 ==> 경기한글명 =(치환)=> 경기코드
                                    $schedule_sports = $schedule["schedule_round"];
                                    $schedule_sports = array_search($schedule["schedule_round"], $sports_code_dic);
                                }
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