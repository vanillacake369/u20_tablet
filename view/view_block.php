<?php
include_once(__DIR__ . "/../auth/authCheck.php");

// 에러 메세지 출력 제한 :: 배포 시 무조건 기능 풀어줄 것
// ini_set('display_errors', '0');

// 세션
if (session_id() == '') {
    session_start();
}

// 접근 제한 :: 배포 시 무조건 기능 풀어줄 것
// $session = $_SESSION["Session"];
// block($_SERVER['HTTP_REFERER'] == '');
// block(!isSetSession($session));
// block(!isLatestSession($db, $session));

/**
 * URL 입력 접근 제어
 *
 * @param [type] $isNotAuthorized
 * @return void
 */
function block($isNotAuthorized)
{
    if ($isNotAuthorized == true) {
        exit("<script>
            alert('잘못된 접근입니다.');
            window.location.href = '../index.php';</script>");
    }
}
