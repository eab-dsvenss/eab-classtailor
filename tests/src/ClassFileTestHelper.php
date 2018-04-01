<?php

/*
 * Licensed under GNU GENERAL PUBLIC LICENSE
 * URL: http://www.gnu.org/licenses/gpl.html
 */

namespace se\eab\php\classtailor\test;

use se\eab\php\classtailor\model\content\AppendableContent;
use se\eab\php\classtailor\model\removable\Removable;
use se\eab\php\classtailor\model\replaceable\Replaceable;
use se\eab\php\classtailor\model\content\TraitContent;
use se\eab\php\classtailor\model\content\FunctionContent;
use se\eab\php\classtailor\model\content\VariableContent;
use se\eab\php\classtailor\model\content\DependencyContent;
use se\eab\php\classtailor\model\removable\RemovableFunction;
use se\eab\php\classtailor\model\ClassFile;



/**
 * Description of ClassFileTestHelper
 *
 * @author dsvenss
 */
class ClassFileTestHelper
{

    public static function getContentAssertLambda($content, $phpunit, $negate)
    {
        return function (AppendableContent $appendableContent) use ($content, $phpunit, $negate) {
            $generatedContent = self::stripAllWhiteSpace($appendableContent->getContent());
            $strippedContent = self::stripAllWhiteSpace($content);
            self::assertStringContains($generatedContent, $strippedContent, $negate, $phpunit);
        };
    }

    public static function getTraitAssertLambda($content, $phpunit, $negate)
    {
        return function (TraitContent $traitContent) use ($content, $phpunit, $negate) {
            $generatedContent = self::stripAllWhiteSpace($traitContent->getContent());
            $strippedContent = self::stripAllWhiteSpace($content);
            self::assertStringContains($generatedContent, $strippedContent, $negate, $phpunit);

            if ($traitContent->hasDependency()) {
                $dependencyContent = self::stripAllWhiteSpace($traitContent->getDependencyContent()->getContent());
                self::assertStringContains($dependencyContent, $strippedContent, $negate, $phpunit);
            }
        };
    }

    public static function getReplaceableAssertLambda($content, $phpunit, $negate)
    {
        return function (Replaceable $replaceable) use ($content, $phpunit, $negate) {
            $replacement = self::stripAllWhiteSpace($replaceable->getReplacement());
            $strippedContent = self::stripAllWhiteSpace($content);
            self::assertStringContains($replacement, $strippedContent, $negate, $phpunit);
        };
    }

    private static function assertStringContains($needle, $haystack, $negate, $phpunit)
    {
        if ($negate) {
            $phpunit->assertNotContains($needle, $haystack);
        } else {
            $phpunit->assertContains($needle, $haystack);
        }
    }

    private static function stripAllWhiteSpace($content)
    {
        return preg_replace('/\s+/', '', $content);
    }

    public static function getRemoveAssertLambda($content, $phpunit, $negate)
    {
        return function (Removable $removable) use ($content, $phpunit, $negate) {
            $match = preg_match("/.*?" . $removable->getPattern() . ".*?/", $content);
            if ($negate) {
                $phpunit->assertNotTrue($match == 1);
            } else {
                $phpunit->assertTrue($match == 1);
            }
        };
    }

    public static function assertOverArray(array $items, $fn)
    {
        foreach ($items as $i) {
            $fn($i);
        }
    }

    public static function createClassFile($path) {
        $classfile = new ClassFile();
        $classfile->setPath($path);
        $classfile->addDependency(new DependencyContent("testdependency"));
        $classfile->addFunction(new FunctionContent(<<<EOT
public function testing() {
    \$testsomething;
}
EOT
        ));
        $classfile->addVariable(new VariableContent("public", "testvariable"));
        $classfile->addRemovable(new RemovableFunction("public", "test", "Test"));
        $classfile->addReplaceable(new Replaceable("public \\\$variable;", "private \$newvariable;"));
        $classfile->addTrait(new TraitContent("Dep1", "se\\test\\Dep1"));
        $classfile->addTrait(new TraitContent("Dep2"));

        return $classfile;
    }

}
