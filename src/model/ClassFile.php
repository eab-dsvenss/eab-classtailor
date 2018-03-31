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

/**
 * Description of ModelFile
 *
 * @author dsvenss
 */
class ClassFile
{

    private $path;

    /* @var DependencyPattern[] */
    private $dependencies;

    /* @var $removables Removable[] */
    private $removables;

    /* @var VariableContent[] */
    private $variables;

    /* @var FunctionContent[] */
    private $functions;

    /* @var TraitContent[] */
    private $traits;
    
    /* @var Replaceable[] */
    private $replaceables;

    public function __construct()
    {
        $this->dependencies = [];
        $this->removables = [];
        $this->variables = [];
        $this->functions = [];
        $this->traits = [];
        $this->replaceables = [];
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function addFunction(FunctionContent $fncontent)
    {
        $this->functions[] = $fncontent;
    }

    public function addVariable(VariableContent $varcontent)
    {
        $this->variables[] = $varcontent;
    }

    public function addDependency(DependencyContent $depcontent)
    {
        $this->dependencies[] = $depcontent;
    }

    public function addTrait(TraitContent $traitcontent) {
        $this->traits[] = $traitcontent;
    }

    public function addRemovable(Removable $removable)
    {
        $this->removables[] = $removable;
    }
    
    public function addReplaceable(Replaceable $replaceable) {
        $this->replaceables[] = $replaceable;
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

    public function getReplaceables()
    {
        return $this->replaceables;
    }

    public function getTraits()
    {
        return $this->traits;
    }

}
