<?php
/**
 * Created by PhpStorm.
 * User: progr5
 * Date: 14.3.16
 * Time: 18.16
 */

namespace plugins;


/**
 * Class SaveImagesMySql
 * @package plugins
 */
class SaveImagesMySql implements PluginInterface
{
    /**
     * @var
     */
    private $_data;

    private $_config = [];

    /**
     * @var
     */
    private $conn;

    /**
     * SaveImagesMySql constructor.
     */
    public function __construct()
    {
        $this->_config = \Application::$config['mysql'];
        $this->checkDB();
    }

    /**
     * @param $data
     */
    public function in($data)
    {
        print "Save images to MySQL \n";
        $this->_data = $data;
    }

    /**
     * @throws \Exception
     */
    public function out()
    {
        $request = new \Request();
        foreach ($this->_data as $imageLink) {
            $url = strpos($imageLink, 'http') === false ? $request->get('url') . $imageLink : $imageLink;
            $this->saveImage($url);
        }
    }

    /**
     * @param $imageLink
     * @return mixed
     * @throws \Exception
     */
    protected function saveImage($imageLink)
    {
        $image = addslashes(file_get_contents($imageLink));
        $link = addslashes($imageLink);
        $query = "INSERT INTO images(`url`, `image`) VALUES('$link', '$image')";
        if ($this->conn->query($query)) {
            return $this->conn->insert_id;
        } else {
            throw new \Exception("Insert failed: " . $this->conn->error);
        }
    }

    /**
     * @throws \Exception
     */
    private function checkDB()
    {
        $this->conn = new \mysqli($this->_config['serverName'], $this->_config['user'], $this->_config['password']);
        if ($this->conn->connect_error) {
            throw new \Exception("Connection failed: " . $this->conn->connect_error);
        }
        $this->conn->query('CREATE DATABASE IF NOT EXISTS ' . $this->_config['db']);
        $this->conn->select_db($this->_config['db']);

        $query = 'CREATE TABLE IF NOT EXISTS images (' .
            'id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,' .
            '`url` varchar(255) NOT NULL, ' .
            '`image` blob NOT NULL ' .
            ') ENGINE=InnoDB DEFAULT CHARSET=utf8';
        if (!$this->conn->query($query)) {
            throw new \Exception("Create table failed: " . $this->conn->error);
        }
    }

}