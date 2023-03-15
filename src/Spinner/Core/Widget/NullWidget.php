<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\I\IFrame;
use AlecRabbit\Spinner\I\IInterval;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\Widget\A\AWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Exception\LogicException;

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
        $this->currentFrame = FrameFactory::createEmpty();
        $this->interval = new Interval();
        $this->context = new WidgetContext($this);
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
