<?php

/*
 * Licensed under GNU GENERAL PUBLIC LICENSE
 * URL: http://www.gnu.org/licenses/gpl.html
 */

namespace se\eab\php\classtailor\model\replaceable;

/**
 * Description of Replaceable
 *
 * @author dsvenss
 */
class Replaceable
{
    protected $pattern;
    protected $replacement;
    
    public function __construct($pattern, $replacement) {
        $this->pattern = $pattern;
        $this->replacement = $replacement;
    }
    
    public function getPattern() {
        return $this->pattern;
    }
    
    public function getReplacement() {
        return $this->replacement;
    }
    
}
