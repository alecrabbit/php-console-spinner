<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Factory\Contract;

use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;

interface IWidgetFactory
{
    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    public static function createEmpty(): IWidgetComposite;

    public static function getWidgetBuilder(): IWidgetBuilder;

    public static function getWidgetRevolverBuilder(): IWidgetRevolverBuilder;
}
