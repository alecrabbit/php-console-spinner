<?php
declare(strict_types=1);
// 06.04.23
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;

interface ILoopSetupBuilder
{
    public function build(): ILoopSetup;

    public function withConfig(ILoopConfig $config): ILoopSetupBuilder;

    public function withLoop(ILoop $loop): ILoopSetupBuilder;
}
