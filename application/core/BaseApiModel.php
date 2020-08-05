<?php
/**
 * commentator: Bogdan N. date: 05.08.2020
 * API class model.
 */

class BaseApiModel {
    private $patch;
    private $query;
    private $data;

    //region Getters
    public function getPatch()
    {
        return $this->patch;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function getData()
    {
        return $this->data;
    }
    //endregion

    //region Setters
    public function setPatch(array $patch)
    {
        $this->patch = $patch;
    }

    public function setQuery(array $query)
    {
        $this->query = $query;
    }

    public function setData($data)
    {
        $this->data = $data;
    }
    //endregion
}
