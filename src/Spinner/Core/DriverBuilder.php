<?php

declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IDriver;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Contract\ICursorBuilder;
use AlecRabbit\Spinner\Core\Contract\IOutputBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\ITimerBuilder;
use LogicException;

final class DriverBuilder implements IDriverBuilder
{
    protected ?IDriverConfig $driverConfig = null;
    protected ?IAuxConfig $auxConfig = null;

    public function __construct(
        protected ITimerBuilder $timerBuilder,
        protected IOutputBuilder $outputBuilder,
        protected ICursorBuilder $cursorBuilder,
    ) {
    }

    public function build(): IDriver
    {
        if (null === $this->driverConfig) {
            throw new LogicException(
                sprintf('[%s]: Property $driverConfig is not set.', __CLASS__)
            );
        }
        return $this->createDriver();
    }


    private function createDriver(): Driver
    {
        $output =
            $this->outputBuilder
                ->withStream(
                    $this->auxConfig->getOutputStream()
                )
                ->build()
        ;

        $cursor =
            $this->cursorBuilder
                ->withOutput($output)
                ->withCursorOption(
                    $this->auxConfig->getCursorOption()
                )
                ->build()
        ;

        $timer =
            $this->timerBuilder
                ->build()
        ;

        return
            new Driver(
                output: $output,
                cursor: $cursor,
                timer: $timer,
                driverConfig: $this->driverConfig,
            );
    }

    public function withAuxConfig(IAuxConfig $auxConfig): IDriverBuilder
    {
        $this->auxConfig = $auxConfig;
        return $this;
    }

    public function withDriverConfig(IDriverConfig $driverConfig): IDriverBuilder
    {
        $this->driverConfig = $driverConfig;
        return $this;
    }
}
