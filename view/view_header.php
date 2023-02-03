<?php
// 경기 스케줄 가져오기
include_once(__DIR__ . "/../model/model_schedule_by_state.php");

// model_header.php 에서 결과 가져오기
$judge_account = trim($_SESSION["Id"]);
$schedule_array = getScheduleByState($judge_account);
?>

<header>
    <div>
        <ul class="navbar">
            <li class="logo">
                <a href="view_schedule.php"><img src="../img/logo.png
                " alt="Logo" class="logo_img" /></a>
            </li>
        </ul>
        <ul class="navbar">
            <li class="logo">
                <a href="view_schedule.php">경기 스케줄</a>
            </li>
            <?php
            // 경기 결과 입력
            foreach ($schedule_array as $schedule) {
                // Ex) 100m 남자 결승 1조 결과
                $sports = trim($schedule["schedule_name"]);
                $gender = trim($schedule["schedule_gender"]);
                if ($gender == 'm') {
                    $gender = '남성';
                } else if ($gender == 'f') {
                    $gender = '여성';
                } else {
                    $gender = '혼성';
                }
                $round = trim($schedule["schedule_round"]);
                $group = trim($schedule["schedule_group"]) . "조";
                $link_name = $sports . $gender . $round . $group . " " .  "결과";
                echo '<li class="logo">';
                echo "<a href='view_result.php?id=" . trim($schedule["schedule_id"]) . "'>$link_name</a>";
                echo '</li>';
                echo "<td></td>";
            }

            ?>
        </ul>
    </div>
</header>