<?php
$variables = [
    // 'host' => 'localhost', // DB 호스트
    // 'dbname' => 'u20_db', // 데이터베이스 이름
    // 'user' => 'jihoon', // 데이터베이스  유저
    // 'pw' => '1026baby' // 데이터베이스 유저 비밀번호
    'host' => '220.69.240.140', // DB 호스트
    'dbname' => 'u20_db', // 데이터베이스 이름
    'user' => 'jihoon', // 데이터베이스  유저
    'pw' => '1026baby' // 데이터베이스 유저 비밀번호
];

foreach ($variables as $key => $value) {
    putenv("$key=$value");
}
