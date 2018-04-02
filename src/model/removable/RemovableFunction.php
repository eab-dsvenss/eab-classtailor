<?php

/*
 * Licensed under GNU GENERAL PUBLIC LICENSE
 * URL: http://www.gnu.org/licenses/gpl.html
 */
namespace se\eab\php\classtailor\model\removable;

use se\eab\php\classtailor\model\removable\Removable;
/**
 * Description of RemovableFunctionContent
 *
 * @author dsvenss
 */
class RemovableFunction extends Removable
{

    private $access;
    private $name;
    private $content;

    public function __construct($fnaccess, $fnname, $fncontent)
    {
        $this->pattern = "$fnaccess function ".$fnname."\([^\{]*?{[^\}]*?".$fncontent."[^\}]*?}";
    }

    public function getAccess() {
        return $this->access;
    }

    public function getName() {
        return $this->name;
    }

    public function getContent() {
        return $this->content;
    }
}
