<?php

/**
 * OCP 에 대한 코드 리팩토링 요망
 * 1. class 사용하기
 * *제약사항:class는 사용하면 안 됨..*
 * 2. enum에 따른 function composition(array_reduce)사용하기
 * *제약사항:enum은 8.1부터 지원됨..*
 */


// 국가코드(key) => 국가한글명(value)
include_once(__DIR__ . "/../database/dbconnect.php");
$sql = "SELECT DISTINCT country_code,country_name_kr FROM list_country";
$result = $db->query($sql);
while ($row = mysqli_fetch_array($result)) {
    $country_code_dic[$row["country_code"]] = $row["country_name_kr"];
}

$gender_dic = [];
$gender_dic["m"] = "남성";
$gender_dic["f"] = "여성";
$gender_dic["c"] = "혼성";

$pass_dic = [];
$pass_dic["p"] = "통과";
$pass_dic["l"] = "탈락";
$pass_dic["d"] = "실격";
$pass_dic["w"] = "기권";
$pass_dic["n"] = "시작안함";
$pass_dic["m"] = "남성";

$division_dic = [];
$division_dic["b"] = "대분류";
$division_dic["s"] = "소분류";

$status_dic = [];
$status_dic["o"] = "공식 결과";
$status_dic["l"] = "실시간 결과";
$status_dic["n"] = "시작안함";
/**
 * DB데이터를 입력받아 원하는 값(한글)로 번역 
 *
 * @param [type] $division
 * @return void
 */
function translateScheduleDivision($d)
{
    global $division_dic;
    $hasKey = array_key_exists($d, $division_dic);
    return $hasKey ? $division_dic[$d] : "";
}
function translateStatus($s)
{
    global $status_dic;
    $hasKey = array_key_exists($s, $status_dic);
    return $hasKey ? $status_dic[$s] : "";
}
function translatePass($p)
{
    global $pass_dic;
    $hasKey = array_key_exists($p, $pass_dic);
    return $hasKey ? $pass_dic[$p] : "";
}
function translateGender($g)
{
    global $gender_dic;
    $hasKey = array_key_exists($g, $gender_dic);
    return $hasKey ? $gender_dic[$g] : "";
    return $gender_dic[$g];
}

function changeRecordByStatus($status, $live, $official)
{
    // official state
    if ($status == "o") {
        return $official;
    }
    // live state
    else if ($status == "l") {
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
    if ($status == "o") {
        return $official;
    }
    // live state
    else if ($status == "l") {
        return $live;
    }
    // not started state
    else {
        return "";
    }
}
function changeIdByStatus($status, $id)
{
    // official state
    if ($status == "o") {
        return "";
    }
    // live state
    else if ($status == "l") {
        return $id;
    }
    // not started state
    else {
        return "";
    }
}
