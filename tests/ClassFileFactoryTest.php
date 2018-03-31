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
            "path" => "dummpath",
            "dependencies" => ["dep1", "dep2"],
            "functions" => [
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
            "removablefns" => [
                ["access" => "public", "name" => "dummyName", "content" => "dummycontent"],
                ["access" => "public", "name" => "dummyName2", "content" => "dummycontent2"],
            ],
            "variables" => [
                ["access" => "public", "name" => "dummy"],
                ["access" => "public", "name" => "dummy2"]
            ],
            "traits" => [
                ['name' => "trait1"],
                ["name" => "trait2", "dependency" => "deptrait2"]
            ]
        ];

        $this->classfile = new ClassFile();
        $this->classfile->setPath($this->classfilearray["path"]);
        foreach ($this->classfilearray["dependencies"] as $dep) {
            $this->classfile->addDependency(new DependencyContent($dep));
        }

        foreach ($this->classfilearray["functions"] as $fn) {
            $this->classfile->addFunction(new FunctionContent($fn));
        }

        foreach ($this->classfilearray["variables"] as $var) {
            $this->classfile->addVariable(new VariableContent($var["access"], $var["name"]));
        }

        foreach ($this->classfilearray["removablefns"] as $rfn) {
            $this->classfile->addRemovable(new RemovableFunction($rfn["access"], $rfn["name"], $rfn["content"]));
        }

        foreach ($this->classfilearray['traits'] as $trait) {
            $name = $trait['name'];
            $dep = isset($trait['dependency']) ? $trait['dependency'] : NULL;
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
