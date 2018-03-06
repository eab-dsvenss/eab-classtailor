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
    public function __construct($depstr)
    {
        $this->content = "use ".trim($depstr) . ";";
    }
}
