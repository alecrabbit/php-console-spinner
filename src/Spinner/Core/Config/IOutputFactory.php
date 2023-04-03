<?php
declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\IOutput;

interface IOutputFactory
{
    public function getOutput(): IOutput;
}