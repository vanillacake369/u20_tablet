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
// 종합경기의 라운드 컬럼(key)에 경기분류(value)를 저장
// track
$round_dic["10000m"] = "10000m";
$round_dic["100m"] = "100m";
$round_dic["100m 허들"] = "100m hurdles";
$round_dic["110m 허들"] = "110m hurdles";
$round_dic["1500m"] = "1500m";
$round_dic["200m"] = "200m";
$round_dic["3000m"] = "3000m";
$round_dic["3000m 장애물"] = "3000m";
$round_dic["400m"] = "400m";
$round_dic["400m 허들"] = "400m hurdles";
$round_dic["5000m"] = "5000m";
$round_dic["800m"] = "800m";
$round_dic["경보"] = "race walk";
// relay
$round_dic["4x100 릴레이"] = "4x100 relay";
$round_dic["4x400 릴레이"] = "4x400 relay";
// field
$round_dic["원반던지기"] = "discus throw";
$round_dic["해머던지기"] = "hammer throw";
$round_dic["창던지기"] = "javelin throw";
$round_dic["장대 높이뛰기"] = "pole vault";
$round_dic["투포환"] = "shot put";
// high_jump
$round_dic["높이뛰기"] = "high jump";
// long_jump
$round_dic["멀리뛰기"] = "long jump";
$round_dic["세단뛰기"] = "long jump";


// 통과 상태
$pass_dic = [];
$pass_dic["p"] = "PASS";
$pass_dic["l"] = "FAIL";
$pass_dic["d"] = "DISQUALIFY";
$pass_dic["w"] = "RESIGN";
$pass_dic["n"] = "NOT STARTED";

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

// 경기 카테고리
$category_dic = [];
$category_dic["트랙경기"] = "TRACK";
$category_dic["종합경기"] = "COMBINED";
$category_dic["필드경기"] = "FIELD";



function translateLocation($l)
{
    global $location_dic;
    $hasKey = array_key_exists($l, $location_dic);
    return $hasKey ? $location_dic[$l] : "";
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
}
function translateRound($r)
{
    global $round_dic;
    $hasKey = array_key_exists($r, $round_dic);
    return $hasKey ? $round_dic[$r] : "";
}
function translateCategory($c)
{
    global $category_dic;
    $hasKey = array_key_exists($c, $category_dic);
    return $hasKey ? $category_dic[$c] : "";
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
