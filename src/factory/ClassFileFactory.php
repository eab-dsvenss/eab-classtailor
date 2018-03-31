<?php

/*
 * Licensed under GNU GENERAL PUBLIC LICENSE
 * URL: http://www.gnu.org/licenses/gpl.html
 */

namespace se\eab\php\classtailor\factory;

use se\eab\php\classtailor\model\content\DependencyContent;
use se\eab\php\classtailor\model\content\VariableContent;
use se\eab\php\classtailor\model\content\FunctionContent;
use se\eab\php\classtailor\model\removable\RemovableFunction;
use se\eab\php\classtailor\model\replaceable\Replaceable;
use se\eab\php\classtailor\model\ClassFile;
use se\eab\php\classtailor\model\content\TraitContent;

/**
 * Description of TailorHelper
 *
 * @author dsvenss
 */
class ClassFileFactory
{
    
    private static $instance;
    
    private function __construct()
    {
        ;
    }
    
    /**
     * 
     * @return ClassFileFactoryx
     */
    public static function getInstance() {
        if(!isset(self::$instance)) {
            self::$instance = new ClassFileFactory();
        }
        
        return self::$instance;
    }

    /**
     * Creates a 
     * @param array $classfileArray
     * @return ClassFile
     */
    public function createClassfileFromArray(array $classfileArray)
    {
        $classfile = new ClassFile();

        if (isset($classfileArray['dependencies'])) {
            foreach ($classfileArray['dependencies'] as $dep) {
                $classfile->addDependency(new DependencyContent($dep));
            }
        }
        
        if (isset($classfileArray['functions'])) {
            foreach ($classfileArray['functions'] as $fn) {
                $classfile->addFunction(new FunctionContent($fn));
            }
        }
        
        if (isset($classfileArray['variables'])) {
            foreach ($classfileArray['variables'] as $variable) {
                $classfile->addVariable(new VariableContent($variable['access'], $variable['name']));
            }
        }

        if (isset($classfileArray['traits'])) {
            foreach($classfileArray['traits'] as $trait) {
                $name = $trait['name'];
                $dependency = isset($trait['dependency']) ? $trait['dependency'] : NULL;
                $classfile->addTrait(new TraitContent($name, $dependency);
            }
        }
        
        if (isset($classfileArray['removablefns'])) {
            foreach ($classfileArray['removablefns'] as $removablefn) {
                $classfile->addRemovable(new RemovableFunction($removablefn['access'], $removablefn['name'], $removablefn['content']));
            }
        }
        
        if (isset($classfileArray['replaceables'])) {
            foreach ($classfileArray['replaceables'] as $replaceable) {
                $classfile->addReplaceable(new Replaceable($replaceable['pattern'], $replaceable['replacement']));
            }
        }
        
        if(isset($classfileArray["path"])) {
            $classfile->setPath($classfileArray["path"]);
        }
        
        return $classfile;
    }

}
