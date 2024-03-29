<?php
require_once "./authCheck.php";

if (!isset($_POST['id']) || $_POST['id'] == "") {
    mysqli_close($db);
    echo '<script>alert("아이디를 입력하세요");history.back();</script>';
    exit;
} else if (!isset($_POST['pw']) || $_POST['pw'] == "") {
    mysqli_close($db);
    echo '<script>alert("비밀번호를 입력하세요");history.back();</script>';
    exit;
} else {

    $id = trim($_POST['id']);
    $pw = trim($_POST['pw']);
    $session = md5(time() . $id);
    $_SERVER['REMOTE_ADDR'] == '::1' ? $ip_add = '127.0.0.1' : $ip_add = $_SERVER['REMOTE_ADDR'];
    $currentDate = date('Y-m-d H:i:s');

    // get pw of judge, and compare
    $judgesql = " SELECT * FROM list_judge WHERE judge_account = '" . $id . "';";
    $judgerow = $db->query($judgesql);
    $judgedata = mysqli_fetch_array($judgerow);
    $db_pw = $judgedata['judge_password'];
    $pw = hash("sha256", $pw);
    if ($db_pw == $pw) {
        $sql = "UPDATE list_judge SET judge_latest_datetime = ?, judge_latest_ip= ?, judge_latest_session = ? WHERE judge_account = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ssss", $currentDate, $ip_add, $session, $id);
        $stmt->execute();

        mysqli_close($db);
        session_start();
        $_SESSION['Id'] = $id;
        $_SESSION['schedule'] = $judgedata['judge_schedule'];
        $_SESSION['Session'] = $session;
        echo "<script>alert('로그인되었습니다.'); location.href='../view/view_schedule.php';</script>";
        exit;
    } else {
        mysqli_close($db);
        echo "<script>alert('아이디 혹은 비밀번호를 확인하세요.'); history.back();</script>";
    }
}
