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

<!-- body 태그에 각 컨트롤러가 직접 추가할 수 있도록 body 따로 독립 -->

<body>
    <?php
    // header
    include_once(__DIR__ .  '/view_header.php');

    // 경기 스케줄 가져오기
    include_once(__DIR__ . "/../model/model_schedule_by_state.php");
    include_once(__DIR__ . "/../model/model_result_by_state.php");
    // 번역 딕셔너리 사용
    include_once(__DIR__ . "/../model/dictionary.php");
    // 비고 카테고리
    $remark_category = $_GET["remark_category"];
    // 카테고리에 따른 id
    if (isset($_GET["schedule_id"])) {
        $id = $_GET["schedule_id"];
    } else {
        $id = $_GET["record_id"];
    }
    // 카테고리에 따른 비고 내용 가져오기
    $judge_account = trim($_SESSION["Id"]);
    if ($remark_category == "result") {
        $result_array = getRecordByState($id);
        $memo = $result_array[0]["record_memo"];
    } else {
        $schedule_array = getScheduleByState($judge_account);
        $memo = $schedule_array[0]["schedule_memo"];
    }
    /**
     * @param mixed $_GET 
     * - "remark_category" = result : schedule
     * - "id" = record_id : schedule_id
     */
    ?>
    <div class="limiter">
        <div class="container-table100">
            <div class="wrap-table100">
                <div class="table-wrap">
                    <h3>INSERT REMARK</h3>
                    <hr />
                    <form action="../model/model_remark.php" method="post" class="memo_form">
                        <?php
                        // 비고 입력란
                        echo "<textarea type=\"text\" name=\"memo\"  value=\"\" class=\"memo\" placeholder=\"\" required />$memo</textarea>";
                        echo "<input type=\"hidden\" name=\"remark_category\" value=\"$remark_category\">";
                        echo "<input type=\"hidden\" name=\"id\" value=\"$id\">";
                        ?>
                        <div class="container_postbtn">
                            <div class="postbtn_like">
                                <div class="like_btn">
                                    <button type="submit" class="btn_navy btn_memo" name="done">
                                        <span class="btn_txt bold">확인</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="container_postbtn">
                        <div class="postbtn_like">
                            <div class="like_btn">
                                <button class="btn_grey btn_memo" name="back" onclick="history.back()">
                                    <span class="btn_txt bold">뒤로 가기</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="docsupport/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="chosen.jquery.js" type="text/javascript"></script>
    <script src="docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
    <script src="docsupport/init.js" type="text/javascript" charset="utf-8"></script>
</body>

</html>