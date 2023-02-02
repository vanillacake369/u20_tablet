<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/print.css" />
    <link rel="stylesheet" href="../fontawesome/css/all.min.css" />
    <script src="..//fontawesome/js/all.min.js"></script>
    <!-- <script>
    window.print()
    </script> -->
    <title>U20</title>
</head>

<body>
    <div class="page">
        <div class="top">
            제 20회 예천아시아 U20 육상경기선수권대회
            <img src="../img/logo.png" alt="Logo" class="logo_img" /></a>
        </div>
        <?php
                include_once "../database/dbconnect.php"; //B:데이터베이스 연결 
                $sql="select schedule_location, schedule_round,schedule_sports,schedule_gender, schedule_date from list_schedule where schedule_name = '".$_POST['gamename']."' and schedule_status='y'";
                $result=$db->query($sql);
                $row = mysqli_fetch_assoc($result);
                ?>
        <div class="middle" style="display:inline-block">
            <p style="margin:10px 0px 0px 0px; text-align:center;">RESULT[경기결과]</p>
            <div style="width: 100%; display: flex;">
                <?php
                    echo '<p style="font-size:12px; width:330px">종목명: '.$_POST['gamename'].'</p>';
                    echo '<p style="font-size:12px; width:330px">위치: '.$row['schedule_location'].'</p>';
                    ?>
            </div>
            <div style="width: 100%; display: flex;">
                <?php
                    echo '<p style="font-size:12px; width:330px">성별: '.$row['schedule_gender'].'</p>';
                    echo '<p style="font-size:12px; width:330px">일자: '.$row['schedule_date'].'</p>';
                    ?>
            </div>
            <div style="width: 100%; display: flex;">
                <?php
                    echo '<p style="font-size:12px; width:330px">라운드: '.$row['schedule_round'].'</p>';
                    echo '<p style="font-size:12px; width:330px">풍속: '.$_POST['wind'].'</p>';
                    ?>
            </div>
            <div class="table_area" style="margin-bottom: 170px;">
                <table width="100%" cellspacing="0" cellpadding="0" class="table table-hover team_table">
                    <colgroup>
                        <col style="width: 5%" />
                        <col style="width: 10%" />
                        <col style="width: 30%" />
                        <col style="width: 10%" />
                        <col style="width: 15%" />
                        <col style="width: 10%" />
                        <col style="width: 15%" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th>순위</th>
                            <th>레인</th>
                            <th>성명</th>
                            <th>국가</th>
                            <th>기록</th>
                            <th>비고</th>
                            <th>신기록</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for($i=0;$i<count($_POST['rank']);$i++){
                            $country=$db->query("select athlete_country from list_athlete where athlete_name ='".$_POST['playername'][$i]."'");
                            // echo "select athlete_country from list_athlete where athlete_name =".$_POST['playername'][$i]."";
                            $row1=mysqli_fetch_array($country);
                            echo'<tr>';
                            echo '<td>'.$_POST['rank'][$i].'</td>';
                            echo '<td>'.$_POST['rain'][$i].'</td>';
                            echo '<td>'.$_POST['playername'][$i].'</td>';
                            echo "<td>$row1[0]</td>";
                            echo '<td>'.$_POST['gameresult'][$i].'</td>';
                            echo '<td>'.$_POST['bigo'][$i].'</td>';
                            echo '<td>'.$_POST['newrecord'][$i].'</td>';
                            echo '</tr>';
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="total">
        <p>종합신기록</p>
        <div class="table_area">
            <table width="100%" cellspacing="0" cellpadding="0" class="table table-hover team_table tab2">
                <colgroup>
                    <col style="width: 20%" />
                    <col style="width: 15%" />
                    <col style="width: 10%" />
                    <col style="width: 30%" />
                    <col style="width: 10%" />
                    <col style="width: 15%" />
                </colgroup>
                <thead>
                    <tr>
                        <th>구분</th>
                        <th>기록</th>
                        <th>풍속</th>
                        <th>성명</th>
                        <th>소속</th>
                        <th>일자</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $world=$db->query("SELECT distinct worldrecord_record,worldrecord_athletics, worldrecord_wind, worldrecord_athlete_name, worldrecord_country_code, worldrecord_datetime 
                                            FROM list_worldrecord a
                                            inner JOIN (SELECT Min(ROUND(cast(worldrecord_record as float),2)) AS MAX_record
                                            FROM list_worldrecord 
                                            WHERE worldrecord_sports ='".$row['schedule_sports']."' AND worldrecord_gender='".$row['schedule_gender']."' 
                                            GROUP BY worldrecord_athletics) b
                                            ON a.worldrecord_record =b.Max_record AND worldrecord_sports ='".$row['schedule_sports']."' AND worldrecord_gender='".$row['schedule_gender']."'  
                                            order by FIELD(worldrecord_athletics, 'w','u','a','s','c')");
                                while($row2=mysqli_fetch_array($world)){
                            echo '<tr>';
                            switch($row2['worldrecord_athletics']){
                                case 'w': echo "<td>세계신기록</td>"; break;
                                case 'u': echo "<td>세계U20신기록</td>"; break;
                                case 's': echo "<td>아시아신기록</td>"; break;
                                case 'a': echo "<td>아시아U20신기록</td>"; break;
                                case 'c': echo "<td>대회신기록</td>"; break;
                                default: echo "<td></td>"; break;
                            }
                            echo '<td>'.$row2['worldrecord_record'].'</td>';
                            echo '<td>'.$row2['worldrecord_wind'].'</td>';
                            echo '<td>'.$row2['worldrecord_athlete_name'].'</td>';
                            echo '<td>'.$row2['worldrecord_country_code'].'</td>';
                            echo '<td>'.$row2['worldrecord_datetime'].'</td>';
                            echo '</tr>';
                        }
                        ?>
                </tbody>
            </table>
        </div>
    </div>
</body>