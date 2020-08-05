<?php
/**
 * commentator: Bogdan N. date: 05.08.2020
 * A class that implements static methods for processing arrays.
 */

final class ArrUtil {
    //region Public methods
    public static function matching($values, $original) {
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
    //endregion
}