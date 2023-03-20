<?php

declare(strict_types=1);
// 16.03.23
namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolverBuilder;

interface IRevolverFactory
{
    public static function create(IPattern $pattern): IRevolver;

    public static function getRevolverBuilder(?IDefaults $defaults = null): IFrameRevolverBuilder;

    public static function defaultStyleRevolver(): IRevolver;

    public static function defaultCharRevolver(): IRevolver;
}