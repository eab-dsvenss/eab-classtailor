<?php

/*
 * Licensed under GNU GENERAL PUBLIC LICENSE
 * URL: http://www.gnu.org/licenses/gpl.html
 */

namespace se\eab\php\classtailor\test;

use se\eab\php\classtailor\model\content\AppendableContent;
use se\eab\php\classtailor\model\removable\Removable;

/**
 * Description of ClassFileTestHelper
 *
 * @author dsvenss
 */
class ClassFileTestHelper
{

    public static function getContentAssertLambda($content, $phpunit, $negate)
    {
        return function(AppendableContent $appendableContent) use ($content, $phpunit, $negate) {
            $generatedContent = self::stripAllWhiteSpace($appendableContent->getContent());
            $strippedContent = self::stripAllWhiteSpace($content);
            if ($negate) {
                $phpunit->assertNotContains($generatedContent, $strippedContent);
            } else {
                $phpunit->assertContains($generatedContent, $strippedContent);
            }
        };
    }

    private static function stripAllWhiteSpace($content)
    {
        return preg_replace('/\s+/', '', $content);
    }

    public static function getRemoveAssertLambda($content, $phpunit, $negate)
    {
        return function(Removable $removable) use ($content, $phpunit, $negate) {
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

}
