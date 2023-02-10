<?php
// LOG
// DB
include_once(__DIR__ . "/../database/dbconnect.php");
// POST 
$memo = $_POST["memo"];
$remark_category = $_POST["remark_category"];
$memo = $_POST["memo"];
$id = $_POST["id"];

// CHANGE SQL BY CATEGORY
if ($remark_category == "schedule") {
        $sql = 'UPDATE list_schedule SET schedule_memo = ? WHERE schedule_id = ?;';
} else {
        $sql = 'UPDATE list_record SET record_memo = ? WHERE record_id = ?;';
}
// UPDATE
$stmt = $db->prepare($sql);
$stmt->bind_param("ss", $memo, $id);
$stmt->execute();

// logInsert($db, $_SESSION['Id'], '', $athlete_name . "-" . $athlete_country . "-" . $athlete_schedule);

echo "<script>
alert('REMARK CONFIRMED');
history.go(-2);
</script>";
