<?php
/**
 * Created by PhpStorm.
 * User: progr5
 * Date: 10.3.16
 * Time: 17.17
 */

namespace plugins;


/**
 * Class Plugin
 * @package plugins
 */
class Plugin
{
    private $_configPlugins = [];

    /**
     * @var array
     */
    private $_data;

    /**
     * Plugin constructor.
     * @param array $params
     */
    public function __construct($params = [])
    {
        $this->_data = $params;
    }

    /**
     *
     */
    public function init($configPlugins) {
        $this->_configPlugins = $configPlugins;
        foreach ($this->_configPlugins as $pluginName) {
            $pluginName = __NAMESPACE__ . '\\' . $pluginName;
            /** @var PluginInterface $plugin */

            $plugin = new $pluginName;
            $plugin->in($this->_data);
            $this->_data = $plugin->out();
        }
        //var_dump($this->_data);
    }
}