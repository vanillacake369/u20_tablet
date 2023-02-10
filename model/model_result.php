<?php
// DB
include_once(__DIR__ . "/../database/dbconnect.php");
function getResult($schedule_id)
{
        global $db;
        $sql = "SELECT *
                FROM list_record AS r
                LEFT OUTER JOIN list_athlete AS a
                ON
                r.record_athlete_id = a.athlete_id
                WHERE a.athlete_id IS NOT NULL AND r.record_schedule_id = $schedule_id";
        $result = $db->query($sql);
        return $result;
}
function getRecordByRecordId($record_id)
{
        global $db;
        $sql = "SELECT *
                FROM list_record AS r
                WHERE r.record_id = $record_id";
        $result = $db->query($sql);
        return $result;
}
