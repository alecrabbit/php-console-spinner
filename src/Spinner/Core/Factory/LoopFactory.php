<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\ILoopAdapter;
use AlecRabbit\Spinner\Core\Contract\ILoopProbesManager;
use AlecRabbit\Spinner\Core\Factory\A\AFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;

final class LoopFactory extends AFactory implements ILoopFactory
{
    protected static ?ILoopAdapter $loop = null;

    public function get(): ILoopAdapter
    {
        if (null === self::$loop) {
            self::$loop = $this->getLoopProbesManager()->createLoop();
        }
        return self::$loop;
    }

    protected function getLoopProbesManager(): ILoopProbesManager
    {
        return $this->container->get(ILoopProbesManager::class);
    }
}
