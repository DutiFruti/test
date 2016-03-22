<?php

/**
 * Created by PhpStorm.
 * User: progr5
 * Date: 10.3.16
 * Time: 17.00
 */
class Request
{
    /**
     * @var
     */
    private $_params;

    /**
     * @return array
     */
    private function getParams() {
        if (!isset($this->_params)) {
            if (isset($_SERVER['argv'])) {
                $this->_params = $_SERVER['argv'];
                array_shift($this->_params);
            } else {
                $this->_params = [];
            }
        }

        return $this->_params;
    }

    /**
     * @param $params
     */
    public function setParams($params)
    {
        $this->_params = $params;
    }

    /**
     * @return array
     */
    public function resolve()
    {
        $rawParams = $this->getParams();

        $params = [];
        foreach ($rawParams as $param) {
            if (preg_match('/^--(\w+)(=(.*))?$/', $param, $matches)) {
                $name = $matches[1];
                $params[$name] = isset($matches[3]) ? $matches[3] : true;
            } else {
                $params[] = $param;
            }
        }

        return $params;
    }

    /**
     * @param $param
     * @param bool $default
     * @return string
     */
    public function get($param, $default=false) {
        if (isset($this->resolve()[$param])) {
            return $this->resolve()[$param];
        }
        return $default;
    }
}