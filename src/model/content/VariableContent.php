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
    private $value;

    public function __construct($access, $name, $value = NULL)
    {
        $this->access = $access;
        $this->name = $name;
        $this->value = $value;
        $this->content = trim($access) . " $" . trim($name) . (isset($value) ? " = $value" : "") . ";";
    }

    public function getAccess() {
        return $this->access;
    }

    public function getName() {
        return $this->name;
    }

    public function hasValue() {
        return isset($this->value);
    }

    public function getValue() {
        return $this->value;
    }

}
