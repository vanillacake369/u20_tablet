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
    <script type="text/javascript" src="../js/onlynumber.js"></script>
    <script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
    <script>
    function openTextFile() {
        var input = document.createElement("input");
        input.type = "file";
        input.accept = "text/plain"; // 확장자가 xxx, yyy 일때, ".xxx, .yyy"
        input.onchange = function(event) {
            processFile(event.target.files[0]);
        };
        input.click();
    }

    function processFile(file) {
        var reader = new FileReader();
        reader.onload = function() {
            let ddd = reader.result.split("\r\n");
            let wind = document.querySelector('[name=\"wind\"]')
            let val = ddd[0].split(" ")[1];
            wind.value = val;
            for (i = 1; i < ddd.length; i++) {
                let k = ddd[i].split(" ")
                let on = document.querySelector("#" + k[1]).children
                if (k[2]) {
                    on[3].firstElementChild.value = 'p'
                    on[4].firstElementChild.value = k[2]
                } else if (k[0] == 'DNS') {
                    on[3].firstElementChild.value = 'n'
                    on[4].firstElementChild.value = 0
                    on[5].firstElementChild.value = k[0]
                } else if (k[0] == 'DNF') {
                    on[3].firstElementChild.value = 'n'
                    on[4].firstElementChild.value = 0
                    on[5].firstElementChild.value = k[0]
                } else {
                    on[3].firstElementChild.value = 'd'
                    on[4].firstElementChild.value = 0
                    on[5].firstElementChild.value = 'DQ'
                }
            }
            rankcal1()
        };
        reader.readAsText(file, /* optional */ "utf-8");
    }
    $(document).on("click", "input[name='newrecord[]']", function() {
        console.log("click")
        const form = document.createElement("form");
        var url = "change_record_category.php";
        form.setAttribute("method", "post");
        form.setAttribute("action", url);
        form.setAttribute("target", "popup test");
        var name = "popup test";
        var option = "width = 500, height = 500, top = 100, left = 200, location = no"
        window.open('', name, option);
        const hidden_name = document.createElement("input");
        hidden_name.setAttribute("type", "hidden");
        hidden_name.setAttribute("name", "athlete_name");
        hidden_name.setAttribute("value", $(this).attr('ath'));
        form.appendChild(hidden_name);
        const hidden_sports = document.createElement("input");
        hidden_sports.setAttribute("type", "hidden");
        hidden_sports.setAttribute("name", "schedule_sports");
        hidden_sports.setAttribute("value", $(this).attr('sports'));
        form.appendChild(hidden_sports);
        document.body.appendChild(form);
        form.submit();
    })
    </script>
    <title>U20</title>
</head>

<body>
    <?php
    $id=$_GET['id'];
    include_once "../database/dbconnect.php"; //B:데이터베이스 연결 
    $sql= "SELECT DISTINCT judge_name,schedule_round,schedule_status,record_wind,schedule_sports FROM list_judge JOIN list_record ON judge_id = record_judge INNER JOIN list_schedule ON schedule_id= record_schedule_id AND schedule_id = '$id'";
    $result=$db->query($sql);
    $rows = mysqli_fetch_assoc($result);
    ?>
    <!-- contents 본문 내용 -->
    <div class="container">
        <!-- class="contents something" -->
        <div class="something" style="padding: 60px 15px 60px 15px">
            <form action="sendresult1.php" method="post" class="form">

                <h3 style="width:45%; display:inline-block; margin-right: 4.6%;">경기 이름</h3>
                <h3 style="width:48%; display:inline-block;">라운드</h3>
                <div class="input_row" style="width:45%; margin-right: 4.6%;">
                    <input placeholder="경기 이름" type="text" name="gamename" class="input_text" value="100m"
                        maxlength="16" required="" readonly />
                </div>
                <div class="input_row" style="width:48%;">
                    <?php
                    echo '<input placeholder="라운드" type="text" name="round" class="input_text" value="' . $rows['schedule_round'] . '"
                    maxlength="16" required="" readonly />';
                    ?>
                </div>
                <h3 style="width:45%; display:inline-block; margin-right: 4.6%;">심판 이름</h3>
                <h3 style="width:48%; display:inline-block;">풍속</h3>
                <div class="input_row" style="width:45%; margin-right: 4.6%;">
                    <?php
                    echo '<input placeholder="심판 이름" type="text" name="refereename" class="input_text" value="' . $rows['judge_name'] . '"
                    maxlength="30" required="" readonly />';
                    ?>
                </div>
                <div class="input_row" style="width:48%;">

                    <?php
                    if($rows['schedule_status']==='y'){
                        echo '<input placeholder="풍속을 입력해주세요." type="text" name="wind" class="input_text" value="'.$rows['record_wind'].'" maxlength="16"
                            required="" />';
                    }else{
                        
                        echo '<input placeholder="풍속을 입력해주세요." type="text" name="wind" class="input_text" value="" maxlength="16"
                            required="" />';
                        }
                            ?>
                </div>
                <div class="btn_base base_mar" style="display:inline-flex; align-items: baseline;">
                    <h2 style="margin-bottom: 10px; float:left; margin-right: 30px;">결과</h2>
                    <?php
                    if($rows['schedule_status']!='y'){
                        echo '<input type="button" onclick="openTextFile()" class="btn_add bold" value="자동 입력"
                        style="margin-right:15px;">';
                }else{
                      echo' <div class="btn_base base_mar col_left">
                      
                        <input type="button" onclick="" class="btn_excel bold" value="엑셀 출력" />
                    </div>
                    <button type="submit" class="btn_add bold" formaction="pdfout.php"><span>PDF 출력</span></button>';
                    }
                    ?>
                </div>
                <table cellspacing="0" cellpadding="0" class="team_table" style="border-top: 0px">
                    <thead>
                        <colgroup>
                            <col style="width: 7%" />
                            <col style="width: 7%" />
                            <col style="width: 25%" />
                            <col style="width: 10%" />
                            <col style="width: 15%" />
                            <col style="width: 10%" />
                            <col style="width: 26%" />
                        </colgroup>
                        <tr>
                            <th style="background: none">등수</th>
                            <th style="background: none">레인</th>
                            <th style="background: none">이름</th>
                            <th style="background: none">통과 여부</th>
                            <th style="background: none">경기 결과</th>
                            <th style="background: none">비고</th>
                            <th style="background: none">신기록</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $relm='record_live_result,record_live_record,record_pass,record_memo,record_new,athlete_name, record_order';
                        if($rows['schedule_status']=='y'){
                            $order='record_live_result';
                        }else{
                            $order='record_order';
                        }
                        $sql="SELECT ".$relm." FROM list_record 
                        INNER JOIN list_athlete ON list_athlete.athlete_id = list_record.record_athlete_id 
                        INNER JOIN list_schedule ON list_schedule.schedule_id= list_record.record_schedule_id 
                        AND list_schedule.schedule_id = '$id'
                        ORDER BY ".$order." ASC ";
                        $count=0;
                        $result=$db->query($sql); 
                            while($row = mysqli_fetch_array($result)){
                                echo '<tr id="rane'.$row['record_order'].'">';
                                echo '<td><input type="number" name="rank[]" id="rank" class="input_text" value="'.$row['record_live_result'].'" min="1" max="12" required="" /></td>';
                                echo '<td><input type="number" name="rain[]" class="input_text" value="'.$row['record_order'].'" min="1" max="12" required="" readonly /></td>';
                                echo '<td><input placeholder="선수 이름" type="text" name="playername[]" 
                                class="input_text" value="'.$row['athlete_name'].'" maxlength="30" required="" readonly /></td>';
                                echo '<td><input placeholder="경기 통과 여부" type="text" name="gamepass[]" class="input_text" value="'.$row['record_pass'].'" maxlength="50" required="" /></td>';
                                echo '<td><input placeholder="경기 결과를 입력해주세요" type="text" name="gameresult[]" id="result" class="input_text" value="'.$row['record_live_record'].'" maxlength="8"
                                 required="" onkeyup="trackFinal(this)" style="float: left; width: auto; padding-right: 5px" /></td>';
                                echo '<td><input placeholder="비고를 입력해주세요" type="text" name="bigo[]" class="input_text" value="'.($row['record_memo'] ? $row['record_memo']:'&nbsp').'" maxlength="100" /></td>';
                                
                                if($row['record_new'] =='y'){
                                        $newrecord=$db->query("SELECT worldrecord_athletics FROM list_worldrecord WHERE worldrecord_athlete_name ='".$row['athlete_name']."' AND worldrecord_sports='".$rows['schedule_sports']."'");
                                        //추후에 태블릿용 페이지를 만든 후 일정과 연결 시 스포츠이름 받아와야함
                                        $newathletics= array();
                                        while($athletics=mysqli_fetch_array($newrecord)){
                                            $newathletics[]=$athletics[0];
                                        }
                                        switch(($newathletics[0]??null)){
                                            case 'w': echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_text" value="세계신기록';
                                                      if(count($newathletics)>1){
                                                        echo ' 외 '.(count($newathletics)-1).'개';
                                                      }
                                                      echo '" maxlength="100" ath="'.$row['athlete_name'].'" sports='.$rows['schedule_sports'].' readonly/></td>'; break;
                                            case 'u': echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_text" value="세계U20신기록';
                                                      if(count($newathletics)>1){
                                                        echo ' 외 '.(count($newathletics)-1).'개';
                                                      }
                                                      echo '" maxlength="100" ath="'.$row['athlete_name'].'" sports='.$rows['schedule_sports'].' readonly/></td>'; break;
                                            case 'a': echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_text" value="아시아신기록';
                                                      if(count($newathletics)>1){
                                                        echo ' 외 '.(count($newathletics)-1).'개';
                                                      }
                                                      echo '" maxlength="100" ath="'.$row['athlete_name'].'" sports='.$rows['schedule_sports'].' readonly/></td>'; break;
                                            case 's': echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_text" value="아시아U20신기록';
                                                      if(count($newathletics)>1){
                                                        echo ' 외 '.(count($newathletics)-1).'개';
                                                      }
                                                      echo '" maxlength="100" ath="'.$row['athlete_name'].'" sports='.$rows['schedule_sports'].' readonly/></td>'; break;
                                            case 'c': echo '<td<input placeholder="" type="text" name="newrecord[]" class="input_text" value=">대회신기록';
                                                      if(count($newathletics)>1){
                                                        echo ' 외 '.(count($newathletics)-1).'개';
                                                      }
                                                      echo '" maxlength="100" ath="'.$row['athlete_name'].'" sports='.$rows['schedule_sports'].' readonly/></td>'; break;  
                                            default: echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_text" value="" maxlength="100" ath="'.$row['athlete_name'].'" sports='.$rows['schedule_sports'].' readonly/></td>'; break;
                                                                              
                                        }   
                                    }else{
                                        echo '<td><input placeholder="" type="text" name="newrecord[]" class="input_text" value="" maxlength="100" readonly/></td>';
                                    }
                                    $count++;
                            }
                        ?>
                        </tr>

                    </tbody>
                </table>
                <h3>경기 비고</h3>
                <div class="input_row">
                    <input placeholder="비고를 입력해주세요." type="text" name="bibigo" class="input_text" value=""
                        maxlength="100" />
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