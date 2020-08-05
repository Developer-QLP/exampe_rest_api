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
        return empty($argument) ? '' : (!is_array($argument) ? sprintf($format, trim((string) $argument)) :  ArrUtil::formattingValues($format, (array) $argument));
    }

    public static function prepareCommandAsStr(string $command, $parameter, array $filter = null) {
        return empty($parameter) ? '' :
            (is_null($filter) & empty($filter) ? (string) $parameter : (($key = array_search((string) $parameter, $filter)) === false ? '' : self::formattingCommand($command) . $filter[$key]));
    }

    public static function prepareCommandAsInt(string $command, $parameter) {
            return empty($parameter) ? '' :
                (!is_numeric($parameter) ? '' : self::formattingCommand($command) . $parameter);
    }

    public static function parseVariableValuesAsStr(string  $value) {
        return preg_match_all('~(?<variables>\w+)~i', $value, $matches) === false ?  false : $matches['variables'];
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