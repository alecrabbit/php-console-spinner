<?php

declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Contract\IConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Contract\ILegacyDriver;
use AlecRabbit\Spinner\Core\Contract\ILegacyDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\IBufferedOutputBuilder;
use AlecRabbit\Spinner\Core\Contract\ITimerBuilder;
use LogicException;

final class LegacyDriverBuilder implements ILegacyDriverBuilder
{
    protected ?IDriverConfig $driverConfig = null;
    protected ?IAuxConfig $auxConfig = null;

    public function __construct(
        protected ITimerBuilder $timerBuilder,
        protected IBufferedOutputBuilder $outputBuilder,
        protected IConsoleCursorBuilder $cursorBuilder,
    ) {
    }

    public function build(): ILegacyDriver
    {
        if (null === $this->driverConfig) {
            throw new LogicException(
                sprintf('[%s]: Property $driverConfig is not set.', __CLASS__)
            );
        }
        return $this->createDriver();
    }


    private function createDriver(): LegacyDriver
    {
        $output =
            $this->outputBuilder
                ->withStreamHandler(
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
            new LegacyDriver(
                output: $output,
                cursor: $cursor,
                timer: $timer,
                driverConfig: $this->driverConfig,
            );
    }

    public function withAuxConfig(IAuxConfig $auxConfig): ILegacyDriverBuilder
    {
        $this->auxConfig = $auxConfig;
        return $this;
    }

    public function withDriverConfig(IDriverConfig $driverConfig): ILegacyDriverBuilder
    {
        $this->driverConfig = $driverConfig;
        return $this;
    }
}
