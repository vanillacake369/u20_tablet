<?php
// DB 연결
include_once(__DIR__ . "/../database/dbconnect.php");

// 국가코드(key) => 국가한글명(value)
$sql = "SELECT DISTINCT country_code,country_name_kr FROM list_country ORDER BY country_name_kr";
$result = $db->query($sql);
while ($row = mysqli_fetch_array($result)) {
    $country_code_dic[$row["country_code"]] = $row["country_name_kr"];
}

// 경기코드(key) => 경기한글명(value)
$sql = "SELECT DISTINCT sports_code,sports_name_kr FROM list_sports ORDER BY sports_code";
$result = $db->query($sql);
while ($row = mysqli_fetch_array($result)) {
    $sports_code_dic[$row["sports_code"]] = $row["sports_name_kr"];
}
