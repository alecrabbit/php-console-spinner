<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Factory\Contract\ILegacyTerminalProbeFactory;
use AlecRabbit\Spinner\Core\Factory\Legacy\LegacyTerminalProbeFactory;
use AlecRabbit\Spinner\Core\Terminal\A\ATerminalLegacyProbe;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use AlecRabbit\Tests\Unit\Spinner\Core\Factory\Stub\TerminalLegacyProbeStub;
use ArrayObject;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Traversable;

final class TerminalProbeFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $terminalProbeFactory = $this->getTesteeInstance();

        self::assertInstanceOf(LegacyTerminalProbeFactory::class, $terminalProbeFactory);
    }

    public function getTesteeInstance(
        ?Traversable $terminalProbes = null,
    ): ILegacyTerminalProbeFactory {
        return new LegacyTerminalProbeFactory(
            probeClasses: $terminalProbes ?? $this->getTerminalProbesMock(),
        );
    }

    private function getTerminalProbesMock(): MockObject&Traversable
    {
        return $this->createMock(Traversable::class);
    }

    #[Test]
    public function throwsWhenNoAvailableProbeFound(): void
    {
        $terminalProbeFactory = $this->getTesteeInstance();

        $exception = DomainException::class;
        $exceptionMessage = 'No terminal probe found.';

        $this->expectException($exception);
        $this->expectExceptionMessage($exceptionMessage);

        $terminalProbe = $terminalProbeFactory->getProbe();

        self::assertInstanceOf(ATerminalLegacyProbe::class, $terminalProbe);

        self::failTest(self::exceptionNotThrownString($exception, $exceptionMessage));
    }

    #[Test]
    public function canReturnTerminalProbe(): void
    {
        $terminalProbes = new ArrayObject([
            TerminalLegacyProbeStub::class,
        ]);

        $terminalProbeFactory = $this->getTesteeInstance(terminalProbes: $terminalProbes);

        $terminalProbe = $terminalProbeFactory->getProbe();

        self::assertInstanceOf(ATerminalLegacyProbe::class, $terminalProbe);
    }
}
