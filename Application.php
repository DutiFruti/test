<?php

/**
 * Created by PhpStorm.
 * User: progr5
 * Date: 10.3.16
 * Time: 16.30
 */
use plugins\Plugin;

/**
 * Class Application
 */
class Application
{
    private $_config;

    public static $config;

    public function __construct($config)
    {
        Application::$config = $config;
    }

    /**
     *
     */
    public function run() {
        $request = new Request();
        $params = $request->resolve();
        $plugin = new Plugin($params);
        $plugin->init(Application::$config['plugins']);
    }
}