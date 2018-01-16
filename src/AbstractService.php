<?php
/**
 * Created by PhpStorm.
 * User: dongyuxiang
 * Date: 16/01/2018
 * Time: 16:48
 */

namespace Dongm2ez\db;


use Dongm2ez\db\Traits\ListsGuardsTrait;
use Dongm2ez\db\Traits\ListsParamsTrait;

abstract class AbstractService
{
    use ListsParamsTrait;
    use ListsGuardsTrait;
}