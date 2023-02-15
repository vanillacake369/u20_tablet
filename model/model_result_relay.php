<?php
//릴레이 경기 용
function changeresult($a)
{ //1분이상 경기 기록 변환
    if (strlen($a) > 6) {
        $a = explode(':', $a);
        $a = (float)$a[0] * 60 + (float)$a[1];
    } else {
        $a = (float)$a;
    }
    echo $a . '<br>';
    return $a;
}
include "../database/dbconnect.php";
date_default_timezone_set('Asia/Seoul'); //timezone 설정
global $db;
$athlete_name = $_POST['playername'];
$round = $_POST['round'];
$wind = $_POST['wind'] ?? null;
$pass = $_POST['gamepass'];
$name = $_POST['gamename'];
$medal = 0;
$result = $_POST['rank'];
$comprecord = $_POST['compresult'];
$record = $_POST['gameresult'];
$memo = $_POST['bigo'];
$rane = $_POST['rain'];
$judge_id = $_POST['refereename'];
$s_id = $_POST['schedule_id'];
$judgeresult = $db->query("select judge_id from list_judge where judge_name='$judge_id'"); //심판 아이디 쿼리
$judge = mysqli_fetch_array($judgeresult);
$res1 = $db->query("SELECT * FROM list_schedule WHERE schedule_id='$s_id'");
$row1 = mysqli_fetch_array($res1);
$res2 = $db->query("SELECT worldrecord_athletics, worldrecord_record AS worldrecord_record 
    FROM list_worldrecord 
    WHERE worldrecord_sports ='" . $row1['schedule_sports'] . "' AND worldrecord_gender='" . $row1['schedule_gender'] . "'
    GROUP BY FIELD(worldrecord_athletics, 'w', 'u', 'a','s','c') ");
$worldrecord = array();
while ($row2 = mysqli_fetch_array($res2)) { //신기록 key->value로 저장 key: ahtletics, value: record
    if (empty($worldrecord[$row2['worldrecord_athletics']])) {
        $worldrecord[$row2['worldrecord_athletics']] = changeresult($row2['worldrecord_record']);
    } else if ($worldrecord[$row2['worldrecord_athletics']] > changeresult($row2['worldrecord_record'])) {
        $worldrecord[$row2['worldrecord_athletics']] = changeresult($row2['worldrecord_record']);
    }
}
if ($row1['schedule_result'] === 'o') { //schedule_result에 따른 수정 및 저장 주체 
    $result_type1 = 'official';
    $result_type2 = 'o';
} else {
    $result_type1 = 'live';
    $result_type2 = 'l';
}
if ($row1['schedule_result'] === 'o') { //schedule_result에 따른 수정 및 저장 주체 
    $result_type1 = 'official';
    $result_type2 = 'o';
} else {
    $result_type1 = 'live';
    $result_type2 = 'l';
}
for ($i = 0; $i < count($athlete_name); $i++) {
    $medal = 0;
    $in = (int)($i / 4);

    //결승일 경우 메달 계산
    if ($round == '결승') {
        switch ($result[$in]) {
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
    $re = $db->query("SELECT athlete_id,athlete_country FROM list_athlete  WHERE athlete_name = '" . $athlete_name[$i] . "'");
    $row = mysqli_fetch_array($re);

    if ($i % 4 === 0) {
        $new = 'n';
        // 신기록 계산
        if ($row1['schedule_status'] === 'y') {
            $newre = $db->query("select record_new from list_record where record_athlete_id ='" . $row['athlete_id'] . "' AND record_schedule_id='$s_id'");
            $rerow = mysqli_fetch_array($newre);
            $new = $rerow[0];
        }
        if ($comprecord[$i / 4] != $record[$i / 4]) { //기존 기록과 변경된 기록이 같은 지 비교
            if ($row1['schedule_status'] === 'y') { //경기가 끝났는 지 판단
                if ($rerow[0] === 'y') {
                    $ath = array();
                    $giresult = $db->query("select worldrecord_id,worldrecord_athletics from list_worldrecord where worldrecord_athlete_name='$row[1]' and worldrecord_sports='$name'"); // 선수가 가지고 있는 신기록 아이디
                    while ($girow = mysqli_fetch_array($giresult)) {
                        $db->query("update list_worldrecord set worldrecord_record='$record[$i]', worldrecord_wind='$wind' where worldrecord_id='$girow[0]'"); //업데이트믄     
                        // echo "update list_worldrecord set worldrecord_record='$record[$i]', worldrecord_wind='$wind' where worldrecord_id='$girow[0]'".'<br>';
                        array_push($ath, $girow[1]);
                    }
                    foreach ($worldrecord as $key => $value) { //기존에 가지고 있는 기록말고 달성한것 있느지
                        if (changeresult($record[$i]) <= $value && $record[$i] != '0') {
                            foreach ($ath as $check) {
                                if ($check != $key) {
                                    if ($record[$i] === $value) {
                                        $memo[$i] = 'tie record';
                                    }
                                    echo '1' . '<br>';
                                    $db->query("insert into list_worldrecord(worldrecord_sports, worldrecord_location, worldrecord_gender,worldrecord_athlete_name,
                                worldrecord_athletics,worldrecord_wind,worldrecord_datetime,worldrecord_country_code,worldrecord_record) 
                                values('" . $row1['schedule_sports'] . "','" . $row1['schedule_location'] . "','" . $row1['schedule_gender'] . "','" . $row[1] . "','$key','$wind','" . $row1['schedule_end'] . "','$row[1]','$record[$i]')");
                                    // echo '신기록: '."insert into list_worldrecord(worldrecord_sports, worldrecord_location, worldrecord_gender,worldrecord_athlete_name,
                                    //worldrecord_athletics,worldrecord_wind,worldrecord_datetime,worldrecord_country_code,worldrecord_record) 
                                    //values('".$row1['schedule_sports']."','".$row1['schedule_location']."','".$row1['schedule_gender']."','".$row[1]."','$athletics[$j]','$wind','".$row1['schedule_end']."','$row[1]','$record[$i]')".'<br>';            
                                }
                            }
                        }
                    }
                } else {
                    foreach ($worldrecord as $key => $value) {
                        if (changeresult($record[$i]) <= $value && $record[$i] != '0') {
                            $new = 'y';
                            if ($record[$i] === $value) {
                                $memo[$i] = 'tie record';
                            }
                            echo '2' . '<br>';
                            $db->query("insert into list_worldrecord(worldrecord_sports, worldrecord_location, worldrecord_gender,worldrecord_athlete_name,
                        worldrecord_athletics,worldrecord_wind,worldrecord_datetime,worldrecord_country_code,worldrecord_record) 
                        values('" . $row1['schedule_sports'] . "','" . $row1['schedule_location'] . "','" . $row1['schedule_gender'] . "','" . $row[1] . "','$key','$wind','" . $row1['schedule_end'] . "','$row[1]','$record[$i]')");
                            echo '신기록: ' . "insert into list_worldrecord(worldrecord_sports, worldrecord_location, worldrecord_gender,worldrecord_athlete_name,
                        worldrecord_athletics,worldrecord_wind,worldrecord_datetime,worldrecord_country_code,worldrecord_record) 
                        values('" . $row1['schedule_sports'] . "','" . $row1['schedule_location'] . "','" . $row1['schedule_gender'] . "','" . $row[1] . "','$key','$wind','" . $row1['schedule_end'] . "','$row[1]','$record[$i]')" . '<br>';
                        }
                    }
                }
            } else {
                foreach ($worldrecord as $key => $value) {
                    if (changeresult($record[$i]) <= $value && $record[$i] != '0') {
                        $new = 'y';
                        if ($record[$i] === $value) {
                            $memo[$i] = 'tie record';
                        }
                        echo '3' . '<br>';
                        $db->query("insert into list_worldrecord(worldrecord_sports, worldrecord_location, worldrecord_gender,worldrecord_athlete_name,
                    worldrecord_athletics,worldrecord_wind,worldrecord_datetime,worldrecord_country_code,worldrecord_record) 
                    values('" . $row1['schedule_sports'] . "','" . $row1['schedule_location'] . "','" . $row1['schedule_gender'] . "','" . $row[1] . "','$key','$wind','" . date("Y-m-d H:i:s") . "','$row[1]','$record[$i]')");
                        // echo '신기록: '."insert into list_worldrecord(worldrecord_sports, worldrecord_location, worldrecord_gender,worldrecord_athlete_name,
                        // worldrecord_athletics,worldrecord_wind,worldrecord_datetime,worldrecord_country_code,worldrecord_record) 
                        // values('".$row1['schedule_sports']."','".$row1['schedule_location']."','".$row1['schedule_gender']."','".$row[1]."','$athletics[$j]','$wind','".date("Y-m-d H:i:s")."','$row[1]','$record[$i]')".'<br>';
                    }
                }
            }
        }
    }
    $savequery = "UPDATE list_record SET record_pass='$pass[$in]', record_" . $result_type1 . "_result='$result[$in]',record_judge='$judge[0]',
                    record_" . $result_type1 . "_record='$record[$in]', record_new='$new',record_memo='$memo[$in]',record_medal=" . $medal . "
                    ,record_wind='$wind',record_status='" . $result_type2 . "' WHERE record_athlete_id ='" . $row['athlete_id'] . "' AND record_schedule_id='$s_id' AND record_judge='$judge[0]'";
    mysqli_query($db, $savequery);
    echo $savequery . '<br>';
}
if ($row1['schedule_status'] != 'y') {
    $finishcnt = 0;
    $schedule_result = $db->query("select schedule_status, schedule_id from list_schedule where schedule_name= '$name' and schedule_round= '$round' and schedule_division = 's' ORDER BY schedule_id ASC");
    while ($schedule_row = mysqli_fetch_array($schedule_result)) {
        if ($schedule_row[0] === 'n') {
            $finishcnt++;
        }
        if ($finishcnt === 0) {
            $db->query("UPDATE list_schedule set schedule_end='" . date("Y-m-d H:i:s") . "',schedule_result='l',schedule_status='y' where schedule_id=" . ((int)($s_id) - 1) . "");
        }
    }
    $db->query("UPDATE list_schedule set schedule_end='" . date("Y-m-d H:i:s") . "',schedule_result='l',schedule_status='y' where schedule_id=" . $s_id . "");
}
// echo "<script>
//     location.replace('addTrackResult2.php?id=".$s_id."') 
//     </script>";
