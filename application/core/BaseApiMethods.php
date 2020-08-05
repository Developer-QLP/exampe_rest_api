<?php
/**
 * commentator: Bogdan N. date: 05.08.2020
 * An interface that defines the basic methods for working with the API.
 */

interface BaseApiMethods {
    public function get();
    public function post();
    public function put();
    public function patch();
    public function delete();
}