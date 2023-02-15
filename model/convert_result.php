<?php
function changeresult($a)
{ //1분이상 경기 기록 변환
    if (strlen($a) > 6) {
        $a = explode(':', $a);
        $a = (float)$a[0] * 60 + (float)$a[1];
    } else {
        $a = (float)$a;
    }
    echo $a . '<br>';
    return $a;
}
