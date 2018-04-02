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

    const DEPENDENCIES_KEY = "dependencies";
    const DEPENDENCY_KEY = "dependency";
    const FUNCTIONS_KEY = "functions";
    const ACCESS_KEY = "access";
    const NAME_KEY = "name";
    const VARIABLES_KEY = self::VARIABLES_KEY;
    const TRAITS_KEY = "traits";
    const REMOVABLEFNS_KEY = "removables";
    const REPLACEABLES_KEY = "replaceables";
    const CONTENT_KEY = "content";
    const PATTERN_KEY = "pattern";
    const REPLACEMENT_KEY = "replacement";
    const PATH_KEY = self::PATH_KEY;

    private static $instance;

    private function __construct()
    {
        ;
    }

    /**
     *
     * @return ClassFileFactory
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
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

        if (isset($classfileArray[self::DEPENDENCIES_KEY])) {
            foreach ($classfileArray[self::DEPENDENCIES_KEY] as $dep) {
                $classfile->addDependency(new DependencyContent($dep));
            }
        }

        if (isset($classfileArray[self::FUNCTIONS_KEY])) {
            foreach ($classfileArray[self::FUNCTIONS_KEY] as $fn) {
                $classfile->addFunction(new FunctionContent($fn));
            }
        }

        if (isset($classfileArray[self::VARIABLES_KEY])) {
            foreach ($classfileArray[self::VARIABLES_KEY] as $variable) {
                $classfile->addVariable(new VariableContent($variable[self::ACCESS_KEY], $variable[self::NAME_KEY]));
            }
        }

        if (isset($classfileArray[self::TRAITS_KEY])) {
            foreach ($classfileArray[self::TRAITS_KEY] as $trait) {
                $name = $trait[self::NAME_KEY];
                $dependency = isset($trait[self::DEPENDENCY_KEY]) ? $trait[self::DEPENDENCY_KEY] : NULL;
                $classfile->addTrait(new TraitContent($name, $dependency));
            }
        }

        if (isset($classfileArray[self::REMOVABLEFNS_KEY])) {
            foreach ($classfileArray[self::REMOVABLEFNS_KEY] as $removablefn) {
                $classfile->addRemovableFunction(new RemovableFunction($removablefn[self::ACCESS_KEY], $removablefn[self::NAME_KEY], $removablefn[self::CONTENT_KEY]));
            }
        }

        if (isset($classfileArray[self::REPLACEABLES_KEY])) {
            foreach ($classfileArray[self::REPLACEABLES_KEY] as $replaceable) {
                $classfile->addReplaceable(new Replaceable($replaceable[self::PATTERN_KEY], $replaceable[self::REPLACEMENT_KEY]));
            }
        }

        if (isset($classfileArray[self::PATH_KEY])) {
            $classfile->setPath($classfileArray[self::PATH_KEY]);
        }

        return $classfile;
    }

    public function getArrayFromClassFile(ClassFile $classfile)
    {
        $classfilearray = [];
        $classfilearray[self::REMOVABLEFNS_KEY] = [];
        $classfilearray[self::TRAITS_KEY] = [];
        $classfilearray[self::VARIABLES_KEY] = [];
        $classfilearray[self::FUNCTIONS_KEY] = [];
        $classfilearray[self::DEPENDENCIES_KEY] = [];
        $classfilearray[self::REPLACEABLES_KEY] = [];

        if ($classfile->hasDependencies()) {
            foreach($classfile->getDependencies() as $dep) {
                $classfilearray[self::DEPENDENCIES_KEY][] = $dep->getContent();
            }
        }

        if ($classfile->hasFunctions()) {
            foreach($classfile->getFunctions() as $fn) {
                $classfilearray[self::FUNCTIONS_KEY][] = [$fn->getContent()];
            }
        }

        if ($classfile->hasVariables()) {
            foreach ($classfile->getVariables() as $var) {
                $classfilearray[self::VARIABLES_KEY][] = [self::ACCESS_KEY => $var->getAccess(), self::NAME_KEY => $var->getName()];
            }
        }

        if ($classfile->hasTraits()) {
            foreach($classfile->getTraits() as $trait) {
                $traitarr = [self::NAME_KEY => $trait->getName()];
                if ($trait->hasDependency()) {
                    $traitarr[self::DEPENDENCY_KEY] = $trait->getDependencyContent()->getName();
                }
                $classfilearray[self::TRAITS_KEY][] = $traitarr;
            }
        }

        if ($classfile->hasRemovableFunctions()) {
            foreach ($classfile->getRemovableFunctions() as $remfn) {
                $classfilearray[self::REMOVABLEFNS_KEY][] = [self::ACCESS_KEY => $remfn->getAccess(), self::NAME_KEY => $remfn->getName(), self::CONTENT_KEY => $remfn->getContent()];
            }
        }

        if ($classfile->hasReplaceables()) {
            foreach ($classfile->getReplaceables() as $rep) {
                $classfilearray[self::REPLACEABLES_KEY][] = [self::PATTERN_KEY => $rep->getPattern(), self::REPLACEMENT_KEY => $rep->getReplacement()];
            }
        }

        return $classfilearray;
    }

}
