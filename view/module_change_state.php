<?php
//@vanillacake369
/**
 * select box의 이전 선택값 유지하기 위한 함수
 *
 * @param [type] $value : get/post로 넘어온 값
 * @return array|NULL
 */
function maintainSelected($value)
{
    $isSelected = [];
    if (isset($value) && ($value != "non")) {;
        $isSelected[$value] = ' selected';
        return $isSelected;
    } else {
        return NULL;
    }
}
