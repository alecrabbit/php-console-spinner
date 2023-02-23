<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Factory\Contract;

use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;

interface IWidgetFactory
{
    public static function getWidgetBuilder(): IWidgetBuilder;

    public static function getWidgetRevolverBuilder(): IWidgetRevolverBuilder;

    public static function create(): IWidgetComposite;
}
