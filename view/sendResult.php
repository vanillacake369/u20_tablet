<?php
    include "../database/dbconnect.php";
    global $db;	
    $athlete_name=$_POST['playername'];
    $round=$_POST['round'];
    $wind=$_POST['wind']??null;
    $pass=$_POST['gamepass'];
    $medal=0;
    $result=$_POST['rank'];
    $record=$_POST['gameresult'];
    $new=$_POST['newrecord'];
    $memo=$_POST['bigo'];
    $rane=$_POST['rain'];
    $judge_id=$_POST['refereename'];
    $res= $db->query("SELECT sports_id, schedule_id FROM list_sports 
    INNER JOIN list_schedule on schedule_name = '".$_POST['gamename']."' and schedule_round ='$round' WHERE sports_name_kr='".$_POST['gamename']."'"); 
    echo "SELECT sports_id, schedule_id FROM list_sports 
    INNER JOIN list_schedule on schedule_name = '".$_POST['gamename']."' and schedule_round ='$round' WHERE sports_name_kr='".$_POST['gamename']."'";
    $row = mysqli_fetch_array($res);
    $schedule_id = $row['schedule_id'];
    $sport_id = $row['sports_id'];
    if($sport_id ==25 || $sport_id ==24){ //릴레이 경기 용
        $fieldrecord =array(
            $_POST['gameresult1'],
            $_POST['gameresult2'],
            $_POST['gameresult3'],
            $_POST['gameresult4']
        );
        $j=0;
        for($i=0;$i<count($athlete_name);$i++){
                if($round == 'final'){
                    switch($result[$i]){
                        case 1: $medal=10000; break;
                        case 2: $medal=100; break;
                        case 3: $medal=1; break;
                        default: $medal=0; break;
                        }
                    }
                $in=intval($i/4);
                $ruf=$fieldrecord[$j][$in];
                $re= $db->query("SELECT athlete_id FROM list_athlete  WHERE athlete_name = '".$athlete_name[$i]."'");        
                $row = mysqli_fetch_assoc($re);
                $savequery="UPDATE list_record SET record_pass='$pass[$in]', record_result='$result[$in]', 
                record_record='$ruf', record_new='$new[$in]',record_memo='$memo[$in]',record_medal=".$medal."
                ,record_wind='$wind' WHERE record_athlete_id ='".$row['athlete_id']."' AND record_schedule_id='$schedule_id'" ;
                // echo $ruf.'<br>';
                // echo $athlete_name[$i].'<br>';
                // echo $savequery."<br>";
                mysqli_query($db,$savequery);
                if($j==3){
                    $j=0;
                    continue;
                }
                $j++;
            
         }
    }else if($sport_id ==15|| $sport_id == 16){//멀리뛰기,삼단뛰기 경기용
        $last_wind=$_POST['lastwind'];
        $windrecord =array(
            $_POST['wind1'],
            $_POST['wind2'],
            $_POST['wind3'],
            $_POST['wind4'],
            $_POST['wind5'],
            $_POST['wind6']
        );
        $fieldrecord =array(
            $_POST['gameresult1'],
            $_POST['gameresult2'],
            $_POST['gameresult3'],
            $_POST['gameresult4'],
            $_POST['gameresult5'],
            $_POST['gameresult6']
        );
        for($j=0;$j<7;$j++){
            for($i=0;$i<count($athlete_name);$i++){ 
                $re= $db->query("SELECT athlete_id FROM list_athlete  WHERE athlete_name = '".$athlete_name[$i]."'");        
                $row = mysqli_fetch_assoc($re);
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
                    if($round == 'final'){
                    switch($result[$i]){
                        case 1: $medal=10000; break;
                        case 2: $medal=100; break;
                        case 3: $medal=1; break;
                        default: $medal=0; break;
                        }
                    }
                    $savequery="UPDATE list_record SET record_result='$result[$i]',record_record='$record[$i]', 
                    record_new='$new[$i]',record_memo='$memo[$i]',record_medal=".$medal.",record_wind='$last_wind[$i]'
                    WHERE record_athlete_id ='".$row['athlete_id']."' AND record_schedule_id='$schedule_id' AND record_trial='$k'"; 
                }else{
                    $k=$j+1;
                    $ruf=$fieldrecord[$j][$i];
                    $win=$windrecord[$j][$i];
                    $savequery="UPDATE list_record SET record_result='$result[$i]',record_pass='$pass',
                    record_record='$ruf', record_new='$new[$i]',record_memo='$memo[$i]',record_wind='$win'
                    WHERE record_athlete_id ='".$row['athlete_id']."' AND record_schedule_id='$schedule_id' AND record_trial='$k'";
                }
                mysqli_query($db,$savequery);
            }
        }
    }else if($sport_id ==14|| $sport_id == 13){//높이뛰기,장대높이뛰기 경기용
        $high=$_POST['trial'];
        $fieldrecord =array(
            $_POST['gameresult1'],
            $_POST['gameresult2'],
            $_POST['gameresult3'],
            $_POST['gameresult4'],
            $_POST['gameresult5'],
            $_POST['gameresult6'],
            $_POST['gameresult7'],
            $_POST['gameresult8'],
            $_POST['gameresult9'],
            $_POST['gameresult10'],
            $_POST['gameresult11'], 
            $_POST['gameresult12'],
            $_POST['gameresult13'],
            $_POST['gameresult14'],
            $_POST['gameresult15'],
            $_POST['gameresult16'],
            $_POST['gameresult17'],
            $_POST['gameresult18'],
            $_POST['gameresult19'],
            $_POST['gameresult20'],
            $_POST['gameresult21'],
            $_POST['gameresult22'],
            $_POST['gameresult23'],
            $_POST['gameresult24']
        );
        for($i=0;$i<count($high);$i++){
            if(isset($high[$i])){
                for($j=0;$j<count($athlete_name);$j++){
                    $re= $db->query("SELECT athlete_id FROM list_athlete  WHERE athlete_name = '".$athlete_name[$i]."'");  
                    $row = mysqli_fetch_assoc($re);     
                    $k=$j+1;
                    $ruf=$fieldrecord[$i][$j];
                    $savequery="UPDATE list_record SET record_pass='$pass',
                    record_record='$ruf', record_memo='$memo[$i]'
                    ,record_trial='$high[$i]' WHERE record_athlete_id ='".$row['athlete_id']."' AND record_schedule_id='$schedule_id'";
                    echo $savequery;
                }
            }
        }
    }else if($sport_id>=17 && $sport_id<=20){
        $fieldrecord =array(
            $_POST['gameresult1'],
            $_POST['gameresult2'],
            $_POST['gameresult3'],
            $_POST['gameresult4'],
            $_POST['gameresult5'],
            $_POST['gameresult6']
        );
        for($j=0;$j<7;$j++){
            for($i=0;$i<count($athlete_name);$i++){ //일반 필드 경기용
                $re= $db->query("SELECT athlete_id FROM list_athlete  WHERE athlete_name = '".$athlete_name[$i]."'");        
                $row = mysqli_fetch_assoc($re);
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
                    if($round == 'final'){
                    switch($result[$i]){
                        case 1: $medal=10000; break;
                        case 2: $medal=100; break;
                        case 3: $medal=1; break;
                        default: $medal=0; break;
                        }
                    }
                    $savequery="UPDATE list_record SET record_result='$result[$i]',
                    record_record='$record[$i]', record_new='$new[$i]',record_memo='$memo[$i]',record_medal=".$medal."
                    ,record_weight='$wind' WHERE record_athlete_id ='".$row['athlete_id']."' AND record_schedule_id='$schedule_id' AND record_trial='$k'"; 
                }else{
                    $k=$j+1;
                    $ruf=$fieldrecord[$j][$i];
                    $savequery="UPDATE list_record SET record_result='$result[$i]',record_pass='$pass',
                    record_record='$ruf', record_new='$new[$i]',record_memo='$memo[$i]'
                    ,record_weight='$wind' WHERE record_athlete_id ='".$row['athlete_id']."' AND record_schedule_id='$schedule_id' AND record_trial='$k'";
                }
                mysqli_query($db,$savequery);
            }
        }
    }else{
        for($i=0;$i<count($athlete_name);$i++){ //일반 트랙 경기용
            if($round == 'final'){
                switch($result[$i]){
                    case 1: $medal=10000; break;
                    case 2: $medal=100; break;
                    case 3: $medal=1; break;
                    default: $medal=0; break;
                }
            }
            $re= $db->query("SELECT athlete_id FROM list_athlete  WHERE athlete_name = '".$athlete_name[$i]."'");        
            $row = mysqli_fetch_assoc($re);
            $savequery="UPDATE list_record SET record_pass='$pass[$i]', record_result='$result[$i]', 
            record_record='$record[$i]', record_new='$new[$i]',record_memo='$memo[$i]',record_medal=".$medal."
            ,record_wind='$wind' WHERE record_athlete_id ='".$row['athlete_id']."' AND record_schedule_id='$schedule_id'" ;
            mysqli_query($db,$savequery);
        }
    }
    
    exit;
?>