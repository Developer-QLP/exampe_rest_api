<?php
/**
 * commentator: Bogdan N. date: 05.08.2020
 * A class that implements static methods for working with a database.
 */

final class DbUtil {
    //region Public methods
    public static function formattingCommand($command) {
        return self::formattingStringOrArray(' %s ', $command);
    }

    public static function formattingParameter($parameter) {
        return self::formattingStringOrArray('`%s`', $parameter);
    }

    public static function formattingValue($value) {
        return self::formattingStringOrArray( '\'%s\'', $value);
    }

    public static function formattingStringOrArray(string $format, $argument) {
        return empty($argument) ? '' : (!is_array($argument) ? sprintf($format, trim((string) $argument)) : self::formattingArray((array) $argument, $format));
    }

    public static function formattingArray(array $array, string $format) {
        $result = array();
        foreach ($array as $key => $value) {
            array_push($result, trim(sprintf($format, $value)));
        }
        return $result;
    }

    public static function prepareCommandAsStr(string $command, $parameter, array $filter = null) {
        return empty($parameter) ? '' :
            self::formattingCommand($command) . (is_null($filter) & empty($filter) ? (string) $parameter : ($key = array_search((string) $parameter, $filter)) === false ? '' : $filter[$key]);
    }

    public static function prepareCommandAsInt(string $command, $parameter, int $default = 0) {
        return empty($parameter) ? '' :
            self::formattingCommand($command) . (!is_numeric($parameter) ? $default : $parameter);
    }

    public static function parseVariableValuesAsStr(string  $value) {
        return preg_match_all('~(?<variables>\w+)~i', $value, $matches) ? $matches['variables'] : false;
    }

    public static function parseVariableValuesAsArr(array $array) {
        foreach ($array as $key => $value) {
            if (($result = self::parseVariableValuesAsStr($value)) !== false) {
                $array[$key] = $result;
            }
        }
        return $array;
    }
    //endregion
}