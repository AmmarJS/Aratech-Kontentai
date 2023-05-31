<?php

use Kontent\Ai\Delivery\DeliveryClient;
use Kontent\Ai\Delivery\QueryParams;

class Query {
    /**
     * equals function in query params
     *
     * @param array $arguments args for the clause
     * 
     * @return array returns an array which gets passed eventually to query params
     */
    public function where(array $arguments) : array {
        $column = $arguments[0];
        $value = $arguments[1];
        return [$column, $value];
    }

    /**
     * equals function in query params but with the key being id
     *
     * @param array $arguments args for the clause
     *
     * @return array returns an array which gets passed eventually to query params
     */
    public function find(array $argument) : array {
        $value = $argument;
        return ["id", $value];
    }
}