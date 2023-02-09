<?php
include "../database/dbconnect.php";
// include_once(__DIR__ . "auth/config.php");
include_once(__DIR__ . "/../security/security.php");
$name=$_POST['name'];
$sports=$_POST['sports'];
$gizone=$_POST['gizone'];
$newrecord=$_POST['newrecord'];

$sql="";
for($i=0;$i<count($newrecord);$i++){
    // if($gizone[$i]==='n'){
    //     $result=$db->query("SELECT athlete_name,schedule_location,schedule_gender,athlete_country,record_live_record,schedule_end,record_wind,record_weight 
    //                         from list_schedule 
    //                         inner JOIN list_record ON record_schedule_id = schedule_id
    //                         INNER JOIN list_athlete ON athlete_name = '$name'  AND record_athlete_id = athlete_id
    //                         WHERE schedule_sports = '$sports'");
    //     $row1=mysqli_fetch_array($result);
    //     $sql.="insert into list_worldrecord(worldrecord_sports, worldrecord_location, worldrecord_gender,worldrecord_athlete_name,
    //                 worldrecord_athletics,worldrecord_wind,worldrecord_datetime,worldrecord_country_code,worldrecord_record) 
    //                 values('$sports',
    //                 '".$row1['schedule_location']."'
    //                 ,'".$row1['schedule_gender']."','$name','$newrecord[$i]','"
    //                 .($row1['record_wind']??$row1['record_weight'])."','".$row1['schedule_end']."','".$row1['athlete_country']."','".$row1['record_live_record']."')";
    // }else{
        $sql.="update list_worldrecord set worldrecord_athletics='$newrecord[$i]' where worldrecord_athlete_name='$name' and worldrecord_sports ='$sports' and worldrecord_athletics='$gizone[$i]';";    
    // }
}
echo $sql;
//  execute multi quer
      $db->multi_query($sql);
    echo "<script>
    opener.parent.location.reload();
window.close();
    </script>";
