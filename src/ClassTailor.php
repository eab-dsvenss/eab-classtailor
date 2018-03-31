<?php

/*
 * Licensed under GNU GENERAL PUBLIC LICENSE
 * URL: http://www.gnu.org/licenses/gpl.html
 */

namespace se\eab\php\classtailor;

use se\eab\php\classtailor\model\ClassFile;
use se\eab\php\classtailor\model\ClassParser;
use se\eab\php\classtailor\model\FileHandler;

/**
 * Class responsible for adding parameters to Eloquent model files
 */
class ClassTailor
{

    private $classparser;
    private $filehandler;

    public function __construct($tablen = 4)
    {
        $this->classparser = ClassParser::getInstance($tablen);
        $this->filehandler = FileHandler::getInstance();
    }

    /**
     * Adjust the supplied eloquent models
     * 
     * @param ClassFile[] $classFiles
     * @param string $basepath
     */
    public function tailorClasses(array $classFiles)
    {
        foreach ($classFiles as $classfile) {
            $this->tailorClass($classfile);
        }
    }

    public function tailorClass(ClassFile $classFile)
    {
        $path = $classFile->getPath();
        $classcontent = $this->filehandler->getFileContents($path);
        $this->removeRemovables($classFile->getRemovables(), $classcontent);
        $this->addDependencies($classFile->getDependencies(), $classcontent);
        $this->addFunctions($classFile->getFunctions(), $classcontent);
        $this->addVariables($classFile->getVariables(), $classcontent);
        $this->addTraits($classFile->getTraits(),$classcontent);
        $this->replaceReplaceables($classFile->getReplaceables(), $classcontent);
        $this->filehandler->writeToFile($path, $classcontent);
    }

    private function removeRemovables(array $removables, &$classcontent)
    {
        foreach ($removables as $removable) {
            $this->classparser->removeRemovable($classcontent, $removable);
        }
    }

    private function addDependencies(array $dependencies, &$classcontent)
    {
        foreach ($dependencies as $dependency) {
            $this->classparser->addDependency($classcontent, $dependency);
        }
    }

    private function addTraits(array $traits, &$classcontent) {
        foreach ($traits as $trait) {
            $this->classparser->addTrait($classcontent, $trait);
        }
    }

    private function addVariables(array $variables, &$classcontent)
    {
        foreach ($variables as $variable) {
            $this->classparser->addVariable($classcontent, $variable);
        }
    }

    private function addFunctions(array $functions, &$classcontent)
    {
        foreach ($functions as $function) {
            $this->classparser->addFunction($classcontent, $function);
        }
    }
    
    private function replaceReplaceables(array $replaceables, &$classcontent) {
        foreach ($replaceables as $rep) {
            $this->classparser->replace($classcontent, $rep);
        }
    }

}
