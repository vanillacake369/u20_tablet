<?php
// header
include_once(__DIR__ . "/view_header.php");

include_once(__DIR__ . "/../model/model_result_by_state.php");

// model_result_by_state에서 결과 가져오기
$id = trim($_GET["id"]);
$result_array = getResultByState($id);
?>

<div class="limiter">
  <div class="container-table100">
    <div class="wrap-table100">
      <!-- 경기 관련 내용 View 테이블 -->
      <div class="table-wrap">
        <table>
          <colgroup>
            <col style="width: auto" />
          </colgroup>
          <thead>
            <tr>
              <th>종목명</th>
              <th>경기명</th>
              <th>경기 성별</th>
              <th>날짜</th>
              <th>시작시간</th>
              <th>라운드</th>
              <th>심판명</th>
              <th>역할</th>
              <th>비고</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>트랙경기</td>
              <td>400m 달리기</td>
              <td>혼성</td>
              <td>MM.DD</td>
              <td>hh:mm:ss</td>
              <td>결승</td>
              <td>ITO</td>
              <td>국제기술임원</td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="table-wrap">
        <table>
          <colgroup>
            <col style="width: auto" />
          </colgroup>
          <thead>
            <tr>
              <th>레인번호</th>
              <th>선수명(팀명)</th>
              <th>성별</th>
              <th>국가</th>
              <th>소속</th>
              <th>기록</th>
              <th>순위</th>
              <th>통과</th>
              <th>상태</th>
              <th>입력</th>
              <th>비고</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $num = 0;
            foreach ($result_array as $result) {
              echo "<tr>";
              // 레인번호
              echo "<td>" . $result["record_order"] . "</td>";
              // 선수명(팀명)
              echo "<td>" . $result["athlete_name"] . "</td>";
              // 선수 성별
              echo "<td>" . $result["schedule_gender"] . "</td>";
              // 국가
              echo "<td>" . $result["athlete_country"] . "</td>";
              // 소속
              echo "<td>" . $result["athlete_division"] . "</td>";
              // 기록
              echo "<td>" . $result["record_live_record"] . "</td>";
              // 순위
              echo "<td>" . $result["record_live_result"] . "</td>";
              // 통과
              echo "<td>" . $result["record_pass"] . "</td>";
              // 경기 상태(Official, Result..)
              echo "<td>" . $result["record_status"] . "</td>";
              // 경기 결과 입력
              echo "<td><a href='/../controller_input_result.php?id=" . trim($result["schedule_id"]) . "'>결과 입력</a></td>";
              // 경기 비고
              echo "<td><a href='/../controller_input_remark.php?remark_category=result&id=" . trim($result["schedule_id"]) . "'>비고 입력</a></td>";

              echo "</tr>";
            }

            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="vendor/bootstrap/js/popper.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/select2/select2.min.js"></script>
<script src="js/main.js"></script>