<?php
/**
 * commentator: Bogdan N. date: 05.08.2020
 * A class that implements static logging methods.
 */

final class LogUtil {
    //region Public methods
    public static function correctRequest($httpCode, $message) {
        self::printFinalMsg($httpCode, true, $message);
    }

    public static function incorrectRequest($httpCode, $message) {
        self::printFinalMsg($httpCode, false, $message);
    }

    private static function printFinalMsg($httpCode, $status, $message) {
        $parameters = [
            "status" => $status,
            "object" => $message
        ];
        http_response_code($httpCode);
        exit(json_encode($parameters));
    }
    //endregion
}