<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;

interface IStaticWidgetFactory
{
    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    public static function createEmpty(): IWidgetComposite;

    public static function getWidgetBuilder(?IDefaults $defaults = null): IWidgetBuilder;

    public static function getWidgetRevolverBuilder(?IDefaults $defaults = null): IWidgetRevolverBuilder;

    public static function create(
        IRevolver $revolver,
        ?IFrame $leadingSpacer = null,
        ?IFrame $trailingSpacer = null,
    ): IWidgetComposite;
}
