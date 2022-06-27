<?php

declare(strict_types=1);
// 21.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Factory;

use AlecRabbit\Spinner\Core\Container;
use AlecRabbit\Spinner\Core\Contract\IContainer;
use AlecRabbit\Spinner\Core\Contract\IIntervalVisitor;
use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;
use AlecRabbit\Spinner\Core\Twirler\Factory\Contract\ITwirlerContainerFactory;
use AlecRabbit\Spinner\Core\Twirler\Factory\Contract\ITwirlerFactory;

final class TwirlerContainerFactory implements ITwirlerContainerFactory
{
    public function __construct(
        private readonly IInterval $interval,
        private readonly IIntervalVisitor $intervalVisitor,
        private readonly ITwirlerFactory $twirlerFactory,
    ) {
    }

    public function createContainer(bool $asMulti): IContainer
    {
        $container = new Container(
            $this->interval,
            $this->intervalVisitor,
            $asMulti,
        );
        if (!$asMulti) {
            $this->fillWithDefaults($container);
        }
        return
            $container;
    }

    private function fillWithDefaults(Container $container): void
    {
        $container->spinner(
            $this->twirlerFactory->spinner(),
        );
        $container->message(
            $this->twirlerFactory->message(),
        );
        $container->progress(
            $this->twirlerFactory->progress(),
        );
    }
}
