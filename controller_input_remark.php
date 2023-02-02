<?php
// 접근 제한 컨트롤러 :: 공통
include_once(__DIR__ .  "/controller_block.php");
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <?php
    include_once(__DIR__ .  "/view/head.php");
    ?>
</head>

<body>
    <?php
    /**
     * @param mixed $_GET 
     * - "remark_category" = result : schedule
     * - "id" = record_id : schedule_id
     * 
     * remark_category , id에 따라 코드 갈아끼울 수 있게 만들기
     * 
     * 
     * (+a. 여기서는 DIP,OCP를 어떻게 지켜야 하나!?! 
     * **모델을 쓰지 못 하니까 못 지킨다??
     * 그러면 모델을 쓰지 못 하게 되면 아예 5원칙은 어길 수 밖에 없게되나? 
     * 그건 아닐 거 같은데...방법이 있을 거 같은데...*)
     */
    ?>
    <div class="container">
        <div class="something_1">
            <div class="mypage">
                <h3>선수 정보 등록</h3>
                <hr />
                <form action="./module/athlete_Insert.php" method="post" class="form" enctype="multipart/form-data">
                    <div class="input_row">
                        <div class="text-center">
                            <h6>새로운 이미지를 선택해주세요</h6>
                            <input type="file" name="athlete_imgFile" class="form-control" />
                        </div>
                    </div>
                    <div class="input_row">
                        <span class="input_guide">이름</span>
                        <input type="text" name="athlete_second_name" id="athlete_name" value="" class="input_text_row" placeholder="이름을 입력해 주세요" required />
                    </div>
                    <div class="input_row">
                        <span class="input_guide">성</span>
                        <input type="text" name="athlete_first_name" id="athlete_name" value="" class="input_text_row" placeholder="성을 입력해 주세요" required />
                    </div>
                    <div class="input_row">
                        <span class="input_guide">국가</span>
                        <div class="select_box">
                            <select class="d_select" name="athlete_country" style="width: 150px;" required>
                                <option value='' selected disabled hidden>국가 선택</option>
                                <?php
                                foreach ($country_code_dic as $key => $value)
                                    echo "<option value=" . $value . ">" . $key . "</option>";
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="input_row">
                        <span class="input_guide">지역</span>
                        <input type="text" name="athlete_division" id="athlete_division" value="" class="input_text_row" placeholder="지역을 입력해 주세요" required />
                    </div>
                    <div class="input_row">
                        <span class="input_guide">소속</span>
                        <input type="text" name="athlete_region" id="athlete_region" value="" class="input_text_row" placeholder="소속을 입력해 주세요" required />
                    </div>
                    <div class="input_row">
                        <span class="input_guide">성별</span>
                        <div class="select_box">
                            <select class="d_select" name="athlete_gender" style="width: 100px;" required>
                                <option value='' selected disabled hidden>성별 선택</option>
                                <option value="m">남자</option>
                                <option value="f">여자</option>
                            </select>
                        </div>
                    </div>
                    <div class="input_row">
                        <span class="input_guide">생년월일</span>
                        <input type="text" name="athlete_birth_year" class="input_text_row_b" placeholder="연" required>
                        <input type="text" name="athlete_birth_month" class="input_text_row_b" placeholder="월" required>
                        <input type="text" name="athlete_birth_day" class="input_text_row_b" placeholder="일" required>
                    </div>
                    <div class="input_row">
                        <span class="input_guide">나이</span>
                        <input type="text" name="athlete_age" id="athlete_age" value="" class="input_text_row" placeholder="나이를 입력해 주세요" required />
                    </div>
                    <div class="input_row">
                        <span class="input_guide">참가경기</span>
                        <div class="attendent_game">
                            <div class="input_row">
                                <?php
                                // for ($value = 1; $value <= count($sport_dic); $value++) {
                                //     if ($value % 3 == 1) {
                                //         echo '<div class="form_check">';
                                //     }
                                //     echo "<label>";
                                //     echo '<input type="checkbox" name="athlete_schedules[]"' . 'value="' . key($sport_dic) . '"' . 'id="' . current($sport_dic) . '"/>';
                                //     echo "<span>" . current($sport_dic) . "</span>";
                                //     echo "</label>";
                                //     if ($value % 3 == 0) {
                                //         echo '</div>';
                                //     }
                                //     next($sport_dic);
                                // }
                                // reset($sport_dic);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <span class="input_guide">참석경기</span>
                        <div class="attendent_game">
                            <div class="input_row">
                                <?php
                                // for ($value = 1; $value <= count($sport_dic); $value++) {
                                //     if ($value % 3 == 1) {
                                //         echo '<div class="form_check">';
                                //     }
                                //     echo "<label>";
                                //     echo '<input type="checkbox" name="attendance_sports[]"' . 'value="' . key($sport_dic) . '"' . 'id="' . current($sport_dic) . '"/>';
                                //     echo "<span>" . current($sport_dic) . "</span>";
                                //     echo "</label>";
                                //     if ($value % 3 == 0) {
                                //         echo '</div>';
                                //     }
                                //     next($sport_dic);
                                // }
                                // reset($sport_dic);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="btn_base base_mar col_right">
                        <button type="submit" class="btn_add" name="athlete_edit">
                            <span class="btn_txt bold">확인</span>
                        </button>
                    </div>
                    <script src="jquery-3.2.1.min.js" type="text/javascript"></script>
                    <script src="chosen.jquery.js" type="text/javascript"></script>
                    <script src="prism.js" type="text/javascript" charset="utf-8"></script>
                    <script src="init.js" type="text/javascript" charset="utf-8"></script>
                </form>
            </div>
        </div>
    </div>

    <script src="docsupport/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="chosen.jquery.js" type="text/javascript"></script>
    <script src="docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
    <script src="docsupport/init.js" type="text/javascript" charset="utf-8"></script>
</body>

</html>