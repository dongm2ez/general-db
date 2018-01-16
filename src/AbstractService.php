<?php
/**
 * Created by PhpStorm.
 * User: dongyuxiang
 * Date: 16/01/2018
 * Time: 16:48
 */

namespace db;


use db\Traits\ListsGuardsTrait;
use db\Traits\ListsParamsTrait;

abstract class AbstractService
{
    use ListsParamsTrait;
    use ListsGuardsTrait;
}