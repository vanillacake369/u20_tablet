<?php
//높이뛰기,장대높이뛰기 경기용
include "../database/dbconnect.php";
global $db;
$athlete_name = $_POST["playername"];
$round = $_POST["round"];
$name = $_POST["gamename"];
$medal = 0;
$result = $_POST["rank"];
$record = $_POST["gameresult"];
$new = $_POST["newrecord"];
$memo = $_POST["bigo"];
$rane = $_POST["rain"];
$judge_id = $_POST["refereename"];
$res1 = $db->query(
  "SELECT schedule_id,schedule_gender,schedule_sports,schedule_location FROM list_schedule WHERE schedule_name = '$name' and schedule_round ='$round'"
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
        if ($ruf > $worldrecord[$t]) {
          $new = "y";
          // $db->query("insert into list_worldrecord(worldrecord_sports, worldrecord_location, worldrecord_gender,worldrecord_athlete_name,
          // worldrecord_athletics,worldrecord_datetime,worldrecord_country_code,worldrecord_record)
          // values('$name','".$row1['schedule_location']."',$row1[1],'".$athlete_name[$i]."',$athletics[$t],'',$row[1],$ruf)");
        }
      }
      $savequery =
        "INSERT INTO list_record(record_pass, record_live_record,record_memo,record_trial,record_athlete_id,record_schedule_id,record_status ,record_order,record_judge)
                        VALUES ('$pass','$high[$i]','$memo[$j]','$ruf','" .
        $row["athlete_id"] .
        "','$schedule_id','l','$rane[$j]','$judge_id')";
      $updatequery =
        "UPDATE list_record SET record_live_result='$result[$j]',record_medal='$medal' 
                        WHERE record_athlete_id ='" .
        $row["athlete_id"] .
        "' AND record_schedule_id='$schedule_id' AND record_live_record='$best'"; //최종기록에 등수 및 메달 업데이트
      mysqli_query($db, $savequery);
      mysqli_query($db, $updatequery);
      break;
    }
    if ($i == 0) {
      //처음은 오더때문에 생성 되어있기 때문에 업데이트로 넣음
      $savequery =
        "UPDATE list_record SET record_pass='$pass',
                    record_live_record='$high[$i]', record_memo='$memo[$i]'
                    ,record_trial='$ruf' WHERE record_athlete_id ='" .
        $row["athlete_id"] .
        "' AND record_schedule_id='$schedule_id'";
    } else {
      //두번째부터는 높이가 정해져있지 않다고가정 후 작성 - 추후에 최초에 높이가 몇 번째까지 정해져있는지에 따라 바꿀 예정
      $savequery =
        "INSERT INTO list_record(record_pass, record_live_record,record_memo,record_trial,record_athlete_id,record_schedule_id,record_status,record_order,record_judge)
                        VALUES ('$pass','$high[$i]','$memo[$j]','$ruf','" .
        $row["athlete_id"] .
        "','$schedule_id','l','$rane[$j]','$judge_id')";
    }
    mysqli_query($db, $savequery);
  }
}
echo "<script>
    location.replace('addTrackResult3.php') 
    </script>";
?>