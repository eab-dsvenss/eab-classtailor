<?php

/*
 * Licensed under GNU GENERAL PUBLIC LICENSE
 * URL: http://www.gnu.org/licenses/gpl.html
 */
namespace se\eab\php\classtailor\model;

/**
 * Description of EloquentConstants
 *
 * @author dsvenss
 */
abstract class EloquentConstants
{
    const REMOVE_KEY = "remove";
    const ADD_KEY = "add";
    const ADD_DEPENDENCY_KEY = "addDep";
    const TIMESTAMPS_DISABLE = "public \$timestamps = false;";
    const PRIMERY_KEY_NAME = "protected \$primaryKey = 'name';";
    const INCREMENTING_DISABLE = "public \$incrementing = false;";
}
