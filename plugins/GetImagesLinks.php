<?php
/**
 * Created by PhpStorm.
 * User: progr5
 * Date: 11.3.16
 * Time: 18.39
 */

namespace plugins;


/**
 * Class GetImagesLinks
 * @package plugins
 */
class GetImagesLinks implements PluginInterface
{
    /**
     * @var
     */
    private $_data;
    /**
     * @var array
     */
    private $_imagesLinks = [];

    /**
     * @param $data
     */
    public function in($data)
    {
        print "Start parsing images \n";
        $this->_data = $data;
    }

    /**
     * @return array
     */
    public function out()
    {
        return $this->execute();
    }

    /**
     * @return array
     */
    protected function execute()
    {
        $request = new \Request();
        foreach ($this->_data as $link) {
            $url = strpos($link, 'http') === false ? $request->get('url') . $link : $link;
            $this->getPageImagesLinks($url);
        }
        return $this->_imagesLinks;
    }

    /**
     * @param $url
     */
    protected function getPageImagesLinks($url)
    {
        $contents = file_get_contents($url);
        preg_match_all('/(img|src)=("|\')[^"\'>]+/i', $contents, $links);
        unset($contents);
        $links = preg_replace('/(img|src)("|\'|="|=\')(.*)/i', "$3", $links[0]);
        foreach ($links as $link) {
            if (!in_array($link, $this->_imagesLinks)) {
                $info = pathinfo($link);
                if (isset($info['extension']) && in_array($info['extension'], ['jpg', 'jpeg', 'gif', 'png'])) {
                    $this->_imagesLinks[] = $link;
                }
            }
        }
    }
}