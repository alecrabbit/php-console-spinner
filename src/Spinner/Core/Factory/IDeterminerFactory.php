<?php
declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\IDeterminer;

interface IDeterminerFactory
{
    public function create(): IDeterminer;
}