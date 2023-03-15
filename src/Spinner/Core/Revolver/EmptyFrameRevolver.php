<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver;

use AlecRabbit\Spinner\I\IFrame;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\Revolver\A\ARevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;

final class EmptyFrameRevolver extends ARevolver
{
    protected IFrame $currentFrame;

    protected function __construct()
    {
        parent::__construct(new Interval());
        $this->currentFrame = FrameFactory::createEmpty();
    }

    public static function create(): IRevolver
    {
        return new self();
    }

    public function update(float $dt = null): IFrame
    {
        return $this->current();
    }

    protected function current(): IFrame
    {
        return $this->currentFrame;
    }

    protected function next(float $dt = null): void
    {
        // do nothing
    }
}
