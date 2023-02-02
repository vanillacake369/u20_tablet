<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../fontawesome/css/all.min.css" />
    <script src="../fontawesome/js/all.min.js"></script>
    <!--Data Tables-->
    <link rel="stylesheet" type="text/css" href="../DataTables/datatables.min.css" />
    <script type="text/javascript" src="../DataTables/datatables.min.js"></script>
    <script type="text/javascript" src="../js/useDataTables.js"></script>
    <script type="text/javascript" src="../js/onlynumber.js"></script>
    <title>U20</title>
</head>

<body>
    <?php
    include_once "../database/dbconnect.php"; //B:데이터베이스 연결 
    $sql= "SELECT DISTINCT judge_name,record_weight,schedule_round,schedule_status FROM list_judge JOIN list_record ON judge_id = record_judge INNER JOIN list_schedule ON schedule_id= record_schedule_id AND schedule_id = '3'";
    $result=$db->query($sql);
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
                    <input placeholder="경기 이름" type="text" name="gamename" class="input_text" value="창던지기"
                        maxlength="16" required="" readonly />
                </div>
                <div class="input_row" style="width:50%;">
                    <?php
                    echo '<input placeholder="라운드" type="text" name="round" class="input_text" value="'.$rows['schedule_round'].'"
                    maxlength="16" required="" readonly />';
                    ?>
                </div>
                <h3>심판 이름</h3>
                <div class="input_row">
                    <?php
                echo '<input placeholder="심판 이름" type="text" name="refereename" class="input_text" value="'.$rows['judge_name'].'"
                maxlength="30" required="" readonly />';
                ?>
                </div>
                <h3>용기구</h3>
                <div class="input_row">
                    <?php
                    echo '<input placeholder="용기구" type="text" name="weight" class="input_text" value="'.$rows['record_weight'].'KG'.'" maxlength="16"
                    required="" />';
                    ?>
                </div>
                <div class="btn_base base_mar" style="display:inline">
                    <h2 style="margin-bottom: 10px; float:left; margin-right: 30px;">결과</h2>
                    <?php
                    if ($rows["schedule_status"] != "y") {
                      echo '<button type="submit" class="btn_add bold" formaction="three_try_after_reverse.php"
                            style="width:auto; padding-left:5px; padding-right:5px;"><span>순서 재정렬</span></button>';
                    }else{
                      echo' <div class="btn_base base_mar col_left">
                        <input type="button" onclick="" class="btn_excel bold" value="엑셀 출력" />
                    </div>
                    <button type="submit" class="btn_add bold" formaction="pdfout3.php"><span>PDF 출력</span></button>';
                    }
                        if($_POST['check']??null==='3'){
                            echo '<input type="hidden" name="count" value= "5">';
                        }else{
                            echo '<input type="hidden" name="count" value= "3">';
                        }
                    ?>
                </div>
                <table cellspacing="0" cellpadding="0" class="team_table" style="border-top: 0px">
                    <thead>
                        <colgroup>
                            <col style="width: 4%" />
                            <col style="width: 4%" />
                            <col style="width: 15%" />
                            <col style="width: 7%" />
                            <col style="width: 7%" />
                            <col style="width: 7%" />
                            <col style="width: 7%" />
                            <col style="width: 7%" />
                            <col style="width: 7%" />
                            <col style="width: 7%" />
                            <col style="width: 7%" />
                            <col style="width: 7%" />
                        </colgroup>
                        <tr>
                            <th style="background: none; padding-left: 0px; padding-right: 0px;">등수</th>
                            <th style="background: none; padding-left: 0px; padding-right: 0px;">순서</th>
                            <th style="background: none">이름</th>
                            <th style="background: none">1차 시기</th>
                            <th style="background: none">2차 시기</th>
                            <th style="background: none">3차 시기</th>
                            <th style="background: none">4차 시기</th>
                            <th style="background: none">5차 시기</th>
                            <th style="background: none">6차 시기</th>
                            <th style="background: none">기록</th>
                            <th style="background: none">비고</th>
                            <th style="background: none">신기록</th>
                        </tr>
                    </thead>
                    <tbody id="body">
                        <?php
                            $i=1;
                            $count=0; //신기록 위치 관련 변수
                            $trial=0;
                            $order = "record_order";
                        $obj = "record_live_result,record_new,record_memo,athlete_id,record_live_record,record_wind,";
                        if ($rows["schedule_status"] === "y") {
                          $order = "record_live_result";
                          $check='record_live_result>0';
                        } elseif ($_POST["check"] ?? null === "5") {
                          $trial = 6;
                           $check='record_trial ='.$trial.'';
                        } elseif ($_POST["check"] ?? null === "3") {
                          $trial = 4;
                          $check='record_trial ='.$trial.'';
                        } else {
                          $trial = 1;
                          $obj = "";
                          $check='record_trial ='.$trial.'';
                        }
                        $sql2 =
                          "SELECT DISTINCT  " .
                          $obj .
                          "record_order,athlete_name FROM list_record 
                                    INNER JOIN list_athlete ON athlete_id = record_athlete_id 
                                    INNER JOIN list_schedule ON schedule_id= record_schedule_id 
                                    where $check AND schedule_id = '3'
                                    ORDER BY $order ASC";
                            $result2 = $db->query($sql2);
                             while($id=mysqli_fetch_array($result2)){
                                 echo '<tr>';
                                 echo '<td><input type="number" name="rank[]" class="input_text" id="rank" value="'.($id['record_live_result']??null).'" min="1" max="12" required="" /></td>';
                                 echo '<td><input type="number" name="rain[]" class="input_text" value="'.$id['record_order'].'" min="1" max="12" required="" readonly /></td>';
                                 echo '<td><input placeholder="선수 이름" type="text" name="playername[]" class="input_text"
                                value="'.$id['athlete_name'].'" maxlength="30" required="" readonly /></td>';
                                if($_POST["check"] ?? null>=3 || $rows["schedule_status"] === "y"){                       
                                    $answer=$db->query("SELECT record_live_record FROM list_record join list_athlete ON athlete_id = record_athlete_id where record_athlete_id = '".$id['athlete_id']."' AND record_schedule_id = 3 ORDER BY record_trial ASC");
                                    while($row=mysqli_fetch_array($answer)){
                                        echo '<td>';
                                        echo '<input placeholder="경기 결과" type="text" name="gameresult'.($i).'[]" class="input_text" value="'.($row['record_live_record']??null).'"
                                        maxlength="5" required="" onkeyup="field1Format(this)"
                                        style="float: left; width: auto; padding-right: 5px"/>';
                                        echo '</td>';
                                        $i++;
                                    }
                                }
                                for ($j = $i; $j <= 6; $j++) {
                                    echo "<td>";
                                    echo '<input placeholder="경기 결과" type="text" name="gameresult' .
                                    $j .
                                    '[]" class="input_text" value=""
                                                    maxlength="5" onkeyup="field1Format(this)"
                                                    style="float: left; width: auto; padding-right: 5px" />';
                                    echo "</td>";
                                }
                                    echo '<td>';
                                    echo '<input placeholder="경기 결과" id="result" type="text" name="gameresult[]" class="input_text"
                                    value="'.($id["record_live_record"] ?? null) .'" maxlength="5" required="" onkeyup="field1Format(this)"
                                    style="float: left; width: auto; padding-right: 5px" />';
                                    echo '</td>';
                                    echo '<td><input type="text" placeholder ="비고"name="bigo[]" class="input_text" value="' .
                                        ($id["record_memo"] ?? null) .
                                        '" maxlength="100" /></td>';
                                    echo '<td>
                                     <select name="newrecord[]">
                                    <option value='.'n'.'>해당없음</option>
                                    <option value='.'c'.'>대회신기록</option>
                                    <option value='.'a'.'>아시아신기록</option>
                                    <option value='.'s'.'>아시아U20신기록</option>
                                    <option value='.'u'.'>세계U20신기록</option>
                                    <option value='.'w'.'>세계신기록</option>
                                    </select>
                                    </td>';
                                    if(($row['record_new']??null) =='y'){
                                        $newrecord=$db->query("SELECT worldrecord_athletics FROM list_worldrecord WHERE worldrecord_athlete_name ='".$row['athlete_name']."' AND worldrecord_sports='longjump'");
                                        //추후에 태블릿용 페이지를 만든 후 일정과 연결 시 스포츠이름 받아와야함
                                        $athletics=mysqli_fetch_array($newrecord);
                                        echo '<script>';
                                        switch($athletics[0]){
                                            case 'w': echo "document.querySelectorAll('[value=\"w\"]')[$count].selected=true"; break;
                                            case 'u': echo "document.querySelectorAll('[value=\"u\"]')[$count].selected=true"; break; 
                                            case 's': echo "document.querySelectorAll('[value=\"s\"]')[$count].selected=true"; break;
                                            case 'a': echo "document.querySelectorAll('[value=\"a\"]')[$count].selected=true"; break;
                                            case 'c': echo "document.querySelectorAll('[value=\"c\"]')[$count].selected=true"; break;                                     
                                        }
                                        echo '</script>';
                                    }
                                    $i=1;
                                    $count++;
                                }
                            ?>
                    </tbody>
                </table>
                <h3>경기 비고</h3>
                <div class="input_row">
                    <input placeholder="비고를 입력해주세요." type="text" name="bibigo" class="input_text" value=""
                        maxlength="100" />
                </div>
                <div class="signup_submit">
                    <button type="submit" class="btn_login" name="addresult" formaction="sendresult3.php">
                        <span>확인</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>