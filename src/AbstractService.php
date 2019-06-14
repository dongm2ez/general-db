<?php

namespace Dongm2ez\Db;

use Dongm2ez\Db\Traits\ListsGuardsTrait;
use Dongm2ez\Db\Traits\ListsParamsTrait;

abstract class AbstractService
{
    use ListsParamsTrait;
    use ListsGuardsTrait;
}
