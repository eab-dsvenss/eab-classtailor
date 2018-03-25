<?php

/*
 * Licensed under GNU GENERAL PUBLIC LICENSE
 * URL: http://www.gnu.org/licenses/gpl.html
 */

namespace se\eab\php\classtailor\model\content;

use se\eab\php\classtailor\model\content\AppendableContent;

/**
 * Description of Variable
 *
 * @author dsvenss
 */
class VariableContent extends AppendableContent
{

    public function __construct($varaccess, $name)
    {
        $this->content = trim($varaccess) . " $" . trim($name) . ";";
    }

}
