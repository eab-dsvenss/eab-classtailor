<?php

/*
 * Licensed under GNU GENERAL PUBLIC LICENSE
 * URL: http://www.gnu.org/licenses/gpl.html
 */

namespace se\eab\php\classtailor\model\content;

use se\eab\php\classtailor\model\content\AppendableContent;

/**
 * Description of Function
 *
 * @author dsvenss
 */
class FunctionContent extends AppendableContent
{
    public function __construct($fnpattern)
    {
        $this->content = trim($fnpattern);
    }
}
