<?php

/*
 * Licensed under GNU GENERAL PUBLIC LICENSE
 * URL: http://www.gnu.org/licenses/gpl.html
 */

namespace se\eab\php\classtailor\model;

use se\eab\php\classtailor\model\content\DependencyContent;
use se\eab\php\classtailor\model\content\FunctionContent;
use se\eab\php\classtailor\model\content\VariableContent;
use se\eab\php\classtailor\model\removable\Removable;
use se\eab\php\classtailor\model\replaceable\Replaceable;
use se\eab\php\classtailor\model\content\TraitContent;
use se\eab\php\classtailor\model\removable\RemovableFunction;

/**
 * Description of ModelFile
 *
 * @author dsvenss
 */
class ClassFile
{

    private $classname;

    private $path;

    /* @var DependencyPattern[] */
    private $dependencies;

    /* @var Removable[] */
    private $removables;
    /* @var RemovableFunction[] */
    private $removableFunctions;

    /* @var VariableContent[] */
    private $variables;

    /* @var FunctionContent[] */
    private $functions;

    /* @var TraitContent[] */
    private $traits;

    /* @var Replaceable[] */
    private $replaceables;

    public function __construct($classname)
    {
        $this->classname = $classname;
        $this->dependencies = [];
        $this->removables = [];
        $this->variables = [];
        $this->functions = [];
        $this->traits = [];
        $this->replaceables = [];
        $this->removableFunctions = [];
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function addFunction(FunctionContent $fncontent)
    {
        if (!in_array($fncontent, $this->functions)) {
            $this->functions[] = $fncontent;
        }
    }

    public function addVariable(VariableContent $varcontent)
    {
        if (!in_array($varcontent, $this->variables)) {
            $this->variables[] = $varcontent;
        }
    }

    public function addDependency(DependencyContent $depcontent)
    {
        if (!in_array($depcontent, $this->dependencies)) {
            $this->dependencies[] = $depcontent;
        }
    }

    public function addTrait(TraitContent $traitcontent)
    {
        if (!in_array($traitcontent, $this->traits)) {
            $this->traits[] = $traitcontent;
            if ($traitcontent->hasDependency()) {
                $this->addDependency($traitcontent->getDependencyContent());
            }
        }
    }

    public function addRemovableFunction(RemovableFunction $removablefn)
    {
        if (!in_array($removablefn, $this->removableFunctions)) {
            $this->removables[] = $removablefn;
            $this->removableFunctions[] = $removablefn;
        }
    }

    public function addReplaceable(Replaceable $replaceable)
    {
        if (!in_array($replaceable, $this->replaceables)) {
            $this->replaceables[] = $replaceable;
        }
    }

    public function getPath()
    {
        return $this->path;
    }

    /**
     *
     * @return Removable[]
     */
    public function getRemovables()
    {
        return $this->removables;
    }

    /**
     * @return RemovableFunction[]
     */
    public function getRemovableFunctions()
    {
        return $this->removableFunctions;
    }

    /**
     *
     * @return VariableContent[]
     */
    public function getVariables()
    {
        return $this->variables;
    }

    /**
     *
     * @return DependencyContent[]
     */
    public function getDependencies()
    {
        return $this->dependencies;
    }

    /**
     *
     * @return FunctionContent[]
     */
    public function getFunctions()
    {
        return $this->functions;
    }

    /**
     * @return Replaceable[]
     */
    public function getReplaceables()
    {
        return $this->replaceables;
    }

    public function getTraits()
    {
        return $this->traits;
    }

    public function hasDependencies()
    {
        return count($this->dependencies) > 0;
    }

    public function hasTraits()
    {
        return count($this->traits) > 0;
    }

    public function hasReplaceables()
    {
        return count($this->replaceables) > 0;
    }

    public function hasRemovables()
    {
        return count($this->removables) > 0;
    }

    public function hasRemovableFunctions()
    {
        return count($this->removableFunctions) > 0;
    }

    public function hasVariables()
    {
        return count($this->functions) > 0;
    }

    public function hasFunctions()
    {
        return count($this->functions) > 0;
    }

    public function getClassName()
    {
        return $this->classname;
    }

    public function mergeClassFile(ClassFile &$classfile)
    {
        if (isset($classfile)) {
            foreach ($classfile->getTraits() as $trait) {
                $this->addTrait($trait);
            }
            foreach ($classfile->getReplaceables() as $replaceable) {
                $this->addReplaceable($replaceable);
            }
            foreach ($classfile->getDependencies() as $dep) {
                $this->addDependency($dep);
            }
            foreach ($classfile->getFunctions() as $fn) {
                $this->addFunction($fn);
            }
            foreach ($classfile->getRemovableFunctions() as $rfn) {
                $this->addRemovableFunction($rfn);
            }
            foreach ($classfile->getVariables() as $var) {
                $this->addVariable($var);
            }
            $this->setPath($classfile->getPath());
        }
    }
}
