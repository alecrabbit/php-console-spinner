<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Asynchronous\Legacy;

use AlecRabbit\Spinner\Asynchronous\Factory\LegacyLoopProbeFactory;
use AlecRabbit\Spinner\Core\Contract\Loop\A\ALoopProbe;
use AlecRabbit\Spinner\Core\Factory\Contract\ILegacyLoopProbeFactory;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use AlecRabbit\Tests\Unit\Spinner\Asynchronous\Stub\LoopProbeStub;
use ArrayObject;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Traversable;

final class LegacyLoopProbeFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $loopProbesFactory = $this->getTesteeInstance();

        self::assertInstanceOf(LegacyLoopProbeFactory::class, $loopProbesFactory);
    }

    public function getTesteeInstance(
        ?Traversable $loopProbes = null,
    ): ILegacyLoopProbeFactory {
        return new LegacyLoopProbeFactory(
            loopProbes: $loopProbes ?? $this->getLoopProbesMock(),
        );
    }

    private function getLoopProbesMock(): MockObject&Traversable
    {
        return $this->createMock(Traversable::class);
    }

    #[Test]
    public function throwsWhenNoSupportedLoopFound(): void
    {
        $loopProbesFactory = $this->getTesteeInstance();

        $exception = DomainException::class;
        $exceptionMessage =
            'No supported event loop found.'
            . ' Check that you have installed one of the supported event loops.'
            . ' Check your probes list if you have modified it.'
            . ' If yoy what to use library in synchronous mode, set option explicitly.';

        $this->expectException($exception);
        $this->expectExceptionMessage($exceptionMessage);

        $loopProbe = $loopProbesFactory->createProbe();

        self::assertInstanceOf(ALoopProbe::class, $loopProbe);

        self::failTest(self::exceptionNotThrownString($exception, $exceptionMessage));
    }

    #[Test]
    public function canReturnLoopProbe(): void
    {
        $loopProbes = new ArrayObject([
            LoopProbeStub::class,
        ]);

        $loopProbesFactory = $this->getTesteeInstance(loopProbes: $loopProbes);

        $loopProbe = $loopProbesFactory->createProbe();

        self::assertInstanceOf(ALoopProbe::class, $loopProbe);
    }
}
