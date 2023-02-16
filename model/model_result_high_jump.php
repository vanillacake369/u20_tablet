<?php
//높이뛰기,장대높이뛰기 경기용
include "../database/dbconnect.php";
date_default_timezone_set('Asia/Seoul'); //timezone 설정
global $db;
$athlete_name = $_POST["playername"];
$round = $_POST["round"];
$name = $_POST["gamename"];
$medal = 0;
$result = $_POST["rank"];
$record = $_POST["gameresult"];
$s_id = $_POST['schedule_id'];
$new = $_POST["newrecord"];
$memo = $_POST["bigo"];
$rane = $_POST["rain"];
$judge_id = $_POST["refereename"];
$judgeresult = $db->query("select judge_id from list_judge where judge_name='$judge_id'"); //심판 아이디 쿼리
$judge = mysqli_fetch_array($judgeresult);
$res1 = $db->query(
    "SELECT schedule_id,schedule_gender,schedule_sports,schedule_location,schedule_status FROM list_schedule WHERE schedule_id='$s_id'"
);
$row1 = mysqli_fetch_array($res1);
$athletics = [];
$worldrecord = [];
$res2 = $db->query(
    "SELECT worldrecord_athletics,MAX(worldrecord_record) AS worldrecord_record 
  FROM list_worldrecord 
  WHERE worldrecord_sports ='$row1[3]' AND worldrecord_gender='" . $row1['schedule_gender'] . "'
  GROUP BY FIELD(worldrecord_athletics, 'w', 'u', 'a','s','c') "
);
if ($name === '10종경기(남)' || $name === '7종경기(여)') {
    $totalresult = $db->query("select schedule_id from list_schedule where schedule_name='$name' and schedule_round='결승'");
    $totalrow = mysqli_fetch_array($totalresult);
}
while ($row2 = mysqli_fetch_array($res2)) {
    $athletics[] = $row2[0];
    $worldrecord[] = $row2[1];
}
$highcnt = 0; //높이 개수
$schedule_id = $row1["schedule_id"];
$high = $_POST["trial"];
$fieldrecord = [
    $_POST["gameresult1"],
    $_POST["gameresult2"],
    $_POST["gameresult3"],
    $_POST["gameresult4"],
    $_POST["gameresult5"],
    $_POST["gameresult6"],
    $_POST["gameresult7"],
    $_POST["gameresult8"],
    $_POST["gameresult9"],
    $_POST["gameresult10"],
    $_POST["gameresult11"],
    $_POST["gameresult12"],
    $_POST["gameresult13"],
    $_POST["gameresult14"],
    $_POST["gameresult15"],
    $_POST["gameresult16"],
    $_POST["gameresult17"],
    $_POST["gameresult18"],
    $_POST["gameresult19"],
    $_POST["gameresult20"],
    $_POST["gameresult21"],
    $_POST["gameresult22"],
    $_POST["gameresult23"],
    $_POST["gameresult24"],
];
for ($i = 0; $i < count($high); $i++) {
    if ($high[$i] != "") {
        $highcnt++;
    }
}

for ($j = 0; $j < count($athlete_name); $j++) {
    $medal = 0;
    $best = 0; //선수별 최고 기록
    for ($i = 0; $i < $highcnt; $i++) {
        $re = $db->query("SELECT athlete_id FROM list_athlete  WHERE athlete_name = '" . $athlete_name[$j] . "'");
        $row = mysqli_fetch_assoc($re);
        $k = $j + 1;
        $ruf = $fieldrecord[$i][$j];
        if (strpos($ruf, "O") !== false) {
            $pass = "p";
            $best = $high[$i]; //최고기록 저장
        } else if (strpos($ruf, "-") !== false) {
            $pass = "w";
        } else {
            $pass = "d";
            if ($round == "결승") {
                switch ($result[$j]) {
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
                if ($best > $worldrecord[$t]) {
                    $new = "y";
                    echo "insert into list_worldrecord(worldrecord_sports, worldrecord_location, worldrecord_gender,worldrecord_athlete_name,
          worldrecord_athletics,worldrecord_datetime,worldrecord_country_code,worldrecord_record)
          values('$name','" . $row1['schedule_location'] . "',$row1[1],'" . $athlete_name[$i] . "',$athletics[$t],'',$row[1],$best)";
                    // $db->query("insert into list_worldrecord(worldrecord_sports, worldrecord_location, worldrecord_gender,worldrecord_athlete_name,
                    // worldrecord_athletics,worldrecord_datetime,worldrecord_country_code,worldrecord_record)
                    // values('$name','".$row1['schedule_location']."',$row1[1],'".$athlete_name[$i]."',$athletics[$t],'',$row[1],$best)");
                }
            }
            $savequery =
                "INSERT INTO list_record(record_pass, record_live_record,record_memo,record_trial,record_athlete_id,record_schedule_id,record_status ,record_order,record_judge)
                        VALUES ('$pass','$high[$i]','$memo[$j]','$ruf','" .
                $row["athlete_id"] .
                "','$schedule_id','l','$rane[$j]','$judge[0]')";
            if ($round === '높이뛰기') {
                $point = (int)(0.8465 * pow(((float)$best * 100 - 75), 1.42)); //highjump
                $updatequery = "UPDATE list_record SET record_live_result='$result[$j]',record_live_result='$result[$j]',record_multi_record='$point' 
                        WHERE record_athlete_id ='" . $row["athlete_id"] . "' AND record_schedule_id='$schedule_id' AND record_live_record='$best'";
                // $db->query("UPDATE list_record set record_live_record=record_live_record+$point where record_athlete_id ='".$row['athlete_id']."' AND record_schedule_id='".$totalrow[0]."'");
            } else if ($round === '장대높이뛰기') {
                $point = (int)(0.2797 * pow(((float)$best * 100 - 100), 1.35)); //polevault
                $updatequery = "UPDATE list_record SET record_live_result='$result[$j]',record_live_result='$result[$j]',record_multi_record='$point' 
                        WHERE record_athlete_id ='" . $row["athlete_id"] . "' AND record_schedule_id='$schedule_id' AND record_live_record='$best'";
                // $db->query("UPDATE list_record set record_live_record=record_live_record+$point where record_athlete_id ='".$row['athlete_id']."' AND record_schedule_id='".$totalrow[0]."'"); 
            } else {
                $updatequery = "UPDATE list_record SET record_live_result='$result[$j]',record_medal='$medal' 
                        WHERE record_athlete_id ='" . $row["athlete_id"] . "' AND record_schedule_id='$schedule_id' AND record_live_record='$best'"; //최종기록에 등수 및 메달 업데이트

            }
            mysqli_query($db, $savequery);
            mysqli_query($db, $updatequery);
            echo 'updatequery: ' . $updatequery . '<br>';
            break;
        }
        if ($i == 0) {
            //처음은 오더때문에 생성 되어있기 때문에 업데이트로 넣음
            $savequery =
                "UPDATE list_record SET record_pass='$pass',record_judge='$judge[0]',
                    record_live_record='$high[$i]', record_memo='$memo[$i]'
                    ,record_trial='$ruf' WHERE record_athlete_id ='" .
                $row["athlete_id"] .
                "' AND record_schedule_id='$schedule_id'";
        } else {
            //두번째부터는 높이가 정해져있지 않다고가정 후 작성 - 추후에 최초에 높이가 몇 번째까지 정해져있는지에 따라 바꿀 예정
            //insert문은 현재 경기가 끝난후 수정을 하면 또 들어가는 문제가 있음
            $savequery =
                "INSERT INTO list_record(record_pass, record_live_record,record_memo,record_trial,record_athlete_id,record_schedule_id,record_status,record_order,record_judge)
                        VALUES ('$pass','$high[$i]','$memo[$j]','$ruf','" .
                $row["athlete_id"] .
                "','$schedule_id','l','$rane[$j]','$judge[0]')";
        }
        mysqli_query($db, $savequery);
        echo 'savequery: ' . $savequery . '<br>';
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
echo "<script>
alert('RESULT UPDATED');
history.go(-3);
</script>";
