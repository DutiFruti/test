<?php
/**
 * Created by PhpStorm.
 * User: progr5
 * Date: 14.3.16
 * Time: 18.10
 */

namespace plugins;

/**
 * Interface PluginInterface
 * @package plugins
 */
interface PluginInterface
{
    /**
     * @param $data
     * @return mixed
     */
    public function in($data);

    /**
     * @return mixed
     */
    public function out();
}