<?php
    //릴레이 경기 용
    include "../database/dbconnect.php";
    global $db;   
    $athlete_name=$_POST['playername'];
    $round=$_POST['round'];
    $wind=$_POST['wind']??null;
    $pass=$_POST['gamepass'];
    $name=$_POST['gamename'];
    $medal=0;
    $result=$_POST['rank'];
    $record=$_POST['gameresult'];
    $memo=$_POST['bigo'];
    $rane=$_POST['rain'];
    $judge_id=$_POST['refereename'];
    $res1= $db->query("SELECT schedule_id,schedule_gender,schedule_location FROM list_schedule WHERE schedule_name = '$name' and schedule_round ='$round'");
    $row1 = mysqli_fetch_array($res1);
    $athletics=array();
    $worldrecord=array();
    $res2 = $db->query("SELECT worldrecord_athletics,worldrecord_record
    FROM list_worldrecord WHERE worldrecord_sports = '$name' AND worldrecord_gender ='".$row1['schedule_gender']."'");
    while($row2=mysqli_fetch_array($res2)){
        $athletics[]=$row2[0];
        $worldrecord[]=$row2[1];
    }
    $schedule_id = $row1['schedule_id'];
        $j=0;
        for($i=0;$i<count($athlete_name);$i++){
            $medal = 0;
            $new=0;
                $in=(int)($i/4);
                
                //결승일 경우 메달 계산
                if($round == '결승'){
                    switch($result[$in]){
                        case 1: $medal=10000; break;
                        case 2: $medal=100; break;
                        case 3: $medal=1; break;
                        default: $medal=0; break;
                        }
                    } 
                $re= $db->query("SELECT athlete_id,athlete_country FROM list_athlete  WHERE athlete_name = '".$athlete_name[$i]."'");        
                $row = mysqli_fetch_array($re);
                if($j==3){
                    // 신기록 계산
                    for($j=0;$j<count($worldrecord);$j++){
                        if($record[$in]<$worldrecord[$j]){
                            $new='y';
                            // $db->query("insert into list_worldrecord(worldrecord_sports, worldrecord_location, worldrecord_gender,worldrecord_athlete_name,
                            //     worldrecord_athletics,worldrecord_wind,worldrecord_datetime,worldrecord_country_code,worldrecord_record) 
                            //     values('$name','".$row1['schedule_location']."','$row1[1]','".$athlete_name[$in]."','$athletics[$j]','$wind','','$row[1]','$ruf')");
                                echo '신기록: '."insert into list_worldrecord(worldrecord_sports, worldrecord_location, worldrecord_gender,worldrecord_athlete_name,
                                worldrecord_athletics,worldrecord_wind,worldrecord_datetime,worldrecord_country_code,worldrecord_record) 
                                values('$name','".$row1['schedule_location']."','$row1[1]','".$athlete_name[$in]."','$athletics[$j]','$wind','','$row[1]','$record[$in]')".'<br>';
                        }
        
                    }
                    $savequery="UPDATE list_record SET record_pass='$pass[$in]', record_live_result='$result[$in]', 
                    record_live_record='$record[$in]', record_new='$new',record_memo='$memo[$in]',record_medal=".$medal."
                    ,record_wind='$wind',record_status='l' WHERE record_athlete_id ='".$row['athlete_id']."' AND record_schedule_id='$schedule_id' AND record_judge='$judge_id'" ;
                    mysqli_query($db,$savequery);
                    echo $savequery.'<br>';
                    $j=0;
                    continue;
                }else{
                    $savequery="UPDATE list_record SET record_pass='$pass[$in]', record_live_result='$result[$in]', 
                    record_live_record='$record[$in]', record_new='$new',record_memo='$memo[$in]',record_medal=".$medal."
                    ,record_wind='$wind',record_status='l' WHERE record_athlete_id ='".$row['athlete_id']."' AND record_schedule_id='$schedule_id' AND record_judge='$judge_id'" ;
                    echo $savequery.'<br>';
                    mysqli_query($db,$savequery);
                }
                $j++;
         }
         if($row1['schedule_status']==='n'){
            $db->query("UPDATE list_schedule set schedule_end='".date("Y-m-d H:i:s")."',schedule_result='l' where schedule_id=".$row1['schedule_id']."");
        } 
         echo "<script>
    location.replace('addTrackResult2.php') 
    </script>";
?>