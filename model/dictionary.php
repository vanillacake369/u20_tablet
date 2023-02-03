<?php

/**
 * OCP 에 대한 코드 리팩토링 요망
 * 1. class 사용하기
 * *제약사항:class는 사용하면 안 됨..*
 * 2. enum에 따른 function composition(array_reduce)사용하기
 * *제약사항:enum은 8.1부터 지원됨..*
 */
$gender = [];
$gender["m"] = "남성";
$gender["f"] = "여성";
$gender["c"] = "혼성";

$pass = [];
$pass["p"] = "통과";
$pass["l"] = "탈락";
$pass["d"] = "실격";
$pass["w"] = "기권";
$pass["n"] = "시작안함";

$division = [];
$division["b"] = "대분류";
$division["b"] = "소분류";

$status = [];
$status["o"] = "공식 결과";
$status["ㅣ"] = "실시간 결과";
$status["n"] = "시작안함";

function translateDivision($division)
{
    if ($division == 'b') {
        return "대분류";
    } else {
        return "소분류";
    }
}
function translateStatus($status)
{
    // official state
    if ($status == 'o') {
        return "공식 결과";
    }
    // live state
    else if ($status == 'l') {
        return "실시간 결과";
    }
    // not started state
    else {
        return "시작안함";
    }
}
function translatePass($pass)
{
    if ($pass == 'p') {
        return "통과";
    } else if ($pass == 'l') {
        return "탈락";
    } else if ($pass == 'd') {
        return "실격";
    } else if ($pass == 'w') {
        return "기권";
    } else {
        return "시작안함";
    }
}
function translateGender($gender)
{

    if ($gender == 'm') {
        return "남성";
    } else if ($gender == 'f') {
        return "여성";
    } else {
        return "혼성";
    }
}

function changeRecordByStatus($status, $live, $official)
{
    // official state
    if ($status == 'o') {
        return $official;
    }
    // live state
    else if ($status == 'l') {
        return $live;
    }
    // not started state
    else {
        return "";
    }
}
function changeResultByStatus($status, $live, $official)
{
    // official state
    if ($status == 'o') {
        return $official;
    }
    // live state
    else if ($status == 'l') {
        return $live;
    }
    // not started state
    else {
        return "";
    }
}
function changeIdByStatus($status, $schedule_id)
{
    // official state
    if ($status == 'o') {
        return "";
    }
    // live state
    else if ($status == 'l') {
        return $schedule_id;
    }
    // not started state
    else {
        return "";
    }
}
