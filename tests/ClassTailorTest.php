<?php

namespace se\eab\php\classtailor\test;

use se\eab\php\classtailor\ClassTailor;
use se\eab\php\classtailor\model\FileHandler;
use se\eab\php\classtailor\test\ClassFileTestHelper;

class ClassTailorTest extends \Codeception\Test\Unit
{

    private $classfile;
    private $classtailor;
    private $filehandler;
    private $testclasspath;
    private $basepath;

    protected function _before()
    {
        $this->classtailor = new ClassTailor(4);
        $this->filehandler = FileHandler::getInstance();
        $this->basepath = codecept_data_dir();
        $this->copyTestClassFile();
        $this->classfile = ClassFileTestHelper::createClassFile($this->testclasspath);
    }

    protected function _after()
    {
        
    }

    private function copyTestClassFile()
    {
        $origpath = $this->basepath . "TestClass.php";
        $this->testclasspath = $this->basepath . "TestClass_TEST.php";
        $content = $this->filehandler->getFileContents($origpath);
        $this->filehandler->writeToFile($this->testclasspath, $content);
    }

    public function testTailorClasses()
    {
        $instance = $this;
        $negate = true;
        $cf = $this->classfile;
        $beforecontent = $this->filehandler->getFileContents($cf->getPath());

        $contentAssertFn = ClassFileTestHelper::getContentAssertLambda($beforecontent, $instance, $negate);
        $removeAssertFn = ClassFileTestHelper::getRemoveAssertLambda($beforecontent, $instance, !$negate);
        $traitAssertFn = ClassFileTestHelper::getTraitAssertLambda($beforecontent, $instance, $negate);
        $replaceableAssertFn = ClassFileTestHelper::getReplaceableAssertLambda($beforecontent, $instance, $negate);

        ClassFileTestHelper::assertOverArray($cf->getDependencies(), $contentAssertFn);
        ClassFileTestHelper::assertOverArray($cf->getFunctions(), $contentAssertFn);
        ClassFileTestHelper::assertOverArray($cf->getVariables(), $contentAssertFn);
        ClassFileTestHelper::assertOverArray($cf->getTraits(), $traitAssertFn);
        ClassFileTestHelper::assertOverArray($cf->getRemovables(), $removeAssertFn);
        ClassFileTestHelper::assertOverArray($cf->getReplaceables(), $replaceableAssertFn);

        $this->classtailor->tailorClasses([$this->classfile]);

        $aftercontent = $this->filehandler->getFileContents($cf->getPath());

        $negate = false;
        $contentAssertFn = ClassFileTestHelper::getContentAssertLambda($aftercontent, $instance, $negate);
        $removeAssertFn = ClassFileTestHelper::getRemoveAssertLambda($aftercontent, $instance, !$negate);
        $traitAssertFn = ClassFileTestHelper::getTraitAssertLambda($aftercontent, $instance, $negate);
        $replaceableAssertFn = ClassFileTestHelper::getReplaceableAssertLambda($aftercontent, $instance, $negate);

        ClassFileTestHelper::assertOverArray($cf->getDependencies(), $contentAssertFn);
        ClassFileTestHelper::assertOverArray($cf->getFunctions(), $contentAssertFn);
        ClassFileTestHelper::assertOverArray($cf->getVariables(), $contentAssertFn);
        ClassFileTestHelper::assertOverArray($cf->getTraits(), $traitAssertFn);
        ClassFileTestHelper::assertOverArray($cf->getRemovables(), $removeAssertFn);
        ClassFileTestHelper::assertOverArray($cf->getReplaceables(), $replaceableAssertFn);
    }

}
