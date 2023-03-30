<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Asynchronous\Factory;

use AlecRabbit\Spinner\Asynchronous\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Asynchronous\Factory\LoopProbeFactory;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Traversable;

final class LoopProbeFactoryTest extends TestCase
{
    #[Test]
    public function canBeCreated(): void
    {
        $loopProbesFactory = $this->getTesteeInstance(container: null, loopProbes: null);

        self::assertInstanceOf(LoopProbeFactory::class, $loopProbesFactory);
    }


    public function getTesteeInstance(
        (MockObject&IContainer)|null $container,
        (MockObject&Traversable)|null $loopProbes
    ): ILoopProbeFactory {
        return
            new LoopProbeFactory(
                container: $container ?? $this->getContainerMock(),
                loopProbes: $loopProbes ?? $this->getLoopProbesMock(),
            );
    }

    protected function getContainerMock(): MockObject&IContainer
    {
        return $this->createMock(IContainer::class);
    }

    private function getLoopProbesMock(): MockObject&Traversable
    {
        return $this->createMock(Traversable::class);
    }


}
