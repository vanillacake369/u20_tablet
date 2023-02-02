<?php
//일반 트랙 경기용
include "../database/dbconnect.php";
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
$judge_id = $_POST['refereename'];
$newrecord=$_POST['newrecord'];
$res1 = $db->query("SELECT schedule_id,schedule_gender,schedule_location,schedule_status FROM list_schedule WHERE schedule_name = '$name' and schedule_round ='$round'");
$row1 = mysqli_fetch_array($res1);
$athletics = array();
$worldrecord = array();
$res2 = $db->query("SELECT worldrecord_athletics,MIN(ROUND(cast(worldrecord_record as float),2)) AS worldrecord_record 
                    FROM list_worldrecord 
                    WHERE worldrecord_sports ='$name' AND worldrecord_gender='" . $row1['schedule_gender'] . "'
                    GROUP BY worldrecord_athletics");
// $res2 = $db->query("SELECT worldrecord_athletics,worldrecord_record
    // FROM list_worldrecord WHERE worldrecord_sports = '$name' AND worldrecord_gender ='" . $row1['schedule_gender'] . "'");
while ($row2 = mysqli_fetch_array($res2)) {
    $athletics[] = $row2[0];
    $worldrecord[] = $row2[1];
}
$schedule_id = $row1['schedule_id'];
for ($i = 0; $i < count($athlete_name); $i++) {
    $medal = 0;
    $new = 0;
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
            for($j=0;$j<count($worldrecord);$j++){
                if($record[$i]<$worldrecord[$j] && $record[$i]!= '0'){
                    if($row1['schedule_status']==='y' ){ //신기록 변경
                        $stat =$db->query("SELECT worldrecord_athletics FROM list_worldrecord 
                        WHERE worldrecord_sports='$name' AND worldrecord_gender ='$row1[1]' AND worldrecord_athlete_name='$athlete_name[$i]'AND worldrecord_record='$record[$i]'");
                        $check= mysqli_fetch_array($stat);
                        if(isset($check[0])){
                            if($check[0] !=$newrecord[$i]){
                                if($newrecord[$i]==='n'){ //해당없음일때
                                    $new='n'; //신기록 여부 X
                                    $db->query("delete from list_worldrecord where worldrecord_sports='$name' ADN worldrecord_record='$record[$i] AND worldrecord_gender='$row1[1]' AND worldrecord_athletics='$newrecord[$i]' AND worldrecord_athlete_name='".$athlete_name[$i]."'");//신기록 테이블에 해당 기록 지우기
                                    continue;
                                }
                                $db->query("UPDATE list_worldrecord SET worldrecord_athletics='w'
                                WHERE worldrecord_sports='$name' AND worldrecord_gender='$row1[1]' AND worldrecord_athletics='$newrecord[$i]' AND worldrecord_athlete_name='".$athlete_name[$i]."'");
                                // echo "UPDATE list_worldrecord SET worldrecord_athletics='$newrecord[$i]'
                                //  WHERE worldrecord_sports='$name' AND worldrecord_gender='$row1[1]' AND worldrecord_athletics='$check[0]' AND worldrecord_athlete_name='".$athlete_name[$i]."'"."<br>";
                                continue;     
                            }  
                        }
                    }
                    $new='y';
                    $db->query("insert into list_worldrecord(worldrecord_sports, worldrecord_location, worldrecord_gender,worldrecord_athlete_name,
                    worldrecord_athletics,worldrecord_wind,worldrecord_datetime,worldrecord_country_code,worldrecord_record) 
                    values('$name','".$row1['schedule_location']."','$row1[1]','".$athlete_name[$i]."','$athletics[$j]','$wind','','$row[1]','$record[$i]')");
                    // echo '신기록: '."insert into list_worldrecord(worldrecord_sports, worldrecord_location, worldrecord_gender,worldrecord_athlete_name,
                    // worldrecord_athletics,worldrecord_wind,worldrecord_datetime,worldrecord_country_code,worldrecord_record) 
                    // values('$name','".$row1['schedule_location']."','$row1[1]','".$athlete_name[$i]."','$athletics[$j]','$wind','','$row[1]','$record[$i]')".'<br>';
                }  
            }
            $savequery="UPDATE list_record SET record_pass='$pass[$i]', record_live_result='$result[$i]', 
            record_live_record='$record[$i]', record_new='$new',record_memo='$memo[$i]',record_medal=".$medal."
            ,record_wind='$wind',record_status='l' WHERE record_athlete_id ='".$row['athlete_id']."' AND record_schedule_id='$schedule_id'" ;
            mysqli_query($db,$savequery);

            
        }   
        echo "<script>
            location.replace('addTrackResult.php') 
            </script>";
        ?>