<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Asynchronous\Factory;

use AlecRabbit\Spinner\Asynchronous\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Asynchronous\Factory\LoopProbeFactory;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\Loop\Probe\A\ALoopProbe;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use AlecRabbit\Tests\Spinner\Unit\Spinner\Asynchronous\Factory\Stub\LoopProbeStub;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Traversable;

final class LoopProbeFactoryTest extends TestCase
{
    #[Test]
    public function canBeCreated(): void
    {
        $loopProbesFactory = $this->getTesteeInstance(container: null);

        self::assertInstanceOf(LoopProbeFactory::class, $loopProbesFactory);
    }

    public function getTesteeInstance(
        (MockObject&IContainer)|null $container,
        ?Traversable $loopProbes = null,
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

    #[Test]
    public function throwsWhenNoSupportedLoopFound(): void
    {
        $loopProbesFactory = $this->getTesteeInstance(container: null);

        $exception = DomainException::class;
        $exceptionMessage =
            'No supported event loop found.'
            . ' Check you have installed one of the supported event loops.'
            . ' Check your probes list if you have modified it.';

        $this->expectException($exception);
        $this->expectExceptionMessage($exceptionMessage);

        $loopProbe = $loopProbesFactory->getProbe();

        self::assertInstanceOf(ALoopProbe::class, $loopProbe);

        self::exceptionNotThrown($exception, $exceptionMessage);
    }

    #[Test]
    public function canReturnLoopProbe(): void
    {
        $container = $this->createMock(IContainer::class);
        $container->expects(self::once())
            ->method('get')
            ->with(LoopProbeStub::class)
            ->willReturn(new LoopProbeStub());

        $loopProbes = new \ArrayObject([
            LoopProbeStub::class,
        ]);

        $loopProbesFactory = $this->getTesteeInstance(container: $container, loopProbes: $loopProbes);


        $loopProbe = $loopProbesFactory->getProbe();

        self::assertInstanceOf(ALoopProbe::class, $loopProbe);
    }
}
