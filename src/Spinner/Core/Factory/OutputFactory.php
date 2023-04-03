<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\IOutput;
use AlecRabbit\Spinner\Core\Config\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\IOutputFactory;
use AlecRabbit\Spinner\Core\Output\ResourceStream;
use AlecRabbit\Spinner\Core\Output\StreamBufferedOutput;

final class OutputFactory implements IOutputFactory
{
    protected static ?IOutput $output = null;

    public function __construct(
        protected IDefaultsProvider $defaultsProvider,
    ) {
    }

    public function getOutput(): IOutput
    {
        if (null === self::$output) {
            self::$output = $this->createOutput();
        }
        return self::$output;
    }

    protected function createOutput(): IOutput
    {
        return
            new StreamBufferedOutput(
                new ResourceStream($this->getOutputStream())
            );
    }

    /**
     * @return resource
     */
    private function getOutputStream()
    {
        return $this->defaultsProvider->getAuxSettings()->getOutputStream();
    }
}