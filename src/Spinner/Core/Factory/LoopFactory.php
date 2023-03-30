<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\Contract\ILoopAdapter;
use AlecRabbit\Spinner\Core\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Core\Factory\A\AFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;

final class LoopFactory extends AFactory implements ILoopFactory
{
    protected static ?ILoopAdapter $loop = null;

    public function __construct(
        IContainer $container,
        protected ILoopProbeFactory $loopProbeFactory,
    ) {
        parent::__construct($container);
    }

    public function getLoop(): ILoopAdapter
    {
        if (null === self::$loop) {
            self::$loop = $this->createLoop();
        }
        return self::$loop;
    }

    protected function createLoop(): ILoopAdapter
    {
        return $this->getLoopProbe()->createLoop();
    }

    protected function getLoopProbe(): ILoopProbe
    {
        return $this->loopProbeFactory->getProbe();
    }
}
