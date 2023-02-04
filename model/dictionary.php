<?php

/**
 * dictionary DOC
 * 1. 배열을 생성한다. 
 *      - 배열명은 "~_dic"으로 통일 요망
 * 2. 원하는 컨텍스트에 따라 변경할 수 있도록 함수를 작성한다.
 *      - 입력변수 : key => 반화값 : value
 */

// 국가코드(key) => 국가한글명(value)
include_once(__DIR__ . "/../database/dbconnect.php");
$sql = "SELECT DISTINCT country_code,country_name_kr FROM list_country";
$result = $db->query($sql);
while ($row = mysqli_fetch_array($result)) {
    $country_code_dic[$row["country_code"]] = $row["country_name_kr"];
}

// 성별
$gender_dic = [];
$gender_dic["m"] = "남성";
$gender_dic["f"] = "여성";
$gender_dic["c"] = "혼성";

// 통과 상태
$pass_dic = [];
$pass_dic["p"] = "통과";
$pass_dic["l"] = "탈락";
$pass_dic["d"] = "실격";
$pass_dic["w"] = "기권";
$pass_dic["n"] = "시작안함";
$pass_dic["m"] = "남성";

// 분류
$division_dic = [];
$division_dic["b"] = "대분류";
$division_dic["s"] = "소분류";

// 경기 상태
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
/**
 * Undocumented function
 *
 * @param [type] $s
 * @return void
 */
function translateStatus($s)
{
    global $status_dic;
    $hasKey = array_key_exists($s, $status_dic);
    return $hasKey ? $status_dic[$s] : "";
}
/**
 * Undocumented function
 *
 * @param [type] $p
 * @return void
 */
function translatePass($p)
{
    global $pass_dic;
    $hasKey = array_key_exists($p, $pass_dic);
    return $hasKey ? $pass_dic[$p] : "";
}
/**
 * Undocumented function
 *
 * @param [type] $g
 * @return void
 */
function translateGender($g)
{
    global $gender_dic;
    $hasKey = array_key_exists($g, $gender_dic);
    return $hasKey ? $gender_dic[$g] : "";
    return $gender_dic[$g];
}
/**
 * Undocumented function
 *
 * @param [type] $status
 * @param [type] $live
 * @param [type] $official
 * @return void
 */
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
/**
 * Undocumented function
 *
 * @param [type] $status
 * @param [type] $live
 * @param [type] $official
 * @return void
 */
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
/**
 * Undocumented function
 *
 * @param [type] $status
 * @param [type] $id
 * @return void
 */
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
