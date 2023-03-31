<?php

declare(strict_types=1);
// 16.03.23
namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\IPattern;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;

interface IStaticRevolverFactory
{
    public static function create(IPattern $pattern, ?IDefaults $defaults = null): IRevolver;

    public static function getRevolverBuilder(?IDefaults $defaults = null): IFrameRevolverBuilder;

    public static function defaultStyleRevolver(): IRevolver;

    public static function defaultCharRevolver(): IRevolver;
}
