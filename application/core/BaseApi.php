<?php
/**
 * commentator: Bogdan N. date: 05.08.2020
 * An abstraction class that implements the basic API methods.
 * @param BaseApiModel|null $model
 */

abstract class BaseApi implements BaseApiMethods {
    private $model;
    private $database;
    protected $table;
    protected $columns;

    //region Initialization
    public function __construct(BaseApiModel $model = null)
    {
        $this->database = DatabaseManager::instance();
        $this->model = $model ?? new BaseApiModel();
    }
    //endregion

    //region Public methods
    final public function query(string $sql, $parameters = null) {
        return $this->database->query($sql, true, $parameters);
    }

    final public function execute($sql, $parameters = null) {
        return $this->database->execute($sql, $parameters);
    }

    final public function response($response = null) {
        if (!isset($response)) {
            LogUtil::incorrectRequest(200, 'No response was received from the server.');
        }elseif (is_bool($response)) {
            if ((bool) $response) {
                LogUtil::correctRequest(200, 'The request was completed successfully.');
            } else {
                LogUtil::incorrectRequest(400, 'The request was not completed.');
            }
        } elseif (is_array($response)) {
            if (!empty((array) $response)) {
                LogUtil::correctRequest(200, (array) $response);
            } else {
                LogUtil::incorrectRequest(400, 'An unsatisfactory response was received from the server.');
            }
        } else {
            LogUtil::incorrectRequest(500, 'Unknown error.');
        }
    }

    final public function printError() {
        LogUtil::incorrectRequest(400, 'The request was not satisfied by the server.');
    }

    final public function printInformation() {
        LogUtil::correctRequest(200, 'The request was completed.');
    }
    //endregion

    //region Getters
    final public function getRequestPath() {
        return $this->model->getPatch();
    }

    final public function getRequestQuery()
    {
        return $this->model->getQuery();
    }

    final public function getRequestData()
    {
        return $this->model->getData();
    }

    final public function getRequestValues() {
        return !empty($query = $this->model->getQuery()) ? $query : (
            !empty($data = $this->model->getData()) ?  json_decode($data, true) : null
        );
    }
    //endregion
}