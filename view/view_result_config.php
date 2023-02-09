<?php
// schedule_sports(key) => track,relay...(value)
$sports_category_dic = [];
// field
$sports_category_dic["discusthrow"] = "field";
$sports_category_dic["hammerthrow"] = "field";
$sports_category_dic["javelinthrow"] = "field";
$sports_category_dic["polevault"] = "field";
$sports_category_dic["shotput"] = "field";
// track
$sports_category_dic["10000m"] = "track";
$sports_category_dic["100m"] = "track";
$sports_category_dic["100mh"] = "track";
$sports_category_dic["110mh"] = "track";
$sports_category_dic["1500m"] = "track";
$sports_category_dic["200m"] = "track";
$sports_category_dic["3000m"] = "track";
$sports_category_dic["3000mSC"] = "track";
$sports_category_dic["400m"] = "track";
$sports_category_dic["400mh"] = "track";
$sports_category_dic["5000m"] = "track";
$sports_category_dic["800m"] = "track";
$sports_category_dic["racewalk"] = "track";
// 종합 : 종합 > 라운드 == 100m,멀리뛰기...등등
// $sports_category_dic["decathlon"] = "track";
// $sports_category_dic["heptathlon"] = "track";
// relay
$sports_category_dic["4x100mR"] = "relay";
$sports_category_dic["4x400mR"] = "relay";
// long_jump
$sports_category_dic["triplejump"] = "long_jump";
$sports_category_dic["longjump"] = "long_jump";
// high_jump
$sports_category_dic["highjump"] = "high_jump";


/**
 * 스케줄 페이지 > 경기결과 양식에 대한 링크 html 생성 함수
 * @param [type] $schedule_sports   
 * @param [type] $schedule_id
 * @return void
 */
function getResultLink($schedule_sports, $schedule_id)
{
    global $sports_category_dic;
    $sports_category = $sports_category_dic[$schedule_sports];

    $link = "<td><a href='view_result.php?sports_category=" . $sports_category . "&schedule_id=" . trim($schedule_id) . "'>VIEW RESULT</a></td>";
    // 일부러 view_result로 가게끔 했다! 뷰를 갈아끼우는 핸들러 역할 레이어가 view_result이다!
    /**
     * Ex) echo "<td><a href='view_result.php?sports_category=track&schedule_id=" . trim($schedule["schedule_id"]) . "'>결과 보기</a></td>";
     * - view_result : 결과 출력 페이지
     *  - $_GET["sports_category"] : 카테고리 구분
     *  - $_GET["schedule_id"] : 스케줄 id값
     */
    return $link;
}
/**
 * 카테고리 입력값에 따른 뷰 주입 함수
 *
 * @param [type] $sports_category
 * @return void
 */
function getResultViewService($sports_category)
{

    /**
     * $sports_category
     *  ==(toss)==> view_result_config 
     *    ==(call suitable service)==> view_result_service
     * 
     * **WHY NOT USE eval()?**
     * > do not use eval() since it's speed issue, 
     * > and most of all, eval() run any php code it is given
     */
    if ($sports_category == "track") {
        include(__DIR__ . "/view_track.php");
    } else if ($sports_category == "relay") {
        include(__DIR__ . "/view_relay.php");
    } else if ($sports_category == "field") {
        include(__DIR__ . "/view_field.php");
    } else if ($sports_category == "long_jump") {
        include(__DIR__ . "/view_long_jump.php");
    } else {
        include(__DIR__ . "/view_high_jump.php");
    }
}
function getInputResultViewService($sports_category)
{

    /**
     * $sports_category
     *  ==(toss)==> view_result_config 
     *    ==(call suitable service)==> view_result_service
     * 
     * **WHY NOT USE eval()?**
     * > do not use eval() since it's speed issue, 
     * > and most of all, eval() run any php code it is given
     */
    if ($sports_category == "track") {
        include(__DIR__ . "/view_input_track.php");
    } else if ($sports_category == "relay") {
        include(__DIR__ . "/view_input_relay.php");
    } else if ($sports_category == "field") {
        include(__DIR__ . "/view_input_field.php");
    } else if ($sports_category == "long_jump") {
        include(__DIR__ . "/view_input_long_jump.php");
    } else {
        include(__DIR__ . "/view_input_high_jump.php");
    }
}
