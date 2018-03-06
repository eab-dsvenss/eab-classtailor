<?php

namespace se\eab\php\classtailor\test;

use se\eab\php\classtailor\model\ClassFile;
use se\eab\php\classtailor\ClassTailor;
use se\eab\php\classtailor\model\content\DependencyContent;
use se\eab\php\classtailor\model\content\VariableContent;
use se\eab\php\classtailor\model\content\FunctionContent;
use se\eab\php\classtailor\model\removable\RemovableFunction;
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
        $this->basepath = codecept_root_dir() . "tests/_data/";
        $this->copyTestClassFile();
        $this->createClassFile();
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

    private function createClassFile()
    {
        $this->classfile = new ClassFile();
        $this->classfile->setPath($this->testclasspath);
        $this->classfile->addDependency(new DependencyContent("testdependency"));
        $this->classfile->addFunction(new FunctionContent(<<<EOT
public function testing() {
    \$testsomething;
}
EOT
        ));
        $this->classfile->addVariable(new VariableContent("public", "\$testvariable"));
        $this->classfile->addRemovable(new RemovableFunction("public", "test", "Test"));
    }

    public function testTailorClasses()
    {
        $instance = $this;
        $negate = true;
        $cf = $this->classfile;
        $beforecontent = $this->filehandler->getFileContents($cf->getPath());

        $contentAssertFn = ClassFileTestHelper::getContentAssertLambda($beforecontent, $instance, $negate);
        $removeAssertFn = ClassFileTestHelper::getRemoveAssertLambda($beforecontent, $instance, !$negate);

        ClassFileTestHelper::assertOverArray($cf->getDependencies(), $contentAssertFn);
        ClassFileTestHelper::assertOverArray($cf->getFunctions(), $contentAssertFn);
        ClassFileTestHelper::assertOverArray($cf->getVariables(), $contentAssertFn);
        ClassFileTestHelper::assertOverArray($cf->getRemovables(), $removeAssertFn);

        $this->classtailor->tailorClasses([$this->classfile]);
        
        $aftercontent = $this->filehandler->getFileContents($cf->getPath());

        $negate = false;
        $contentAssertFn = ClassFileTestHelper::getContentAssertLambda($aftercontent, $instance, $negate);
        $removeAssertFn = ClassFileTestHelper::getRemoveAssertLambda($aftercontent, $instance, !$negate);
        
        ClassFileTestHelper::assertOverArray($cf->getDependencies(), $contentAssertFn);
        ClassFileTestHelper::assertOverArray($cf->getFunctions(), $contentAssertFn);
        ClassFileTestHelper::assertOverArray($cf->getVariables(), $contentAssertFn);
        ClassFileTestHelper::assertOverArray($cf->getRemovables(), $removeAssertFn);
    }

}
