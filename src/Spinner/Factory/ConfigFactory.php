<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Factory;

use AlecRabbit\Spinner\Contract\ILoop;
use AlecRabbit\Spinner\Contract\IOutput;
use AlecRabbit\Spinner\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Factory\Contract\IConfigFactory;
use AlecRabbit\Spinner\SpinnerConfig;
use AlecRabbit\Spinner\StdErrOutput;

final class ConfigFactory implements IConfigFactory
{
    public static function create(
        ?IOutput $output = null,
        ?ILoop $loop = null,
        bool $async = true,
    ): ISpinnerConfig {
        return new SpinnerConfig(
            output: $output ?? self::getOutput(),
            loop:   self::refineLoop($loop, $async),
            async:  $async,
        );
    }

    protected static function getOutput(): IOutput
    {
        return new StdErrOutput();
    }

    private static function refineLoop(?ILoop $loop, bool $async): ?ILoop
    {
        if ($loop instanceof ILoop) {
            return $loop;
        }
        if ($async) {
            return self::getLoop();
        }
        return null;
    }

    private static function getLoop(): ILoop
    {
        return LoopFactory::getLoop();
    }
}
