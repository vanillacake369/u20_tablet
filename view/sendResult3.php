<?php
    //일반 필드 경기용
    include "../database/dbconnect.php";
    global $db;	
    $athlete_name=$_POST['playername'];
    $round=$_POST['round'];
    $name=$_POST['gamename'];
    $weight=$_POST['weight'];
    $result=$_POST['rank'];
    $record=$_POST['gameresult'];
    $memo=$_POST['bigo'];
    $rane=$_POST['rain'];
    $judge_id=$_POST['refereename'];
    $res1= $db->query("SELECT schedule_id,schedule_gender,schedule_sports,schedule_location FROM list_schedule WHERE schedule_name = '$name' and schedule_round ='$round'"); 
    $row1 = mysqli_fetch_array($res1);
    $athletics=array();
    $worldrecord=array();
    $res2 = $db->query("SELECT worldrecord_athletics,worldrecord_record
    FROM list_worldrecord WHERE worldrecord_sports = '$row1[2]' AND worldrecord_gender ='".$row1['schedule_gender']."'");
    while($row2=mysqli_fetch_array($res2)){
        $athletics[]=$row2[0];
        $worldrecord[]=$row2[1];
    }
    $schedule_id = $row1['schedule_id'];
    $fieldrecord =array(
        $_POST['gameresult1'],
        $_POST['gameresult2'],
        $_POST['gameresult3'],
        $_POST['gameresult4'],
        $_POST['gameresult5'],
        $_POST['gameresult6']
    );
    for($i=0;$i<count($athlete_name);$i++){ 
        $highrecord=0;
        $hightrial=0;
        $medal=0;
    for($j=0;$j<7;$j++){
            $new='n';
            $re= $db->query("SELECT athlete_id,athlete_country FROM list_athlete  WHERE athlete_name = '".$athlete_name[$i]."'");        
            $row = mysqli_fetch_array($re);
            if($j<6){
                if($fieldrecord[$j][$i]=="X"){
                    $pass='d';
                }else if($fieldrecord[$j][$i]=="-"){
                    $pass='w';
                }else{
                    $pass='p';
                }
            }
            if($j==6){
                $k=$j+1;
                if($round == '결승'){
                switch($result[$i]){
                    case 1: $medal=10000; break;
                    case 2: $medal=100; break;
                    case 3: $medal=1; break;
                    default: $medal=0; break;
                    }
                }
                for($k=0;$k<count($worldrecord);$k++){
                if($record[$i]>$worldrecord[$k]){
                    $new='y';
                    // $db->query("insert into list_worldrecord(worldrecord_sports, worldrecord_location, worldrecord_gender,worldrecord_athlete_name,
                    //     worldrecord_athletics,worldrecord_wind,worldrecord_country_code,worldrecord_record) 
                    //     values('$name','".$row1['schedule_location']."','$row1[1]','".$athlete_name[$i]."','$athletics[$k]','$weight','$row[1]','$record[$i]')");
                        // echo '신기록: '."insert into list_worldrecord(worldrecord_sports, worldrecord_location, worldrecord_gender,worldrecord_athlete_name,
                        // worldrecord_athletics,worldrecord_wind,worldrecord_country_code,worldrecord_record) 
                        // values('$name','".$row1['schedule_location']."','$row1[1]','".$athlete_name[$i]."','$athletics[$k]','$weight','$row[1]','$record[$i]')".'<br>';
                }
            }
                $savequery="UPDATE list_record SET record_live_result='$result[$i]',
                 record_new='$new',record_medal=".$medal."
                ,record_status='l' WHERE record_athlete_id ='".$row['athlete_id']."' AND record_schedule_id='$schedule_id' AND record_live_record='$highrecord'"; 
            }else{
                $k=$j+1;
                $ruf=$fieldrecord[$j][$i];
                $savequery="UPDATE list_record SET record_pass='$pass',
                record_live_record='$ruf', record_new='$new',record_memo='$memo[$i]',record_medal=".$medal."
                ,record_weight='$weight',record_status='l' WHERE record_athlete_id ='".$row['athlete_id']."' AND record_schedule_id='$schedule_id' AND record_trial='$k'";
                if($highrecord<$ruf){
                    $highrecord= $ruf;
                    $hightrial=$k;
                }     
            }       
            // echo $savequery.'<br>';
            mysqli_query($db,$savequery);
        }
    }
    echo "<script>
    location.replace('addFieldResult.php') 
    </script>";
    
    
    exit;
?>