<?php

/**
 * how to use "filter.php"
 * 1. 배열을 생성한다.
 * - 배열명은 "~_dic"으로 통일 요망
 * 2. 원하는 컨텍스트에 따라 변경할 수 있도록 함수를 작성한다.
 * - 입력변수 : key => 반화값 : value
 */

// 성별
$gender_dic = [];
$gender_dic["m"] = "MALE";
$gender_dic["f"] = "FEMALE";
$gender_dic["c"] = "MIX";

// 라운드
$round_dic = [];
$round_dic["예선"] = "TRYOUT";
$round_dic["결승"] = "FINAL";
$round_dic["준결승"] = "SEMI-FINAL";
$round_dic["준준결승"] = "QUARTER-FINAL";

// 통과 상태
$pass_dic = [];
$pass_dic["p"] = "PASS";
$pass_dic["l"] = "FAIL";
$pass_dic["d"] = "DISQUALIFY";
$pass_dic["w"] = "RESIGN";
$pass_dic["n"] = "NOT STARTED";

// 분류
$division_dic = [];
$division_dic["b"] = "MAIN";
$division_dic["s"] = "SUB";

// 장소
$location_dic = [];
$location_dic["A필드"] = "FIELD-A";
$location_dic["B필드"] = "FIELD-B";
$location_dic["중앙트랙"] = "CENTER-TRACK";
$location_dic["예천 공설운동장"] = "YECHEON-STADIUM ";

// 경기 상태
$status_dic = [];
$status_dic["o"] = "OFFICIAL";
$status_dic["l"] = "LIVE";
$status_dic["n"] = "NOT STARTED";

/**
 * DB데이터를 입력받아 원하는 값(한글)로 번역
 *
 * @param [type] $division
 * @return void
 */
function translateDivision($d)
{
    global $division_dic;
    $hasKey = array_key_exists($d, $division_dic);
    return $hasKey ? $division_dic[$d] : "";
}
function translateLocation($l)
{
    global $location_dic;
    $hasKey = array_key_exists($l, $location_dic);
    return $hasKey ? $location_dic[$l] : "";
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
}
function translateRound($r)
{
    global $round_dic;
    $hasKey = array_key_exists($r, $round_dic);
    return $hasKey ? $round_dic[$r] : "";
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
