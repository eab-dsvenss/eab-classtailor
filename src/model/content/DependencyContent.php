<?php

/*
 * Licensed under GNU GENERAL PUBLIC LICENSE
 * URL: http://www.gnu.org/licenses/gpl.html
 */

namespace se\eab\php\classtailor\model\content;

use se\eab\php\classtailor\model\content\AppendableContent;

/**
 * Description of Dependency
 *
 * @author dsvenss
 */
class DependencyContent extends AppendableContent
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
        $this->content = "use ".trim($name) . ";";
    }

    public function getName() {
        return $this->name;
    }
}
