<?php
/**
 * Created by PhpStorm.
 * User: progr5
 * Date: 10.3.16
 * Time: 17.56
 */

namespace plugins;


/**
 * Class Url
 * @package plugins
 */
class Url implements PluginInterface
{
    /**
     * @var
     */
    private $_url;
    /**
     * @var array
     */
    private $_allLinks = [];

    private $_currentDepth = 0;

    private $_config = [];

    public function __construct()
    {
        $this->_config = \Application::$config['url'];
    }

    /**
     * @param $data
     */
    public function in($data)
    {
        print "Start parsing url \n";
        $this->_url = $data['url'];
        if (!isset($this->_url)) {
            die("Url must be defined. \nFor example: php index.php --url=http://tut.by \n");
        }
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
        return $this->getSiteLinks();
    }

    /**
     * @param $path
     * @return string
     */
    protected function getContent($path)
    {
        $contents = file_get_contents($path);
        return $contents;
    }

    /**
     * @param string $uri
     * @return array
     */
    protected function getSiteLinks($uri = '/')
    {
        $depth = $this->_config['depth'];
        $this->_allLinks[] = $uri;
        $url = strpos($uri, 'http') === false ? $this->_url . $uri : $uri;
        $contents = $this->getContent($url);
        preg_match_all('/href="([^"]+)"/', $contents, $links);
        unset($contents);
        foreach ($links[1] as $link) {
            $link = str_replace($this->_url, '', $link);

            if (!in_array($link, $this->_allLinks) && $this->checkUrl($link)) {
                if (substr($link, 0, 1) != '/' && strpos($link, 'http') === false) $link = '/' . $link;
                if ($this->_currentDepth > $depth) {
                    break;
                }
                $this->getSiteLinks($link);
                $this->_currentDepth++;
            }
        }

        return $this->_allLinks;
    }

    /**
     * @param $link
     * @return bool
     */
    private function checkUrl($link)
    {
        if (empty($link)) return false;

        $url = strpos($link, 'http') === false ? $this->_url . $link : $link;

        $header = get_headers($url, 1);
        $isHtml = $header && strpos(is_array($header['Content-Type'])
                ? $header['Content-Type'][0]
                : $header['Content-Type'], 'text/html') !== false;
        $isOk = strpos($header[0], '200 OK') !== false;

        return $isHtml && $isOk;
    }
}