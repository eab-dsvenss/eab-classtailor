<?php

/*
 * Licensed under GNU GENERAL PUBLIC LICENSE
 * URL: http://www.gnu.org/licenses/gpl.html
 */
use \Exception;
use se\test\Dep1;

use testdependency;

/**
 * Description of TestClass
 *
 * @author dsvenss
 */
class TestClass
{
    use Dep2;

    use Dep1;

    public $testvariable;

    public function testing() {
        $testsomething;
    }

    private $newvariable;
    public function __construct() {
        
    }
    
    
}
