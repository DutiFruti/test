<?php
/**
 * Created by PhpStorm.
 * User: progr5
 * Date: 16.3.16
 * Time: 18.28
 */

namespace plugins;


/**
 * Class ResizeImages
 * @package plugins
 */
class ResizeImages implements PluginInterface
{
    /**
     * @var
     */
    private $_data;

    /**
     * @param $data
     */
    public function in($data)
    {
        print "Resize images \n";
        $this->_data = $data;
    }

    /**
     * @return mixed
     */
    public function out()
    {
        return $this->_data;
    }
}