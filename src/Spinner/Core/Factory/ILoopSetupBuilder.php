<?php
declare(strict_types=1);
// 06.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\ILoopSetup;

interface ILoopSetupBuilder
{
    public function build(): ILoopSetup;
}
