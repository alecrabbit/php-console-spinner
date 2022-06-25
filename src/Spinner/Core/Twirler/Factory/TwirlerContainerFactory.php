<?php

declare(strict_types=1);
// 21.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Factory;

use AlecRabbit\Spinner\Core\Container;
use AlecRabbit\Spinner\Core\Contract\IContainer;
use AlecRabbit\Spinner\Core\Contract\IIntervalVisitor;
use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;
use AlecRabbit\Spinner\Core\Twirler\Factory\Contract\ITwirlerContainerFactory;

final class TwirlerContainerFactory implements ITwirlerContainerFactory
{
    public function __construct(
        private readonly IInterval $interval,
        private readonly IIntervalVisitor $intervalVisitor,
    ) {
    }

    public function createContainer(): IContainer
    {
        return
            new Container(
                $this->interval,
                $this->intervalVisitor,
            );
    }
}
