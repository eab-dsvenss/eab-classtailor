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

        $this->assertArrayContainsAll($this->cf2->getTraits(), $this->cf1->getTraits());
        $this->assertArrayContainsAll($this->cf2->getDependencies(), $this->cf1->getDependencies());
        $this->assertArrayContainsAll($this->cf2->getFunctions(), $this->cf1->getFunctions());
        $this->assertArrayContainsAll($this->cf2->getRemovables(), $this->cf1->getRemovables());
        $this->assertArrayContainsAll($this->cf2->getReplaceables(), $this->cf1->getReplaceables());
        $this->assertArrayContainsAll($this->cf2->getVariables(), $this->cf1->getVariables());
        $this->assertEquals($this->cf1->getPath(), $this->cf2->getPath());
    }

    private function assertArrayContainsAll($needles, $haystack) {
        foreach($needles as $n) {
            $this->assertContains($n, $haystack);
        }
    }
}