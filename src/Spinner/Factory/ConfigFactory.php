<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Factory;

use AlecRabbit\Spinner\Adapter\Loop\ReactLoopAdapter;
use AlecRabbit\Spinner\Contract\ILoop;
use AlecRabbit\Spinner\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Factory\Contract\IConfigFactory;
use AlecRabbit\Spinner\SpinnerConfig;
use React\EventLoop\Loop;

final class ConfigFactory implements IConfigFactory
{

    public static function createDefault(): ISpinnerConfig
    {
        return new SpinnerConfig(
            loop: self::getLoop(),
        );
    }

    private static function getLoop(): ILoop
    {
        return new ReactLoopAdapter(Loop::get());
    }
}
