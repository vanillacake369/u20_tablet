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

<body>
    <?php
    // header
    include_once(__DIR__ . "/view_header.php");

    // use match result model
    include_once(__DIR__ . "/../model/model_result_by_state.php");
    include_once(__DIR__ . "/../model/model_match_info_by_state.php");

    // $id : 스케줄 id
    // $id = trim($_GET["schedule_id"]);
    // $result_array = getResultByState($id);
    // $match_info_array = getMatchInfoByState($id);
    ?>

    <?php
    $id = $_GET['id'];
    include_once "../database/dbconnect.php"; //B:데이터베이스 연결
    $sql = "SELECT DISTINCT judge_name,schedule_round,schedule_status,record_wind,schedule_sports FROM list_judge JOIN list_record ON judge_id = record_judge INNER JOIN list_schedule ON schedule_id= record_schedule_id AND schedule_id = '" . $id . "'";
    $result = $db->query($sql);
    $rows = mysqli_fetch_assoc($result);
    ?>
    <!-- contents 본문 내용 -->
    <div class="container">
        <!-- class="contents something" -->
        <div class="something" style="padding: 100px 15px 60px 15px">
            <form action="sendResult2.php" method="post" class="form">
                <h3 style="width:45%; display:inline-block; margin-right: 4.6%;">경기 이름</h3>
                <h3 style="width:48%; display:inline-block;">라운드</h3>
                <div class="input_row" style="width:45%; margin-right: 4.6%;">
                    <input placeholder="경기 이름" type="text" name="gamename" class="input_text" value="4x400mR" maxlength="16" required="" readonly />
                </div>
                <div class="input_row" style="width:48%;">
                    <?php
                    echo '<input placeholder="라운드" type="text" name="round" class="input_text" value="' . $rows['schedule_round'] . '"
                    maxlength="16" required="" readonly />';
                    ?>
                </div>
                <h3 style="width:45%; display:inline-block; margin-right: 4.6%;">심판 이름</h3>
                <h3 style="width:48%;  display:inline-block;">풍속</h3>
                <div class="input_row" style="width:45%; margin-right: 4.6%;">
                    <input placeholder="심판 이름" type="text" name="refereename" class="input_text" value="권 산" maxlength="30" required="" readonly />
                </div>
                <div class="input_row" style="width:48%;">
                    <?php
                    if ($rows['schedule_status'] === 'y') {
                        echo '<input placeholder="풍속을 입력해주세요." type="text" name="wind" class="input_text" value="' . $rows['record_wind'] . '" maxlength="16"
                            required="" />';
                    } else {

                        echo '<input placeholder="풍속을 입력해주세요." type="text" name="wind" class="input_text" value="" maxlength="16"
                            required="" />';
                    }
                    ?>
                </div>
                <div class="btn_base base_mar" style="display:inline-flex; align-items: baseline;">
                    <h2 style="margin-bottom: 10px; float:left; margin-right: 30px;">결과</h2>
                    <?php
                    if ($rows['schedule_status'] != 'y') {
                        echo '<input type="button" onclick="openTextFile()" class="btn_add bold" value="자동 입력"
                        style="margin-right:15px;">';
                    } else {
                        echo ' <div class="btn_base base_mar col_left">
                            <input type="button" onclick="" class="btn_excel bold" value="엑셀 출력" />
                        </div>
                        <button type="submit" class="btn_add bold" formaction="pdfout2.php"><span>PDF 출력</span></button>';
                    }
                    ?>
                </div>
                <table cellspacing="0" cellpadding="0" class="team_table" style="border-top: 0px">
                    <colgroup>
                        <col style="width: 7%" />
                        <col style="width: 7%" />
                        <col style="width: 26%" />
                        <col style="width: 7%" />
                        <col style="width: 10%" />
                        <col style="width: 15%" />
                        <col style="width: 10%" />
                        <col style="width: 20%" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th style="background: none">등수</th>
                            <th style="background: none">레인</th>
                            <th style="background: none">이름</th>
                            <th style="background: none">국가</th>
                            <th style="background: none">통과 여부</th>
                            <th style="background: none">경기 결과</th>
                            <th style="background: none">비고</th>
                            <th style="background: none">신기록</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 0;
                        $relm = 'athlete_name,athlete_country,record_live_result,record_live_record,record_pass,record_memo,record_new,athlete_name, record_order';
                        if ($rows['schedule_status'] == 'y') {
                            $order = 'record_live_result';
                        } else {
                            $order = 'record_order';
                        }
                        $sql = "SELECT  " . $relm . " FROM list_record 
                        INNER JOIN list_athlete ON athlete_id = record_athlete_id 
                        INNER JOIN list_schedule ON schedule_id= record_schedule_id AND schedule_id = '$id' 
                        ORDER BY " . $order . " ASC,athlete_name ASC ";
                        $result = $db->query($sql);
                        $count = 0;
                        $cnt = 0;
                        $athrecord = array();
                        while ($row = mysqli_fetch_array($result)) {
                            $athrecord[$count % 4] = $row['record_live_record'];
                            if ($count % 4 == 0) {
                                echo '<tr id="rane' . $row['record_order'] . '">';
                                echo '<td><input type="number" name="rank[]" id="rank" class="input_text" value="' . $row['record_live_result'] . '" min="1" max="12" required="" /></td>';
                                echo '<td><input type="number" name="rain[]" class="input_text" value="' . $row['record_order'] . '" min="1" max="12" required="" readonly /></td>';
                                echo '<td>';
                            }
                            if ($count % 4 == 3) {
                                echo '<input placeholder="선수 이름" type="text" name="playername[]"
                                class="input_text" value="' . $row['athlete_name'] . '" maxlength="30" required="" readonly/></td>';
                                echo '<td><input placeholder="소속" type="text" name="division" class="input_text" value="' . $row['athlete_country'] . '"maxlength="50" required="" readonly/></td>';
                                echo '<td><input placeholder="경기 통과 여부" type="text" name="gamepass[]" class="input_text" value="' . $row['record_pass'] . '" maxlength="1" required="" /></td>';
                                echo '<td>
                            <input placeholder="경기 결과" type="text" name="gameresult[]" id="result" class="input_text"
                                value="' . ($athrecord[3] ? $athrecord[3] : 0) . '" maxlength="8" required="" onkeyup="trackFinal(this)"
                                    style="float: left; width: 80px; padding-right: 5px" readonly/>
                                </div>
                                </div></td>';
                                echo '<td><input placeholder="비고" type="text" name="bigo[]" class="input_text" value="" maxlength="100" /></td>';
                                if ($row['record_new'] == 'y') {
                                    $newrecord = $db->query("SELECT worldrecord_athletics FROM list_worldrecord WHERE worldrecord_athlete_name ='" . $row['athlete_name'] . "' AND worldrecord_sports='" . $rows['schedule_sports'] . "'");
                                    //추후에 태블릿용 페이지를 만든 후 일정과 연결 시 스포츠이름 받아와야함
                                    $sql1 = "SELECT worldrecord_athletics FROM list_worldrecord WHERE worldrecord_athlete_name ='" . $row['athlete_name'] . "' AND worldrecord_sports='" . $rows['schedule_sports'] . "'";
                                    $newathletics = array();
                                    while ($athletics = mysqli_fetch_array($newrecord)) {
                                        $newathletics[] = $athletics[0];
                                    }
                                    switch (($newathletics[0] ?? null)) {
                                        case 'w':
                                            echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_text" value="세계신기록';
                                            if (count($newathletics) > 1) {
                                                echo ' 외 ' . (count($newathletics) - 1) . '개';
                                            }
                                            echo '" maxlength="100" ath="' . $row['athlete_country'] . '" sports=' . $rows['schedule_sports'] . ' readonly/></td>';
                                            break;
                                        case 'u':
                                            echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_text" value="세계U20신기록';
                                            if (count($newathletics) > 1) {
                                                echo ' 외 ' . (count($newathletics) - 1) . '개';
                                            }
                                            echo '" maxlength="100" ath="' . $row['athlete_country'] . '" sports=' . $rows['schedule_sports'] . ' readonly/></td>';
                                            break;
                                        case 'a':
                                            echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_text" value="아시아신기록';
                                            if (count($newathletics) > 1) {
                                                echo ' 외 ' . (count($newathletics) - 1) . '개';
                                            }
                                            echo '" maxlength="100" ath="' . $row['athlete_country'] . '" sports=' . $rows['schedule_sports'] . ' readonly/></td>';
                                            break;
                                        case 's':
                                            echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_text" value="아시아U20신기록';
                                            if (count($newathletics) > 1) {
                                                echo ' 외 ' . (count($newathletics) - 1) . '개';
                                            }
                                            echo '" maxlength="100" ath="' . $row['athlete_country'] . '" sports=' . $rows['schedule_sports'] . ' readonly/></td>';
                                            break;
                                        case 'c':
                                            echo '<td<input placeholder="" type="text" name="newrecord[]" class="input_text" value=">대회신기록';
                                            if (count($newathletics) > 1) {
                                                echo ' 외 ' . (count($newathletics) - 1) . '개';
                                            }
                                            echo '" maxlength="100" ath="' . $row['athlete_country'] . '" sports=' . $rows['schedule_sports'] . ' readonly/></td>';
                                            break;
                                        default:
                                            echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_text" value="" maxlength="100" ath="' . $row['athlete_country'] . '" sports=' . $rows['schedule_sports'] . ' readonly/></td>';
                                            break;
                                    }
                                } else {
                                    echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_text" value="" maxlength="100" ath="' . $row['athlete_country'] . '" sports=' . $rows['schedule_sports'] . ' readonly/></td>';
                                }
                                $cnt++;
                            } else {
                                echo '<input placeholder="선수 이름" type="text" name="playername[]"
                                class="input_text" value="' . $row['athlete_country'] . '" maxlength="30" required="" readonly style="margin-bottom: 10px;"/>';
                            }
                            $count++;
                        }
                        ?>
                    </tbody>
                </table>
                <h3>경기 비고</h3>
                <div class="input_row">
                    <input placeholder="비고를 입력해주세요." type="text" name="bibigo" class="input_text" value="" maxlength="100" />
                </div>
                <div class="signup_submit">
                    <button type="submit" class="btn_login" name="addresult">
                        <span>확인</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>