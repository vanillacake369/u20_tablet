<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../fontawesome/css/all.min.css" />
    <script src="../fontawesome/js/all.min.js"></script>
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../js/restrict.js"></script>
    <?php

    include "../database/dbconnect.php";
    // include_once(__DIR__ . "auth/config.php");
    include_once(__DIR__ . "/../security/security.php");
    $name = $_POST['athlete_name'];
    $sports = $_POST['schedule_sports'];
    $sql = "SELECT worldrecord_athletics FROM list_worldrecord WHERE worldrecord_athlete_name ='$name' AND worldrecord_sports='$sports'";
    $result = $db->query($sql);
    // $row = mysqli_fetch_array($result);
    ?>
</head>


<body>

    <!-- contents 본문 내용 -->
    <div class="container ptop--40">
        <!-- <div class="contents something">-->
        <div class="something">
            <div class="mypage">
                <h3>신기록 유형 바꾸기</h3>
                <hr />
                <form action="./change_result.php" method="post" class="form" id="form_action">
                    <input type="hidden" name="name" value="<?= $name ?>">
                    <input type="hidden" name="sports" value="<?= $sports ?>">
                    <div class="input_row">
                        <span class="input_guide">달성 신기록</span>
                        <?php
                        $count = 1;
                        while ($athletics = mysqli_fetch_array($result)) {
                            $ch = $athletics['worldrecord_athletics'];
                            echo '<input type="hidden" name="gizone[]" value="' . $ch . '">';
                            echo '<div class="select_box" style="margin-right:10px;">
                            <select class="d_select" name="newrecord[]" style="width: 130px;">
                                <option value="n">해당없음</option>
                                <option value="c">대회신기록</option>
                                <option value="a">아시아신기록</option>
                                <option value="s">아시아U20신기록</option>
                                <option value="u">세계U20신기록</option>
                                <option value="w">세계신기록</option>
                            </select>
                            </div>';
                            echo "<script>";
                            switch ($ch) {
                                case "w":
                                    echo "document.querySelectorAll('[value=\"w\"]')[$count].selected=true";
                                    break;
                                case "u":
                                    echo "document.querySelectorAll('[value=\"u\"]')[$count].selected=true";
                                    break;
                                case "s":
                                    echo "document.querySelectorAll('[value=\"s\"]')[$count].selected=true";
                                    break;
                                case "a":
                                    echo "document.querySelectorAll('[value=\"a\"]')[$count].selected=true";
                                    break;
                                case "c":
                                    echo "document.querySelectorAll('[value=\"c\"]')[$count].selected=true";
                                    break;
                            }
                            echo "
                        </script>";
                            $count++;
                        }
                        if ($count === 1) {
                            echo '<input type="hidden" name="gizone[]" value="n">';
                            echo '<div class="select_box" style="margin-right:10px;">
                            <select class="d_select" name="newrecord[]" style="width: 130px;">
                                <option value="n">해당없음</option>
                                <option value="c">대회신기록</option>
                                <option value="a">아시아신기록</option>
                                <option value="s">아시아U20신기록</option>
                                <option value="u">세계U20신기록</option>
                                <option value="w">세계신기록</option>
                            </select>
                        </div>';
                        }
                        ?>
                    </div>
                    <div class="signup_submit">
                        <button type="submit" class="btn_login" name="signup">
                            <span>확인</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</body>




</html>