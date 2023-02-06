<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../fontawesome/css/all.min.css" />
    <script src="..//fontawesome/js/all.min.js"></script>
    <!--Data Tables-->
    <link rel="stylesheet" type="text/css" href="../DataTables/datatables.min.css" />
    <script type="text/javascript" src="../DataTables/datatables.min.js"></script>
    <script type="text/javascript" src="../js/useDataTables.js"></script>
    <script type="text/javascript" src="../js/onlynumber.js"></script>
    <title>U20</title>
</head>

<body>
    <?php
    $id=$_GET['id'];
    include_once "../database/dbconnect.php"; //B:데이터베이스 연결
    $sql =
      "SELECT DISTINCT judge_name,schedule_round,schedule_status,schedule_sports FROM list_judge JOIN list_record ON judge_id = record_judge INNER JOIN list_schedule ON schedule_id= record_schedule_id AND schedule_id = '$id'";
    $result = $db->query($sql);
    $rows = mysqli_fetch_assoc($result);
    ?>
    <!-- contents 본문 내용 -->
    <div class="container">
        <!-- class="contents something" -->
        <div class="something" style="padding: 100px 15px 60px 15px">
            <form method="post" class="form">
                <h3 style="width:45%; display:inline-block; margin-right: 4.6%;">경기 이름</h3>
                <h3 style="width:50%; display:inline-block;">라운드</h3>
                <div class="input_row" style="width:45%; margin-right: 4.6%;">
                    <input placeholder="경기 이름" type="text" name="gamename" class="input_text" value="높이뛰기"
                        maxlength="16" required="" readonly />
                </div>
                <div class="input_row" style="width:50%;">
                    <?php echo '<input placeholder="라운드" type="text" name="round" class="input_text" value="' .
                      $rows["schedule_round"] .
                      '"
                    maxlength="16" required="" readonly />'; ?>
                </div>
                <h3>심판 이름</h3>
                <div class="input_row">
                    <?php echo '<input placeholder="심판 이름" type="text" name="refereename" class="input_text" value="' .
                      $rows["judge_name"] .
                      '"
                    maxlength="30" required="" readonly />'; ?>
                </div>
                <div class="btn_base base_mar" style="display:inline">
                    <h2 style="margin-bottom: 10px; float:left; margin-right: 30px;">결과</h2>
                    <?php 
                    if ($rows["schedule_status"] === "y") {
                    echo' <div class="btn_base base_mar col_left">
                        <input type="button" onclick="" class="btn_excel bold" value="엑셀 출력" />
                    </div>
                    <button type="submit" class="btn_add bold" formaction="pdfout5.php"><span>PDF 출력</span></button>';
                    }
                    ?>
                </div>
                <table cellspacing="0" cellpadding="0" class="team_table" style="border-top: 0px">
                    <colgroup>
                        <col style="width: 5%" />
                        <col style="width: 5%" />
                        <col style="width: 14%" />
                        <col style="width: 5%" />
                        <col style="width: 5%" />
                        <col style="width: 5%" />
                        <col style="width: 5%" />
                        <col style="width: 5%" />
                        <col style="width: 5%" />
                        <col style="width: 5%" />
                        <col style="width: 5%" />
                        <col style="width: 5%" />
                        <col style="width: 5%" />
                        <col style="width: 5%" />
                        <col style="width: 5%" />
                        <col style="width: 5%" />
                        <col style="width: 11%" />

                    </colgroup>
                    <thead>

                        <tr id="col1">
                            <th style="background: none" rowspan="2">등수</th>
                            <th style="background: none" rowspan="2">순서</th>
                            <th style="background: none" rowspan="2">이름</th>
                            <?php
                            // 높이 찾는 쿼리
                            $highresult = $db->query("SELECT DISTINCT record_live_record FROM list_record INNER JOIN list_schedule 
                                ON list_schedule.schedule_id= list_record.record_schedule_id AND list_schedule.schedule_id = '$id' limit 12");
                            $cnt1 = 0;
                            while ($highrow = mysqli_fetch_array($highresult)) {
                              echo '<th style="background: none"><input placeholder="높이" type="text" name="trial[]"
                                    class="input_trial" id="trial" value="' .
                                $highrow["record_live_record"] .
                                '" maxlength="4" 
                                    onkeyup="heightFormat(this)"></th>';
                              $cnt1++;
                            }
                            for ($j = 0; $j < 12 - $cnt1; $j++) {
                              echo '<th style="background: none"><input placeholder="높이" type="text" name="trial[]"
                                    class="input_trial" id="trial" value="" maxlength="4" 
                                    onkeyup="heightFormat(this)"></th>';
                            }
                            ?>
                            <th style="background: none" rowspan="2">기록</th>
                            <th style="background: none">비고</th>

                        </tr>
                        <tr id="col2">
                            <?php if ($cnt1 == 12) {
                              $cnt2 = 0;
                              $highresult = $db->query("SELECT DISTINCT record_live_record FROM list_record INNER JOIN list_schedule 
                                ON list_schedule.schedule_id= list_record.record_schedule_id AND list_schedule.schedule_id = '$id' limit 12,12");
                              while ($highrow = mysqli_fetch_array($highresult)) {
                                echo '<th style="background: none"><input placeholder="높이" type="text" name="trial[]"
                                    class="input_trial" id="trial" value="' .
                                  $highrow["record_live_record"] .
                                  '" maxlength="4" 
                                    onkeyup="heightFormat(this)"></th>';
                                $cnt2++;
                              }
                              for ($j = 0; $j < 12 - $cnt2; $j++) {
                                echo '<th style="background: none"><input placeholder="높이" type="text" name="trial[]"
                                    class="input_trial" id="trial" value="" maxlength="4" 
                                    onkeyup="heightFormat(this)"></th>';
                              }
                            } else {
                              for ($j = 0; $j < 12; $j++) {
                                echo '<th style="background: none"><input placeholder="높이" type="text" name="trial[]"
                                        class="input_trial" id="trial" value="" maxlength="4" 
                                        onkeyup="heightFormat(this)"></th>';
                              }
                            } ?>
                            <th style="background: none">신기록</th>
                        </tr>
                    </thead>
                    <tbody id="body">
                        <?php
                        if ($rows["schedule_status"] === "y") {
                          $order = "record_live_result";
                          $obj = "record_live_result,record_new,record_memo,athlete_id,record_live_record,";
                          $jo = "WHERE record_live_result>0";
                        } else {
                          $order = "record_order";
                          $obj = "";
                          $jo = "";
                        }
                        $result = $db->query(
                          "SELECT DISTINCT " .
                            $obj .
                            "record_order,athlete_name FROM list_record 
                            INNER JOIN list_athlete ON athlete_id = record_athlete_id 
                            INNER JOIN list_schedule ON schedule_id= record_schedule_id 
                            AND schedule_id = '28' " .
                            $jo .
                            "
                            ORDER BY " .
                            $order .
                            " ASC , record_live_record ASC"
                        );
                        $cnt = 1;
                        while ($row = mysqli_fetch_array($result)) {
                          echo '<tr id=col1 class="col1_' . $cnt . '">';
                          echo '<td rowspan="2"><input type="number" name="rank[]" class="input_text" id="rank" value="' .
                            ($row["record_live_result"] ?? null) .
                            '"min="1" max="12" required="" /></td>';
                          echo '<td rowspan="2"><input type="number" name="rain[]" class="input_text" value="' .
                            $row["record_order"] .
                            '" min="1" max="12" required="" readonly /></td>';
                          echo '<td rowspan="2" ><input placeholder="선수 이름" type="text" name="playername[]" id="name" class="input_text"
                                 value="' .
                            $row["athlete_name"] .
                            '" maxlength="30" required="" readonly/></td>';
                          $cnt3 = 1;
                          if ($rows["schedule_status"] === "y") {
                            $record = $db->query(
                              "SELECT record_trial FROM list_record
                                                INNER JOIN list_athlete ON record_athlete_id=" .
                                $row["athlete_id"] .
                                " AND athlete_id= record_athlete_id
                                                INNER JOIN list_schedule ON schedule_id= record_schedule_id
                                                AND schedule_id = '$id'
                                                ORDER BY record_live_record ASC limit 12"
                            ); //선수별 기록 찾는 쿼리
                            while ($recordrow = mysqli_fetch_array($record)) {
                              echo "<td>";
                              echo '<input placeholder="" type="text" name="gameresult' .
                                $cnt3 .
                                '[]" class="input_text" value="' .
                                $recordrow["record_trial"] .
                                '"
                              maxlength="3" onkeyup="highFormat(this)"
                              style="float: left; width: auto; padding-right: 5px" />';
                              echo "</td>";
                              $cnt3++;
                            }
                          }
                          for ($a = $cnt3; $a <= 12; $a++) {
                            //기록을 제외한 빈칸으로 생성
                            echo "<td>";
                            echo '<input placeholder="" type="text" name="gameresult' .
                              $a .
                              '[]" class="input_text" value=""
                                      maxlength="3" onkeyup="highFormat(this)"
                                      style="float: left; width: auto; padding-right: 5px" />';
                            echo "</td>";
                          }

                          //
                          echo '<td rowspan="2">';
                          echo '<input placeholder="경기 결과" id="result" type="text" name="gameresult[]" class="input_text"
                                    value="' .
                            ($row["record_live_record"] ?? null) .
                            '" maxlength="3" required=""
                                    style="float: left; width: auto; padding-right: 5px" />';
                          echo "</td>";
                          echo '<td><input placeholder="비고" type="text" name="bigo[]" class="input_text" value="' .
                            ($row["record_memo"] ?? null) .
                            '" maxlength="100" /></td>';
                          //
                          echo '<tr id=col2 class="col2_' . $cnt . '">';
                          if ($rows["schedule_status"] === "y" && $cnt3 == 12) {
                            //13번째 기록부터
                            $record = $db->query(
                              "SELECT record_trial,record_athlete_id FROM list_record
                                                INNER JOIN list_athlete ON record_athlete_id=" .
                                $row["athlete_id"] .
                                " AND athlete_id= record_athlete_id
                                                INNER JOIN list_schedule ON schedule_id= record_schedule_id
                                                AND schedule_id = '$id'
                                                ORDER BY record_live_record ASC limit 12,12"
                            ); //선수별 기록 찾는 쿼리
                            while ($recordrow = mysqli_fetch_array($record)) {
                              echo "<td>";
                              echo '<input placeholder="" type="text" name="gameresult' .
                                $cnt3 .
                                '[]" class="input_text" value="' .
                                $recordrow["record_trial"] .
                                '"
                              maxlength="3" onkeyup="highFormat(this)"
                              style="float: left; width: auto; padding-right: 5px" />';
                              echo "</td>";
                              $cnt3++;
                            }
                          } else {
                            $cnt3 = 13;
                          }
                          for ($a = $cnt3; $a <= 24; $a++) {
                            //기록을 제외한 빈칸으로 생성
                            echo "<td>";
                            echo '<input placeholder="" type="text" name="gameresult' .
                              $a .
                              '[]" class="input_text" value=""
                                        maxlength="3" onkeyup="highFormat(this)"
                                        style="float: left; width: auto; padding-right: 5px" />';
                            echo "</td>";
                          }
                          echo '<td>
                                      <select name="newrecord[]">
                                      <option value=' .
                            "n" .
                            '>해당없음</option>
                                    <option value=' .
                            "c" .
                            '>대회신기록</option>
                            <option value=' .
                            "a" .
                            '>아시아신기록</option>
                                    <option value=' .
                            "s" .
                            '>아시아U20신기록</option>
                                    <option value=' .
                            "u" .
                            '>세계U20신기록</option>
                            <option value=' .
                            "w" .
                            '>세계신기록</option>
                            </select>
                            </td>';
                          if (($row["record_new"]??null) == "y" && $rows["schedule_status"] === "y" ) {
                            $newrecord = $db->query(
                              "SELECT worldrecord_athletics FROM list_worldrecord WHERE worldrecord_athlete_name ='" .
                                $row["athlete_name"] .
                                "' AND worldrecord_sports='".$rows['schedule_sports']."'"
                            );
                            //추후에 태블릿용 페이지를 만든 후 일정과 연결 시 스포츠이름 받아와야함
                            $athletics = mysqli_fetch_array($newrecord);
                            echo "<script>";
                            switch ($athletics[0]) {
                              case "w":
                                echo "document.querySelectorAll('[value=\"w\"]')[$count].selected=true";
                                break;
                              case "u":
                                echo "document.querySelectorAll('[value=\"u\"]')[$count].selected=true";
                                break;
                              case "s":
                                echo "document.querySelectorAll('[value=\"s\"]')[$count].selected=true";
                                break;
                              case "a":
                                echo "document.querySelectorAll('[value=\"a\"]')[$count].selected=true";
                                break;
                              case "c":
                                echo "document.querySelectorAll('[value=\"c\"]')[$count].selected=true";
                                break;
                            }
                            echo "</script>";
                          }
                          $cnt++;
                        }
                        ?>
                        </tr>
                        </tr>
                    </tbody>
                </table>
                <h3>경기 비고</h3>
                <div class="input_row">
                    <input placeholder="비고를 입력해주세요." type="text" name="gamepass" class="input_text" value=""
                        maxlength="100" />
                </div>
                <div class="signup_submit">
                    <button type="submit" class="btn_login" name="addresult" formaction="saveresult5.php">
                        <span>확인</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>