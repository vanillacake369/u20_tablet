<body>
    <?php
    // header
    include_once 'header.php';
    // 경기 스케줄 가져오기
    require_once(__DIR__ . "/../model/model_schedule.php");
    ?>

    <div class="limiter">
        <div class="container-table100">
            <div class="wrap-table100">
                <div class="table-wrap">
                    <table>
                        <colgroup>
                            <col style="width: auto" />
                        </colgroup>
                        <thead>
                            <tr>
                                <th>순위</th>
                                <th>선수명</th>
                                <th>성별</th>
                                <th>레인번호</th>
                                <th>국가</th>
                                <th>기록</th>
                                <th>통과</th>
                                <th>상태</th>
                                <th>입력</th>
                                <th>비고</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>3</td>
                                <td>Jinho KIM</td>
                                <td>Male</td>
                                <td>3</td>
                                <td>Korea</td>
                                <td>00:01:23</td>
                                <td>O</td>
                                <td>Live</td>
                                <td><a href="./controller_result.php">입력</a></td>
                                <td></td>
                            </tr>
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
</body>