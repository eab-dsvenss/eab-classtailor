<?php
namespace se\eab\php\classtailor\test;

use se\eab\php\classtailor\model\ClassFile;

class ClassFileTest extends \Codeception\Test\Unit
{

    /**
     * @var ClassFile
     */
    private $cf1;
    /**
     * @var ClassFile
     */
    private $cf2;

    protected function _before()
    {
        $this->cf1 = new ClassFile();
       $this->cf2 =  ClassFileTestHelper::createClassFile("path");
    }

    protected function _after()
    {

    }

    // tests
    public function testMergeClassFile()
    {
        $this->cf1->mergeClassFile($this->cf2);

        $this->assertEquals($this->cf1, $this->cf2);
    }
}