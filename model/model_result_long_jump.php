<?php
//멀리뛰기,삼단뛰기 경기용
include_once __DIR__ . "/../database/dbconnect.php";
include __DIR__ . "/convert_result.php";
date_default_timezone_set('Asia/Seoul'); //timezone 설정
global $db;
$athlete_name = $_POST["playername"];
$round = $_POST["round"];
$name = $_POST["gamename"];
$medal = 0;
$result = $_POST["rank"];
$record = $_POST["gameresult"];
$memo = $_POST["bigo"];
$rane = $_POST["rain"];
$judge_id = $_POST['refereename'];
$s_id = $_POST['schedule_id'];
$judgeresult = $db->query("select judge_id from list_judge where judge_name='$judge_id'"); //심판 아이디 쿼리
$judge = mysqli_fetch_array($judgeresult);
$res1 = $db->query(
    "SELECT * FROM list_schedule WHERE schedule_id='$s_id'"
);
$row1 = mysqli_fetch_array($res1);
$athletics = [];
$res2 = $db->query("SELECT worldrecord_athletics, worldrecord_record AS worldrecord_record 
  FROM list_worldrecord 
  WHERE worldrecord_sports ='" . $row1['schedule_sports'] . "' AND worldrecord_gender='" . $row1['schedule_gender'] . "'
  GROUP BY FIELD(worldrecord_athletics, 'w', 'u', 'a','s','c') ");
$worldrecord = array();
while ($row2 = mysqli_fetch_array($res2)) { //신기록 key->value로 저장 key: ahtletics, value: record
    if (empty($worldrecord[$row2['worldrecord_athletics']])) {
        $worldrecord[$row2['worldrecord_athletics']] = changeresult($row2['worldrecord_record']);
    } else if ($worldrecord[$row2['worldrecord_athletics']] < changeresult($row2['worldrecord_record'])) {
        $worldrecord[$row2['worldrecord_athletics']] = changeresult($row2['worldrecord_record']);
    }
}
if ($name === '10종경기(남)' || $name === '7종경기(여)') {
    $totalresult = $db->query("select schedule_id from list_schedule where schedule_name='$name' and schedule_round='결승'");
    $totalrow = mysqli_fetch_array($totalresult);
    $trialcnt = 4;
} else {
    $trialcnt = 7;
}
if ($row1['schedule_result'] === 'o') { //schedule_result에 따른 수정 및 저장 주체 
    $result_type1 = 'official';
    $result_type2 = 'o';
} else {
    $result_type1 = 'live';
    $result_type2 = 'l';
}
$schedule_id = $row1["schedule_id"];
$last_wind = $_POST["lastwind"];
// $last_wind = $_POST["lastwind"];
$windrecord = [$_POST["wind1"], $_POST["wind2"], $_POST["wind3"], $_POST["wind4"], $_POST["wind5"], $_POST["wind6"]];
$fieldrecord = [$_POST["gameresult1"], $_POST["gameresult2"], $_POST["gameresult3"], $_POST["gameresult4"], $_POST["gameresult5"], $_POST["gameresult6"]];
for ($i = 0; $i < count($athlete_name); $i++) {
    $highrecord = 0;
    $medal = 0;
    for ($j = 0; $j < $trialcnt; $j++) {
        $plus = '';
        $new = 0;
        $re = $db->query("SELECT athlete_id,athlete_country FROM list_athlete  WHERE athlete_name = '" . $athlete_name[$i] . "'");
        $row = mysqli_fetch_array($re);
        if ($j < 6) {
            if ($fieldrecord[$j][$i] == "X") {
                $pass = "d";
            } elseif ($fieldrecord[$j][$i] == "-") {
                $pass = "w";
            } else {
                $pass = "p";
            }
        }
        if ($j + 1 == $trialcnt) {
            if ($round == "결승") {
                switch ($result[$i]) {
                    case 1:
                        $medal = 10000;
                        break;
                    case 2:
                        $medal = 100;
                        break;
                    case 3:
                        $medal = 1;
                        break;
                    default:
                        $medal = 0;
                        break;
                }
            }
            if ($comprecord[$i] != $highrecord) { //기존 기록과 변경된 기록이 같은 지 비교
                if ($row1['schedule_status'] === 'y') { //경기가 끝났는 지 판단
                    if ($rerow[0] === 'y') {
                        $ath = array();
                        $giresult = $db->query("select worldrecord_id,worldrecord_athletics from list_worldrecord where worldrecord_athlete_name='$athlete_name[$i]' and worldrecord_sports='$name'"); // 선수가 가지고 있는 신기록 아이디
                        while ($girow = mysqli_fetch_array($giresult)) {
                            $db->query("update list_worldrecord set worldrecord_record='$highrecord', worldrecord_wind='$wind' where worldrecord_id='$girow[0]'"); //업데이트믄     
                            // echo "update list_worldrecord set worldrecord_record='$highrecord', worldrecord_wind='$wind' where worldrecord_id='$girow[0]'".'<br>';
                            array_push($ath, $girow[1]);
                        }
                        foreach ($worldrecord as $key => $value) { //기존에 가지고 있는 기록말고 달성한것 있느지
                            if (changeresult($highrecord) >= $value && $highrecord != '0') {
                                foreach ($ath as $check) {
                                    if ($check != $key) {
                                        echo '1' . '<br>';
                                        if ($highrecord === $value) {
                                            $memo[$i] = 'tie record';
                                        }
                                        $db->query("insert into list_worldrecord(worldrecord_sports, worldrecord_location, worldrecord_gender,worldrecord_athlete_name,
                                            worldrecord_athletics,worldrecord_wind,worldrecord_datetime,worldrecord_country_code,worldrecord_record) 
                                            values('$name','" . $row1['schedule_location'] . "','" . $row1['schedule_gender'] . "','" . $athlete_name[$i] . "','$key','$wind','" . $row1['schedule_end'] . "','$row[1]','$highrecord')");
                                        // echo '신기록: '."insert into list_worldrecord(worldrecord_sports, worldrecord_location, worldrecord_gender,worldrecord_athlete_name,
                                        //worldrecord_athletics,worldrecord_wind,worldrecord_datetime,worldrecord_country_code,worldrecord_record) 
                                        //values('$name','".$row1['schedule_location']."','".$row1['schedule_gender']."','".$athlete_name[$i]."','$athletics[$j]','$wind','".$row1['schedule_end']."','$row[1]','$highrecord')".'<br>';            
                                    }
                                }
                            }
                        }
                    } else {
                        foreach ($worldrecord as $key => $value) {
                            if (changeresult($highrecord) >= $value && $highrecord != '0') {
                                $new = 'y';
                                if ($highrecord === $value) {
                                    $memo[$i] = 'tie record';
                                }
                                echo '2' . '<br>';
                                $db->query("insert into list_worldrecord(worldrecord_sports, worldrecord_location, worldrecord_gender,worldrecord_athlete_name,
                                    worldrecord_athletics,worldrecord_wind,worldrecord_datetime,worldrecord_country_code,worldrecord_record) 
                                    values('$name','" . $row1['schedule_location'] . "','" . $row1['schedule_gender'] . "','" . $athlete_name[$i] . "','$key','$wind','" . $row1['schedule_end'] . "','$row[1]','$highrecord')");
                                // echo '신기록: '."insert into list_worldrecord(worldrecord_sports, worldrecord_location, worldrecord_gender,worldrecord_athlete_name,
                                // worldrecord_athletics,worldrecord_wind,worldrecord_datetime,worldrecord_country_code,worldrecord_record) 
                                // values('$name','".$row1['schedule_location']."','".$row1['schedule_gender']."','".$athlete_name[$i]."','$athletics[$j]','$wind','".$row1['schedule_end']."','$row[1]','$highrecord')".'<br>';
                            }
                        }
                    }
                } else {
                    foreach ($worldrecord as $key => $value) {
                        if (changeresult($highrecord) >= $value && $highrecord != '0') {
                            $new = 'y';
                            if ($highrecord === $value) {
                                $memo[$i] = 'tie record';
                            }
                            echo '3' . '<br>';
                            $db->query("insert into list_worldrecord(worldrecord_sports, worldrecord_location, worldrecord_gender,worldrecord_athlete_name,
                                worldrecord_athletics,worldrecord_wind,worldrecord_datetime,worldrecord_country_code,worldrecord_record) 
                                values('$name','" . $row1['schedule_location'] . "','" . $row1['schedule_gender'] . "','" . $athlete_name[$i] . "','$key','$wind','" . date("Y-m-d H:i:s") . "','$row[1]','$highrecord')");
                            // echo '신기록: '."insert into list_worldrecord(worldrecord_sports, worldrecord_location, worldrecord_gender,worldrecord_athlete_name,
                            // worldrecord_athletics,worldrecord_wind,worldrecord_datetime,worldrecord_country_code,worldrecord_record) 
                            // values('$name','".$row1['schedule_location']."','".$row1['schedule_gender']."','".$athlete_name[$i]."','$athletics[$j]','$wind','".date("Y-m-d H:i:s")."','$row[1]','$highrecord')".'<br>';
                        }
                    }
                }
            }
            if ($round === '멀리뛰기') {
                $point = (int)(0.14354 * pow(((float)$highrecord * 100 - 220), 1.4)); //longjump
                $plus = ',record_multi_record="' . $point . '"';
                $db->query("UPDATE list_record set record_" . $result_type1 . "_record=record_" . $result_type1 . "_record+$point where record_athlete_id ='" . $row['athlete_id'] . "' AND record_schedule_id='" . $totalrow[0] . "'");
            }
            $savequery = "UPDATE list_record SET record_" . $result_type1 . "_result='$result[$i]',record_judge='$judge[0]',record_new='$new',record_medal=" . $medal . ",record_status='" . $result_type2 . "'" . $plus . " 
                    WHERE record_athlete_id ='" . $row['athlete_id'] . "' AND record_schedule_id='$schedule_id' AND record_" . $result_type1 . "_record='$highrecord'";
        } else {
            $k = $j + 1;
            $ruf = $fieldrecord[$j][$i];
            $win = $windrecord[$j][$i];
            $savequery =
                "UPDATE list_record SET record_pass='$pass',record_judge='$judge[0]',
                record_" . $result_type1 . "_record='$ruf', record_new='$new',record_medal=" .
                $medal .
                ",record_memo='$memo[$i]',record_wind='$win'
                WHERE record_athlete_id ='" .
                $row["athlete_id"] .
                "' AND record_schedule_id='$schedule_id' AND record_trial='$k'";
            if ($highrecord < $ruf && $ruf != 'X') {
                $highrecord = $ruf;
                $hightrial = $k;
            }
        }
        mysqli_query($db, $savequery);
    }
}
if ($row1['schedule_status'] != 'y') {
    $finishcnt = 0;
    $db->query("UPDATE list_schedule set schedule_end='" . date("Y-m-d H:i:s") . "',schedule_result='l',schedule_status='y' where schedule_id=" . $row1['schedule_id'] . ""); // 경기 종료 스케쥴에 반영
    if ($name === '10종경기(남)' || $name === '7종경기(여)') {
        $schedule_result = $db->query("select schedule_status, schedule_id from list_schedule where schedule_name= '$name' and schedule_division = 's' ORDER BY schedule_id ASC"); //10종,7종 소그룹 경기 종료 여부 찾는 쿼리
    } else {
        $schedule_result = $db->query("select schedule_status, schedule_id from list_schedule where schedule_name= '$name' and schedule_round= '$round' and schedule_division = 's' ORDER BY schedule_id ASC"); //소그룹 경기 종료 여부 찾는 쿼리
    }
    while ($schedule_row = mysqli_fetch_array($schedule_result)) {
        if ($schedule_row[0] === 'n' || $schedule_row[0] === 'o') {
            $finishcnt++;
        }
        if ($finishcnt === 0) { //모두 종료시 빅그룹 경기 일정 종료
            $db->query("UPDATE list_schedule set schedule_end='" . date("Y-m-d H:i:s") . "',schedule_result='l',schedule_status='y' where schedule_id=" . ((int)($row1['schedule_id']) - 1) . "");
        }
    }
}
// echo "<script>
// alert('RESULT UPDATED');
// history.go(-3);
// </script>";
