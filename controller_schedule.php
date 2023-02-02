<?php
// 접근 제한 컨트롤러 :: 공통
include_once(__DIR__ .  "/controller_block.php");
?>

<!-- head 태그에 각 컨트롤러가 직접 추가할 수 있도록 head를 따로 독립 -->

<head>
    <?php
    // <head>
    include_once(__DIR__ .  "/view/head.php");
    ?>
</head>

<!-- body 태그에 각 컨트롤러가 직접 추가할 수 있도록 body 따로 독립 -->

<body>
    <?php
    // <body>
    include_once(__DIR__ .  "/view/view_schedule.php");
    ?>
</body>

</html>