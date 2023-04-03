<?php
declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract\IDeterminer;

interface IDeterminerFactory
{
    public function create(): IDeterminer;
}