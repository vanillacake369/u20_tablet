<?php
//일반 트랙 경기용
include __DIR__ . "/../database/dbconnect.php";
date_default_timezone_set('Asia/Seoul'); //timezone 설정
global $db;
$athlete_name = $_POST['playername'];
$round = $_POST['round'];
$wind = $_POST['wind'] ?? null;
$pass = $_POST['gamepass'];
$name = $_POST['gamename'];
$medal = 0;
$result = $_POST['rank'];
$record = $_POST['gameresult'];
$memo = $_POST['bigo'];
$judge_name = $_POST['refereename'];
$newrecord = $_POST['newrecord'];
$s_id = $_POST['schedule_id'];
$judgeresult = $db->query("select judge_id from list_judge where judge_name='$judge_name'"); //심판 아이디 쿼리
$judge = mysqli_fetch_array($judgeresult);
$res1 = $db->query("SELECT schedule_id,schedule_gender,schedule_location,schedule_status FROM list_schedule WHERE schedule_id='$s_id'");
$row1 = mysqli_fetch_array($res1);
$athletics = array();
$worldrecord = array();
$new = 'n';
$res2 = $db->query("SELECT worldrecord_athletics,MIN(ROUND(cast(worldrecord_record as float),2)) AS worldrecord_record 
                    FROM list_worldrecord
                    WHERE worldrecord_sports ='$name' AND worldrecord_gender='" . $row1['schedule_gender'] . "'
                    GROUP BY worldrecord_athletics");
if ($name === '10종경기(남)' || $name === '7종경기(여)') {
    $totalresult = $db->query("select schedule_id from list_schedule where schedule_name='$name' and schedule_round='결승'");
    $totalrow = mysqli_fetch_array($totalresult);
}
// $res2 = $db->query("SELECT worldrecord_athletics,worldrecord_record
// FROM list_worldrecord WHERE worldrecord_sports = '$name' AND worldrecord_gender ='" . $row1['schedule_gender'] . "'");
while ($row2 = mysqli_fetch_array($res2)) {
    $athletics[] = $row2[0];
    $worldrecord[] = $row2[1];
}
$schedule_id = $row1['schedule_id'];
for ($i = 0; $i < count($athlete_name); $i++) {
    $medal = 0;

    $re = $db->query("SELECT athlete_id,athlete_country FROM list_athlete  WHERE athlete_name = '" . $athlete_name[$i] . "'");
    $row = mysqli_fetch_array($re);
    if ($round == '결승') {
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
    // 신기록 계산
    for ($j = 0; $j < count($worldrecord); $j++) {
        if ($row1['schedule_status'] === 'y') {
            $newre = $db->query("select record_new from list_record where record_athlete_id ='" . $row['athlete_id'] . "' AND record_schedule_id='$schedule_id'");
            $rerow = mysqli_fetch_array($newre);
            $new = $rerow[0];
        } else {
            $new = 'n';
        }
        if ($record[$i] < $worldrecord[$j] && $record[$i] != '0') {
            $new = 'y';
            if ($row1['schedule_status'] === 'y') { //신기록 변경
            } else {
                $db->query("insert into list_worldrecord(worldrecord_sports, worldrecord_location, worldrecord_gender,worldrecord_athlete_name,
                        worldrecord_athletics,worldrecord_wind,worldrecord_datetime,worldrecord_country_code,worldrecord_record) 
                        values('$name','" . $row1['schedule_location'] . "','$row1[1]','" . $athlete_name[$i] . "','$athletics[$j]','$wind','','$row[1]','$record[$i]')");
                // echo '신기록: '."insert into list_worldrecord(worldrecord_sports, worldrecord_location, worldrecord_gender,worldrecord_athlete_name,
                // worldrecord_athletics,worldrecord_wind,worldrecord_datetime,worldrecord_country_code,worldrecord_record) 
                // values('$name','".$row1['schedule_location']."','$row1[1]','".$athlete_name[$i]."','$athletics[$j]','$wind','','$row[1]','$record[$i]')".'<br>';
            }
        }
    }
    if ($round === '100m') {
        $point = (int)(25.4347 * pow((18 - (float)$record[$i]), 1.81)); //100m
        $savequery = "UPDATE list_record SET record_pass='$pass[$i]', record_judge='$judge[0]',record_live_result='$result[$i]',
                    record_live_record='$record[$i]', record_new='$new',record_memo='$memo[$i]',record_medal=" . $medal . ",record_multi_record='$point'
                    ,record_wind='$wind',record_status='l' WHERE record_athlete_id ='" . $row['athlete_id'] . "' AND record_schedule_id='$schedule_id'";
        $db->query("UPDATE list_record set record_live_record=$point where record_athlete_id ='" . $row['athlete_id'] . "' AND record_schedule_id='" . $totalrow[0] . "'");
        // echo "UPDATE list_record set record_live_record=$point where record_athlete_id ='".$row['athlete_id']."' AND record_schedule_id='".$totalrow[0]."'";
    } else if ($round === '400m') {
        $point = (int)(1.53775 * pow((82 - (float)$record[$i]), 1.81)); //400m
        $savequery = "UPDATE list_record SET record_pass='$pass[$i]', record_judge='$judge[0]',record_live_result='$result[$i]',
                    record_live_record='$record[$i]', record_new='$new',record_memo='$memo[$i]',record_medal=" . $medal . ",record_multi_record='$point'
                    ,record_wind='$wind',record_status='l' WHERE record_athlete_id ='" . $row['athlete_id'] . "' AND record_schedule_id='$schedule_id'";
        $db->query("UPDATE list_record set record_live_record=record_live_record+$point where record_athlete_id ='" . $row['athlete_id'] . "' AND record_schedule_id='" . $totalrow[0] . "'");
    } else if ($round === '110mH') {
        $point = (int)(5.74352 * pow((28.5 - (float)$record[$i]), 1.92)); //110mH
        $savequery = "UPDATE list_record SET record_pass='$pass[$i]', record_judge='$judge[0]', record_live_result='$result[$i]',
                    record_live_record='$record[$i]', record_new='$new',record_memo='$memo[$i]',record_medal=" . $medal . ",record_multi_record='$point'
                    ,record_wind='$wind',record_status='l' WHERE record_athlete_id ='" . $row['athlete_id'] . "' AND record_schedule_id='$schedule_id'";
        $db->query("UPDATE list_record set record_live_record=record_live_record+$point where record_athlete_id ='" . $row['athlete_id'] . "' AND record_schedule_id='" . $totalrow[0] . "'");
    } else if ($round === '1500m') {
        $temp = explode(":", $record[$i]);
        $point = (int)(0.03768 * pow((480 - ((int)$temp[0]) * 60 + (int)$temp[1]), 1.85)); //1500m
        $savequery = "UPDATE list_record SET record_pass='$pass[$i]',  record_judge='$judge[0]',record_live_result='$result[$i]',
                    record_live_record='$record[$i]', record_new='$new',record_memo='$memo[$i]',record_medal=" . $medal . ",record_multi_record='$point'
                    ,record_wind='$wind',record_status='l' WHERE record_athlete_id ='" . $row['athlete_id'] . "' AND record_schedule_id='$schedule_id'";
        $db->query("UPDATE list_record set record_live_record=record_live_record+$point where record_athlete_id ='" . $row['athlete_id'] . "' AND record_schedule_id='" . $totalrow[0] . "'");
    } else {
        $savequery = "UPDATE list_record SET record_pass='$pass[$i]', record_live_result='$result[$i]', record_judge='$judge[0]',
                record_live_record='$record[$i]', record_new='$new',record_memo='$memo[$i]',record_medal=" . $medal . "
                ,record_wind='$wind',record_status='l' WHERE record_athlete_id ='" . $row['athlete_id'] . "' AND record_schedule_id='$schedule_id'";
    }
    $db->query($savequery);
}
if ($round === '1500m') {
    $dal = 10000;
    $rankresult = $db->query("SELECT record_id FROM list_record WHERE record_schedule_id=" . $totalrow[0] . " ORDER BY record_live_record *1 DESC LIMIT 3");
    while ($rankrow = mysqli_fetch_array($rankresult)) {
        $db->query("update list_record SET record_medal='$dal' where record_id ='$rankrow[0]'");
        $dal = (int)$dal / 100;
    }
    $db->query("UPDATE list_schedule set schedule_end='" . date("Y-m-d H:i:s") . "',schedule_result='l',schedule_status='y' where schedule_id=" . $totalrow[0] . "");
}
if ($row1['schedule_status'] != 'y') {
    $db->query("UPDATE list_schedule set schedule_end='" . date("Y-m-d H:i:s") . "',schedule_result='l',schedule_status='y' where schedule_id=" . $row1['schedule_id'] . "");
}
echo "<script>
alert('RESULT UPDATED');
history.go(-3);
</script>";
