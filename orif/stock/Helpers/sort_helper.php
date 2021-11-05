<?php 

/**
 * Sorts an array through a subarray's value
 * @author Pigalev Pavel on StackOverflow
 *
 * @param array $array - Array to sort
 * @param string $value - Key of the value to sort by, will make errors if invalid (ex: "ssssss");
 * @param bool $asc - ASC (true) or DESC (false) sorting
 * @param bool $preserveKeys - No idea what it does, if you do replace this part
 * @return array - Sorted array
 * */

function sortBySubValue($array, $value, $asc = true, $preserveKeys = false)
{
    if (is_object(reset($array))) {
        $preserveKeys ? uasort($array, function ($a, $b) use ($value, $asc) {
            return $a->{$value} == $b->{$value} ? 0 : ($a->{$value} <=> $b->{$value}) * ($asc ? 1 : -1);
        }) : usort($array, function ($a, $b) use ($value, $asc) {
            return $a->{$value} == $b->{$value} ? 0 : ($a->{$value} <=> $b->{$value}) * ($asc ? 1 : -1);
        });
    } else {
        $preserveKeys ? uasort($array, function ($a, $b) use ($value, $asc) {
            return $a[$value] == $b[$value] ? 0 : ($a[$value] <=> $b[$value]) * ($asc ? 1 : -1);
        }) : usort($array, function ($a, $b) use ($value, $asc) {
            return $a[$value] == $b[$value] ? 0 : ($a[$value] <=> $b[$value]) * ($asc ? 1 : -1);
        });
    }
    return $array;
}