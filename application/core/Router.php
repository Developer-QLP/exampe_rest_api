<?php
/**
 * commentator: Bogdan N. date: 05.08.2020
 * The class is responsible for defining and building routes.
 */

final class Router {
    private static $instance;
    private $apiName;
    private $apiMethod;
    private $apiModel;

    //region Statics
    public static function instance() {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public static function start() {
        $router = self::instance();
        $router->setDefaultCorsPolicy();
        $router->build();
        $router->run();
    }
    //endregion

    private function build() {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $route = explode('/', trim($path, '/'));

        $apiFolderName = array_shift($route);
        $apiVersion = array_shift($route);
        $apiFileName = array_shift($route);

        $apiName = ucfirst($apiFileName) . 'Api';
        $apiFile = ROOT_PATH . '/api/' . $apiVersion . '/' . $apiFolderName . '/' . $apiName . '.php';

        if (!file_exists($apiFile)) {
            LogUtil::incorrectRequest(400, 'The request is invalid or not supported by the server.');
        } else {
            include_once $apiFile;
            if (!class_exists($apiName)) {
                LogUtil::incorrectRequest(400, 'The request is invalid or not supported by the server.');
            } else {
                $baseApiModel = new BaseApiModel();
                $baseApiModel->setPatch($route);
                $baseApiModel->setQuery($_REQUEST);
                $baseApiModel->setData(file_get_contents('php://input'));

                $this->apiName = $apiName;
                $this->apiMethod = $_SERVER['REQUEST_METHOD'];
                $this->apiModel = $baseApiModel;
            }
        }
    }

    private function run() {
        $apiClass = new $this->apiName($this->apiModel);
        $apiFunction = strtolower($this->apiMethod);
        if (!method_exists($apiClass, $apiFunction)) {
            LogUtil::incorrectRequest(400, 'The request is invalid or not supported by the server.');
        } else {
            $apiClass->$apiFunction();
        }
    }

    private function setDefaultCorsPolicy() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, PATH, DELETE');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');
    }
}