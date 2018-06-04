<?php

/*
 * Licensed under GNU GENERAL PUBLIC LICENSE
 * URL: http://www.gnu.org/licenses/gpl.html
 */

namespace se\eab\php\classtailor\model;
use \Exception;

/**
 * Description of FileHandler
 *
 * @author dsvenss
 */
class FileHandler
{
    
    private static $instance;
    
    private function __construct() {
        
    }
    
    /**
     * 
     * @return FileHandler
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new FileHandler();
        }
        
        return self::$instance;
    }

    /**
     * 
     * @param string $path
     * @return string
     */
    public function getFileContents($path)
    {
        return file_get_contents($path);
    }

    /**
     * @param $path
     * @param $content
     * @return bool|int
     * @throws Exception
     */
    public function writeToFile($path, $content)
    {
        if (file_put_contents($path, $content) === FALSE) {
            throw new Exception("Could not write file");
        }

        return true;
    }

    /**
     * @param $path
     * @param $content
     * @return bool|int
     */
    public function appendToFile($path, $content) {
        return file_put_contents($path, $content, FILE_APPEND);
    }

}
