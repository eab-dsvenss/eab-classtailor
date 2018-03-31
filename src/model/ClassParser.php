<?php

/*
 * Licensed under GNU GENERAL PUBLIC LICENSE
 * URL: http://www.gnu.org/licenses/gpl.html
 */

namespace se\eab\php\classtailor\model;

use se\eab\php\classtailor\model\removable\Removable;
use se\eab\php\classtailor\model\content\AppendableContent;
use se\eab\php\classtailor\model\content\DependencyContent;
use se\eab\php\classtailor\model\replaceable\Replaceable;
use se\eab\php\classtailor\model\content\TraitContent;

/**
 * Description of FileParser
 *
 * @author dsvenss
 */
class ClassParser
{

    private static $instance;
    private $tabstr = '';

    private function __construct($tablen)
    {
        $this->setTabStr($tablen);
    }

    private function setTabStr($tablen)
    {
        for ($i = 0; $i < $tablen; $i++) {
            $this->tabstr .= " ";
        }
    }

    /**
     *
     * @return ClassParser
     */
    public static function getInstance($tablen = 4)
    {
        if (!isset(self::$instance)) {
            self::$instance = new ClassParser($tablen);
        }

        return self::$instance;
    }

    public function removeRemovable(&$classcontent, Removable $rempattern)
    {
        $pattern = "/(.*?)(" . $rempattern->getPattern() . ")(.*?)/";
        $classcontent = preg_replace($pattern, "$1$3", $classcontent);
    }

    private function addToBeginningOfClass(&$classcontent, $content)
    {
        $contentString = "{" . PHP_EOL;
        foreach (explode(PHP_EOL, $content) as $cstr) {
            $contentString .= $this->tabstr . $cstr . PHP_EOL;
        }

        $classcontent = preg_replace("/^([^\}]*?)(\{)(.*?)/", "$1$contentString$3", $classcontent);
    }

    public function addVariable(&$classcontent, AppendableContent $content)
    {
        $this->addToBeginningOfClass($classcontent, $content->getContent());
    }

    public function addFunction(&$classcontent, AppendableContent $content)
    {
        $this->addToBeginningOfClass($classcontent, $content->getContent());
    }

    public function addDependency(&$classcontent, DependencyContent $dependency)
    {
        $depString = ";" . PHP_EOL;
        $depString .= $dependency->getContent() . PHP_EOL;

        $classcontent = preg_replace("/^([^;]*?)(;)(.*?)/", "$1$depString$3", $classcontent);
    }

    public function addTrait(&$classcontent, TraitContent $trait)
    {
        $this->addToBeginningOfClass($classcontent, $trait->getContent());
        if ($trait->hasDependency()) {
            $this->addDependency($classcontent, $trait->getDependencyContent());
        }
    }

    public function replace(&$classcontent, Replaceable $replaceable)
    {
        $classcontent = preg_replace("/" . $replaceable->getPattern() . "/", $replaceable->getReplacement(), $classcontent);
    }

}
