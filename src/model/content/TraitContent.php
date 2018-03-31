<?php

/*
 * Licensed under GNU GENERAL PUBLIC LICENSE
 * URL: http://www.gnu.org/licenses/gpl.html
 */

namespace se\eab\php\classtailor\model\content;

use se\eab\php\classtailor\model\content\AppendableContent;
use se\eab\php\classtailor\model\content\DependencyContent;

/**
 * Description of Dependency
 *
 * @author dsvenss
 */
class TraitContent extends AppendableContent
{

    private $dependency;

    public function __construct($traitstr, $dependencystr = NULL)
    {
        $this->content = "use ".trim($traitstr) . ";";

        if (isset($dependencystr)) {
            $this->dependency = new DependencyContent($dependencystr);
        }
    }

    public function hasDependency()
    {
        return isset($this->dependency);
    }

    public function getDependencyContent()
    {
        return $this->dependency;
    }
}
