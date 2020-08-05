<?php
/**
 * commentator: Bogdan N. date: 05.08.2020
 * A class that implements static methods for processing arrays.
 */

final class ArrUtil {
    //region Public methods
    public static function matching(array $values, array $original) {
        if (count($values) !== count($original)) {
            return false;
        } else {
            foreach ($values as $value) {
                if (in_array($value, $original)) {
                    array_shift($original);
                }
            }
            return empty($original);
        }
    }

    public static function formattingValues(string $format, array $values) {
        $result = array();
        foreach ($values as $key => $value) {
            array_push($result, trim(sprintf($format, $value)));
        }
        return $result;
    }
    //endregion
}