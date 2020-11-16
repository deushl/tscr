<?php

namespace App\Services;

class arrayTools
{
    /**
     * Simple quick-sort implementation for strings
     *
     * @param   array  $arInput  input array
     *
     * @return  array            sorted array
     */
    public static function quickSortString(array $arInput)
    {
        $arLOE = $arGT = [];

        if (count($arInput) < 2) {
            return $arInput;
        }

        $arPivotKey = key($arInput);
        $pivot = array_shift($arInput);
        
        foreach ($arInput as $item) {
            if (strnatcmp($item, $pivot)  <= 0) {
                $arLOE[] = $item;
            } else {
                $arGT[] = $item;
            }
        }
        return array_merge(
            arrayTools::quickSortString($arLOE),
            array($arPivotKey=>$pivot),
            arrayTools::quickSortString($arGT)
        );
    }
}
