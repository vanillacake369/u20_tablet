<?php
//멀리뛰기,삼단뛰기 경기용
include __DIR__ . "/../database/dbconnect.php";
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
    "SELECT schedule_id,schedule_gender,schedule_sports,schedule_location,schedule_status FROM list_schedule WHERE schedule_id='$s_id'"
);
$row1 = mysqli_fetch_array($res1);
$athletics = [];
$worldrecord = [];
$res2 = $db->query(
    "SELECT worldrecord_athletics,worldrecord_record
    FROM list_worldrecord WHERE worldrecord_sports = '$row1[2]' AND worldrecord_gender ='" .
        $row1["schedule_gender"] .
        "'"
);
if ($name === '10종경기(남)' || $name === '7종경기(여)') {
    $totalresult = $db->query("select schedule_id from list_schedule where schedule_name='$name' and schedule_round='결승'");
    $totalrow = mysqli_fetch_array($totalresult);
}
while ($row2 = mysqli_fetch_array($res2)) {
    $athletics[] = $row2[0];
    $worldrecord[] = $row2[1];
}
$schedule_id = $row1["schedule_id"];
$last_wind = $_POST["lastwind"];
$windrecord = [$_POST["wind1"], $_POST["wind2"], $_POST["wind3"], $_POST["wind4"], $_POST["wind5"], $_POST["wind6"]];
$fieldrecord = [$_POST["gameresult1"], $_POST["gameresult2"], $_POST["gameresult3"], $_POST["gameresult4"], $_POST["gameresult5"], $_POST["gameresult6"]];
for ($i = 0; $i < count($athlete_name); $i++) {
    $highrecord = 0;
    $medal = 0;
    for ($j = 0; $j < 7; $j++) {
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
        if ($j == 6) {
            $k = $j + 1;
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
            for ($t = 0; $t < count($worldrecord); $t++) {
                if ($record[$i] > $worldrecord[$t]) {
                    $new = "y";
                    $db->query("insert into list_worldrecord(worldrecord_sports, worldrecord_location, worldrecord_gender,worldrecord_athlete_name,
          worldrecord_athletics,worldrecord_wind,worldrecord_datetime,worldrecord_country_code,worldrecord_record)
          values('$row1[2]','" . $row1['schedule_location'] . "','$row1[1]','" . $athlete_name[$i] . "','$athletics[$t]','$last_wind[$i]','','$row[1]','$record[$i]')");
                    // echo '신기록: '."insert into list_worldrecord(worldrecord_sports, worldrecord_location, worldrecord_gender,worldrecord_athlete_name,
                    // worldrecord_athletics,worldrecord_wind,worldrecord_datetime,worldrecord_country_code,worldrecord_record)
                    // values('$row1[2]','".$row1['schedule_location']."','$row1[1]','".$athlete_name[$i]."','$athletics[$t]','$last_wind[$i]','','$row[1]','$record[$i]')".'<br>';
                }
            }
            if ($round === '멀리뛰기') {
                $point = (int)(0.14354 * pow(((float)$highrecord * 100 - 220), 1.4)); //longjump
                $savequery = "UPDATE list_record SET record_new='$new',record_judge='$judge[0]',record_multi_record='$point',record_live_result='$result[$i]'
                 WHERE record_athlete_id ='" . $row['athlete_id'] . "' AND record_schedule_id='$schedule_id' AND record_live_record='$highrecord'";
                echo $savequery . '<br>';
                $db->query("UPDATE list_record set record_live_record=record_live_record+$point where record_athlete_id ='" . $row['athlete_id'] . "' AND record_schedule_id='" . $totalrow[0] . "'");
            } else {
                $savequery = "UPDATE list_record SET record_live_result='$result[$i]',record_judge='$judge[0]',
                 record_new='$new',record_medal=" . $medal . "
                ,record_status='l' WHERE record_athlete_id ='" . $row['athlete_id'] . "' AND record_schedule_id='$schedule_id' AND record_live_record='$highrecord'";
            }
        } else {
            $k = $j + 1;
            $ruf = $fieldrecord[$j][$i];
            $win = $windrecord[$j][$i];
            $savequery =
                "UPDATE list_record SET record_pass='$pass',record_judge='$judge[0]',
                record_live_record='$ruf', record_new='$new',record_medal=" .
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
if ($row1['schedule_status'] === 'n') {
    $db->query("UPDATE list_schedule set schedule_end='" . date("Y-m-d H:i:s") . "',schedule_result='l',schedule_status='y' where schedule_id=" . $row1['schedule_id'] . "");
}
// echo "<script>
// alert('RESULT UPDATED');
// history.go(-3);
// </script>";
