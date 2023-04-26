<?php

declare(strict_types=1);

// 04.04.23

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract\IDriverLinker;

interface IDriverLinkerSingletonFactory
{
    public function getDriverLinker(): IDriverLinker;
}
