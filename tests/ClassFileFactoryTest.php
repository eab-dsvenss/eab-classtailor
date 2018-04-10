<?php

namespace se\eab\php\classtailor\test;

use se\eab\php\classtailor\model\ClassFile;
use se\eab\php\classtailor\model\content\DependencyContent;
use se\eab\php\classtailor\model\content\TraitContent;
use se\eab\php\classtailor\model\content\VariableContent;
use se\eab\php\classtailor\model\content\FunctionContent;
use se\eab\php\classtailor\model\removable\RemovableFunction;
use se\eab\php\classtailor\factory\ClassFileFactory;

class ClassFileFactoryTest extends \Codeception\Test\Unit
{

    /**
     * @var ClassFile
     */
    private $classfile;

    /**
     *
     * @var ClassFileFactory
     */
    private $classfilefactory;
    private $classfilearray;

    protected function _before()
    {
        $this->classfilefactory = ClassFileFactory::getInstance();
        $this->createClassFile();
    }

    protected function _after()
    {

    }

    private function createClassFile()
    {
        $this->classfilearray = [
            ClassFileFactory::PATH_KEY => "dummpath",
            ClassFileFactory::DEPENDENCIES_KEY => ["dep1", "dep2"],
            ClassFileFactory::FUNCTIONS_KEY => [
                <<<EOT
public function test() {
    \$test = "";
}
EOT
                ,
                <<<EOT
public function test2() {
    \$test2 = "";
}
EOT
            ],
            ClassFileFactory::REMOVABLEFNS_KEY => [
                [ClassFileFactory::ACCESS_KEY => "public", ClassFileFactory::NAME_KEY => "dummyName", ClassFileFactory::CONTENT_KEY => "dummycontent"],
                [ClassFileFactory::ACCESS_KEY => "public", ClassFileFactory::NAME_KEY => "dummyName2", ClassFileFactory::CONTENT_KEY => "dummycontent2"],
            ],
            ClassFileFactory::VARIABLES_KEY => [
                [ClassFileFactory::ACCESS_KEY => "public", ClassFileFactory::NAME_KEY => "dummy"],
                [ClassFileFactory::ACCESS_KEY => "public", ClassFileFactory::NAME_KEY => "dummy2"]
            ],
            ClassFileFactory::TRAITS_KEY => [
                [ClassFileFactory::NAME_KEY => "trait1"],
                [ClassFileFactory::NAME_KEY => "trait2", ClassFileFactory::DEPENDENCY_KEY => "deptrait2"]
            ]
        ];

        $this->classfile = new ClassFile();
        $this->classfile->setPath($this->classfilearray[ClassFileFactory::PATH_KEY]);
        foreach ($this->classfilearray[ClassFileFactory::DEPENDENCIES_KEY] as $dep) {
            $this->classfile->addDependency(new DependencyContent($dep));
        }

        foreach ($this->classfilearray[ClassFileFactory::FUNCTIONS_KEY] as $fn) {
            $this->classfile->addFunction(new FunctionContent($fn));
        }

        foreach ($this->classfilearray[ClassFileFactory::VARIABLES_KEY] as $var) {
            $this->classfile->addVariable(new VariableContent($var[ClassFileFactory::ACCESS_KEY], $var[ClassFileFactory::NAME_KEY]));
        }

        foreach ($this->classfilearray[ClassFileFactory::REMOVABLEFNS_KEY] as $rfn) {
            $this->classfile->addRemovableFunction(new RemovableFunction($rfn[ClassFileFactory::ACCESS_KEY], $rfn[ClassFileFactory::NAME_KEY], $rfn[ClassFileFactory::CONTENT_KEY]));
        }

        foreach ($this->classfilearray[ClassFileFactory::TRAITS_KEY] as $trait) {
            $name = $trait[ClassFileFactory::NAME_KEY];
            $dep = isset($trait[ClassFileFactory::DEPENDENCY_KEY]) ? $trait[ClassFileFactory::DEPENDENCY_KEY] : NULL;
            $this->classfile->addTrait(new TraitContent($name, $dep));
        }
    }

    public function testCreateClassfileFromArray()
    {
        $gcf = $this->classfilefactory->createClassfileFromArray($this->classfilearray);
        $ecf = $this->classfile;

        $this->assertEquals($gcf->getPath(), $ecf->getPath());

        $this->assertEquals($gcf->getDependencies(), $ecf->getDependencies());
        $this->assertEquals($gcf->getFunctions(), $ecf->getFunctions());
        $this->assertEquals($gcf->getVariables(), $ecf->getVariables());
        $this->assertEquals($gcf->getRemovables(), $ecf->getRemovables());
        $this->assertEquals($gcf->getTraits(), $ecf->getTraits());
    }

}
