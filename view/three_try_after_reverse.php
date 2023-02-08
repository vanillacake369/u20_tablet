<?php
// TODO 구현은 완료했는데 엄청난 복잡도로 인해 많은 버그 예상, 테스트 케이스 많이 돌려보기
include_once(__DIR__ . "auth/config.php");
include_once(__DIR__ . "./save.php");
global $schedule_id;
global $judge_id;
global $db;
global $trial_count;

/**
 *  1. 1,2,3차 선수 기록, 순위, 유효시기, 고유ID 정보 들고오기
 * 2. 순위별 선수 최고 기록 저장 (유효시기 확인)
 * 3. 순위별 선수 유효 시기 몇 회 인지 확인 저장
 * 4. 동 순위별 순서 배정 (limit 8)
 * 5. 유효시기 확인
 * 6. 그래도 동기록이면 추첨
 * 7. 결과 반환
 */
// 투척 경기 결승
// https://media.aws.iaaf.org/competitiondocuments/pdf/7137279/AT-HT-M-f----.RS6.pdf?v=-1969698041

if ($trial_count === "3") {
    $QUERY = "SELECT *
              FROM list_record
              WHERE record_schedule_id = '" . $schedule_id . "' AND record_trial BETWEEN 1 AND 3
              ORDER BY record_live_record DESC";
} else if ($trial_count === "5") {
    $QUERY = " SELECT *
              FROM list_record
              WHERE record_schedule_id = '" . $schedule_id . "' AND record_trial BETWEEN 4 AND 5
              ORDER BY record_live_record DESC";
}
$result = $db->query($QUERY);

$ID_info = array();
$ID_check = array();
$rank = array();

$i = 0;
$wait = 0;
while ($row = mysqli_fetch_array($result)) {
    if ($row["record_pass"] == "p") {
        if ($wait == 8) break;
        $count = count($ID_info);
        $ID_info[$i] = $row["record_athlete_id"];
        $ID_info = array_unique($ID_info);
        $count2 = count($ID_info);

        if ($count != $count2) {
            $ID_check[$wait] = $row;
            $rank[$wait] = $row['record_live_record'];
            $wait++;
        }
        $i++;
    }
}

/**
 * 1. i -> 1등부터 기록 들고오기
 * 2. 같은 기록이 있는지 8번 확인
 * 3. 없으면 순위 배정 (다시 반복으로)
 * 3-2. 있으면 cnt++ -> 안 반복 다시 확인 (동일 기록) 몇개가 같은지? 같은 개수 만큼 cnt 반환
 * 3-3. 동기록을 따로 배열에 저장
 * 3-4. 동기록에 따른 시기 순으로 배열 정렬
 * 3-5. 동기록의 동시기를 확인
 * 3-6. 있으면 cnt2++ -> 동기록 동시기인 데이터를 따로 배열에 또 저장
 * 3-7. 추첨
 * 3-8. 따로 저장한 동시기 배열을 다시 동기록 배열에 붙여넣기
 * 3-9. cnt2++된 변수만큼 j를 plus 처리해서 다시 반복실행
 * 4. 따로 저장한 동기록 배열을 다시 원래 배열에 붙여 넣기
 * 5. cnt++ 된 변수만큼 i를 plus 처리해서 다시 반복실행
 */
$new_rank = array();
// 1번
for ($i = 0; $i < count($ID_check); $i++) {
    $cnt = 0;
    // 2번
    for ($j = $i + 1; $j < count($ID_check); $j++) {
        if ($ID_check[$i]['record_live_record'] === $rank[$j]) $cnt++;
    }
    // 3-2번
    if ($cnt !== 0) {
        // 3-3번
        $record_duplicate = array_slice($ID_check, $i, $cnt + 1);
        $ID_check = array_udiff($ID_check, $record_duplicate, function ($data1, $data2) {
            return $data1['record_athlete_id'] - $data2['record_athlete_id'];
        });
        // 3-4번
        usort($record_duplicate, function (array $data1, array $data2) {
            if ($data1['record_trial'] === $data2['record_trial']) return 0;
            return $data1['record_trial'] < $data2['record_trial'] ? -1 : 1;
        });
        // 3-5번
        for ($m = 0; $m < count($record_duplicate); $m++) {
            $cnt2 = 0;
            for ($n = $m + 1; $n < count($record_duplicate); $n++) {
                if ($record_duplicate[$m]['record_trial'] === $record_duplicate[$n]['record_trial']) $cnt2++;
            }
            // 3-6번
            if ($cnt2 !== 0) {
                $trial_duplicate = array_slice($record_duplicate, $m, $cnt2 + 1);
                $record_duplicate = array_udiff($record_duplicate, $trial_duplicate, function ($data1, $data2) {
                    return $data1['record_athlete_id'] - $data2['record_athlete_id'];
                });
                // 3-7번
                shuffle($trial_duplicate);
                // 3-8번
                $trial_duplicate = array_reverse($trial_duplicate);
                foreach ($trial_duplicate as $value) {
                    array_splice($record_duplicate, $m, 0, array($value));
                }
            }
            // 3-9번
            $m = $m + $cnt2;
        }
        // 4번
        $record_duplicate = array_reverse($record_duplicate);
        foreach ($record_duplicate as $value) {
            array_splice($ID_check, $i, 0, array($value));
        }
    }
    // 5번
    $i = $i + $cnt;
}

$ID_check = array_reverse($ID_check);
// $insert_sql = "INSERT INTO `list_record` 
//     (`record_athlete_id`, 
//      `record_schedule_id`, 
//      `record_pass`, 
//      `record_live_result`,
//      `record_official_result`,
//      `record_live_record`, 
//      `record_official_record`,
//      `record_new`,
//      `record_memo`, 
//      `record_medal`, 
//      `record_order`,
//      `record_judge`,
//      `record_trial`,
//      `record_wind`,
//      `record_group`) 
//     VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

$update_sql = "UPDATE list_record 
               SET record_order = ? 
               WHERE record_athlete_id = ? AND record_schedule_id = ? AND record_trial = ?
              ";

if ($trial_count === '3') { # 3회차 후 버튼을 눌렀을 때 실행
    for ($record_trial = 4; $record_trial <= 6; $record_trial++) {
        $record_order = 1;
        foreach ($ID_check as $value) {
            $stmt = $db->prepare($update_sql);
            $stmt->bind_param("iiii", $record_order, $value['record_athlete_id'], $value['record_schedule_id'], $record_trial);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            $record_order++;
        }
    }
} elseif ($trial_count === '5') { # 5회차 후 실행했을 때
    $record_order = 1;
    $six = 6;
    foreach ($ID_check as $value) {
        $stmt = $db->prepare($update_sql);
        $stmt->bind_param("iiii", $record_order, $value['record_athlete_id'], $value['record_schedule_id'], $six);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $record_order++;
    }
}

# 이전 URL 로 schedule_id를 post 해주는 코드 
echo '<script>alert("성공적으로 저장되었습니다");</script>';
echo '&nbsp';
echo '<script>
               const form = document.createElement("form");
               form.setAttribute("method", "post");
               form.setAttribute("action", "' . $_SERVER['HTTP_REFERER'] . '");
               const hidden_field = document.createElement("input");
               hidden_field.setAttribute("type", "hidden");
               hidden_field.setAttribute("name", "schedule_id");
               hidden_field.setAttribute("value","' . $schedule_id . '");
               const hidden_count = document.createElement("input");
               hidden_count.setAttribute("type", "hidden");
               hidden_count.setAttribute("name", "check");
               hidden_count.setAttribute("value","' . $trial_count . '");
               form.appendChild(hidden_count);
               form.appendChild(hidden_field);
               document.body.appendChild(form);
               form.submit();
               console.log("asdf");
      </script>';
