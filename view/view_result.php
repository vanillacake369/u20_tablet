<?php
// 접근 제한 컨트롤러 :: 공통
include_once(__DIR__ .  "/view_block.php");
?>

<!-- head 태그에 각 컨트롤러가 직접 추가할 수 있도록 head를 따로 독립 -->

<head>
  <?php
  include_once(__DIR__ .  "/head.php");
  ?>
</head>

<body>
  <?php
  // header
  include_once(__DIR__ . "/view_header.php");

  // 경기 상태에 따른 경기 결과 처리 모델
  include_once(__DIR__ . "/../model/model_result_by_state.php");
  include_once(__DIR__ . "/../model/model_match_info_by_state.php");
  // 경기 카테고리에 따른 뷰 주입
  include_once(__DIR__ . "/view_result_config.php");
  // $id : 스케줄 id
  $sports_category = trim($_GET["sports_category"]);
  $schedule_id = trim($_GET["schedule_id"]);
  $result_array = getResultByState($schedule_id);
  $match_info_array = getMatchInfoByState($schedule_id);
  // 경기 소개 h1
  $name = strtoupper($match_info_array[0]["schedule_sports"]);
  $gender = $match_info_array[0]["schedule_gender"];
  $group = $match_info_array[0]["schedule_group"];
  $round = $match_info_array[0]["schedule_round"];
  $match_intro_h1 = $name . " " . $gender . " " . $round . " "  . "GROUP" .  $group;
  ?>

  <div class="limiter">
    <div class="container-table100">
      <div class="wrap-table100">
        <!-- 경기 관련 내용 View 테이블 -->
        <div class="table-wrap">
          <?php echo "<h2 class=\"intro\">$match_intro_h1</h2>" ?>
          <table>
            <colgroup>
              <col style="width: auto" />
            </colgroup>
            <thead>
              <tr>
                <th>CATEGORY</th>
                <th>EVENTS</th>
                <th>GENDER</th>
                <th>DATE</th>
                <th>TIME</th>
                <th>ROUND</th>
                <th>GROUP</th>
                <th>REFEREE</th>
                <th>DUTY</th>
              </tr>
            </thead>
            <tbody>
              <?php
              /** @var object $match_info_array */
              foreach ($match_info_array as $match_info) {
                echo "<tr>";
                echo "<td>" . trim($match_info["sports_category"]) . "</td>";
                echo "<td>" . trim($match_info["sports_name_kr"]) . "</td>";
                echo "<td>" . trim($match_info["schedule_gender"]) . "</td>";
                echo "<td>" . trim($match_info["schedule_date"]) . "</td>";
                echo "<td>" . trim($match_info["schedule_start"]) . "</td>";
                echo "<td>" . trim($match_info["schedule_round"]) . "</td>";
                echo "<td>" . trim($match_info["schedule_group"]) . "</td>";
                echo "<td>" . trim($match_info["judge_name"]) . "</td>";
                echo "<td>" . trim($match_info["judge_duty"]) . "</td>";
                echo "</tr>";
              }
              ?>

            </tbody>
          </table>
        </div>
        <!-- 뷰 갈아끼우기 -->
        <?php
        getResultViewService($sports_category);
        ?>
        </tbody>
        </table>
      </div>
    </div>
  </div>
  </div>

  <script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
  <script src="../vendor/bootstrap/js/popper.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="../vendor/select2/select2.min.js"></script>
  <script src="../js/main.js"></script>
</body>

</html>