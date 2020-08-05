<?php
final class ListApi extends BaseApi
{
    /**
     * commentator: Bogdan N. date: 05.08.2020
     * Implementation class for the API list.
     * @param BaseApiModel|null $model
     */
    //region Initialization
    public function __construct(BaseApiModel $model = null)
    {
        parent::__construct($model);
        $this->table = DbUtil::formattingParameter('models_auto');
        $this->columns = DbUtil::formattingParameter(array('name', 'year', 'color'));
    }
    //endregion

    //region Public methods
    public function get()
    {
        $sql = 'SELECT * FROM ' . $this->table;

        $requestQuery = $this->getRequestQuery();
        $requestData = $this->getRequestData();
        $requestPath = $this->getRequestPath();

        if (!empty($requestPath)) {
            $id = array_shift($requestPath);
            if (!is_numeric($id)) {
                $response = $this->query($sql);
                $this->response($response);
            } else {
                $where = DbUtil::prepareCommandAsInt(
                    'WHERE `id` =',
                    $id
                );

                $response = $this->query($sql . $where);
                $this->response($response);
            }
        } else {
            $values = !empty($requestQuery) ? DbUtil::parseVariableValuesAsArr($requestQuery) : json_decode($requestData);
            if (empty($values)) {
                $response = $this->query($sql);
                $this->response($response);
            } else {
                $order = DbUtil::prepareCommandAsStr(
                    'ORDER BY',
                    strtolower(DbUtil::formattingParameter($values['order'][0])),
                    $this->columns
                );

                $direction = empty($order) ? '' : DbUtil::prepareCommandAsStr(
                    '',
                    strtoupper($values['order'][1]),
                    array('ASC', 'DESC')
                );

                $limit = DbUtil::prepareCommandAsInt(
                    'LIMIT',
                    $values['limit'][0]
                );

                $offset = empty($limit) ? '' : DbUtil::prepareCommandAsInt(
                    'OFFSET',
                    $values['offset'][0]
                );

                $response = $this->query($sql . $order . $direction . $limit . $offset);
                $this->response($response);
            }
        }
    }

    public function post()
    {
        $values = $this->getRequestValues();

        if (empty($values)) {
            $this->printError();
        } else {
            $insertColumns = array();
            $insertValues = array();

            foreach ($values as $key => $value) {
                array_push($insertColumns, DbUtil::prepareCommandAsStr(
                    '',
                    strtolower(DbUtil::formattingParameter($key)),
                    $this->columns
                ));
                array_push($insertValues, DbUtil::formattingValue($value));
            }

            if (empty($insertColumns) || empty($insertValues) || !ArrUtil::matching($insertColumns, $this->columns)) {
                $this->printError();
            } else {
                $sql = 'INSERT INTO ' . $this->table . ' (' . join(',', $insertColumns) . ') VALUES (' . join(',', $insertValues) . ')';
                $response = $this->execute($sql);
                $this->response($response);
            }
        }
    }

    public function put()
    {
        $requestValues = $this->getRequestValues();
        $requestPath = $this->getRequestPath();

        if (empty($requestValues) || empty($requestPath)) {
            $this->printError();
        } else {
            $id = array_shift($requestPath);
            if (!is_numeric($id)) {
                $this->printError();
            } else {
                $response = $this->query('SELECT `id` FROM ' . $this->table . ' WHERE `id` = ' . $id);
                if (empty($response)) {
                    $this->post();
                } else {
                    $updateColumns = array();
                    $updateValues = array();

                    foreach ($requestValues as $key => $value) {
                        array_push($updateColumns, DbUtil::prepareCommandAsStr(
                            '',
                            strtolower(DbUtil::formattingParameter($key)),
                            $this->columns
                        ));
                        array_push($updateValues, DbUtil::formattingValue(is_array($value) ? join(' ', $value) : $value));
                    }

                    if (empty($updateColumns) || empty($updateValues)) {
                        $this->printError();
                    } else {
                        $update = array();

                        for ($i = 0; $i < count($updateColumns); $i++) {
                            array_push($update, $updateColumns[$i] . '=' . $updateValues[$i]);
                        }

                        if (empty($update)) {
                            $this->printError();
                        } else {
                            $sql = 'UPDATE ' . $this->table . ' SET ' . join(',', $update) . ' WHERE `id` = ' . $id;
                            $response = $this->execute($sql);
                            $this->response($response);
                        }
                    }
                }
            }
        }
    }

    public function patch()
    {
        $requestValues = $this->getRequestValues();
        $requestPath = $this->getRequestPath();

        if (empty($requestValues) || empty($requestPath)) {
            $this->printError();
        } else {
            $id = array_shift($requestPath);
            if (!is_numeric($id)) {
                $this->printError();
            } else {
                $response = $this->query('SELECT `id` FROM ' . $this->table . ' WHERE `id` = ' . $id);
                if (empty($response)) {
                    $this->printError();
                } else {
                    $this->put();
                }
            }
        }
    }

    public function delete()
    {
        $requestPath = $this->getRequestPath();

        if (empty($requestPath)) {
            $this->printError();
        } else {
            $id = array_shift($requestPath);
            if (!is_numeric($id)) {
                $this->printError();
            } else {
                $sql = 'DELETE FROM ' . $this->table . ' WHERE `id` = ' . $id;
                $response = $this->execute($sql);
                $this->response($response);
            }
        }
    }
    //endregion
}