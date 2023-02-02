<?php
// DB
require_once(__DIR__ . "/../database/dbconnect.php");
// $id : 스케줄 id(<= view_result의 GET[id])
$sql = "SELECT *
        FROM list_record AS r
        INNER JOIN list_schedule AS s
        ON
        r.record_schedule_id = $id
        LEFT JOIN list_athlete AS a
        ON
        r.record_athlete_id = a.athlete_id;";
$result = $db->query($sql);
