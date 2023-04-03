<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\IOutput;
use AlecRabbit\Spinner\Core\Config\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Config\IOutputFactory;
use AlecRabbit\Spinner\Core\Output\ResourceStream;
use AlecRabbit\Spinner\Core\Output\StreamBufferedOutput;

final class OutputFactory implements IOutputFactory
{
    public function __construct(
        protected IDefaultsProvider $defaultsProvider,
    ) {
    }

    public function getOutput(): IOutput
    {
        return new StreamBufferedOutput(new ResourceStream(STDERR));
    }
}