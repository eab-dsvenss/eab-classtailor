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

    private $access;
    private $name;

    public function __construct($access, $name)
    {
        $this->access = $access;
        $this->name = $name;
        $this->content = trim($access) . " $" . trim($name) . ";";
    }

    public function getAccess() {
        return $this->access;
    }

    public function getName() {
        return $this->name;
    }

}
