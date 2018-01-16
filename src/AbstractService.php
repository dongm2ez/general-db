<?php
/**
 * Created by PhpStorm.
 * User: dongyuxiang
 * Date: 16/01/2018
 * Time: 16:48
 */

namespace Dongm2ez\Db;


use Dongm2ez\Db\Traits\ListsGuardsTrait;
use Dongm2ez\Db\Traits\ListsParamsTrait;

abstract class AbstractService
{
    use ListsParamsTrait;
    use ListsGuardsTrait;
}