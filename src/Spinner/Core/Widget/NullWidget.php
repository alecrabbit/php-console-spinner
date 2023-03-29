<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Factory\StaticFrameFactory;
use AlecRabbit\Spinner\Core\Factory\StaticIntervalFactory;
use AlecRabbit\Spinner\Core\Widget\A\AWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Exception\LogicException;

/** @psalm-suppress PropertyNotSetInConstructor */ // initialized in [9fb243f6-24f6-4c10-bf0f-c80ec4236c8e]
final class NullWidget extends AWidgetComposite
{
    protected IFrame $currentFrame;
    protected IInterval $interval;

    /**
     * @noinspection MagicMethodsValidityInspection
     * @noinspection PhpMissingParentConstructorInspection
     */
    public function __construct()
    {
        $this->currentFrame = StaticFrameFactory::createEmpty();
        $this->interval = StaticIntervalFactory::createStill();
        $this->initialize(); // initialize properties [9fb243f6-24f6-4c10-bf0f-c80ec4236c8e]
    }

    public static function create(): IWidgetComposite
    {
        return new self();
    }

    public function update(float $dt = null): IFrame
    {
        return $this->currentFrame;
    }

    /**
     * @throws LogicException
     */
    public function add(IWidgetComposite|IWidgetContext $element): IWidgetContext
    {
        self::throwThisIsNotAComposite();
    }

    /**
     * @throws LogicException
     */
    protected static function throwThisIsNotAComposite(): never
    {
        throw new LogicException(
            sprintf('%s is not a composite.', self::class)
        );
    }

    /**
     * @throws LogicException
     */
    public function remove(IWidgetComposite|IWidgetContext $element): void
    {
        self::throwThisIsNotAComposite();
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }
}
