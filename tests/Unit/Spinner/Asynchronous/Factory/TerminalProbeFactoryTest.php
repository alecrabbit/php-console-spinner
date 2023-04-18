<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Asynchronous\Factory;

use AlecRabbit\Spinner\Core\Contract\Loop\A\ALoopProbe;
use AlecRabbit\Spinner\Core\Factory\Contract\ITerminalProbeFactory;
use AlecRabbit\Spinner\Core\Factory\TerminalProbeFactory;
use AlecRabbit\Spinner\Core\Terminal\A\ATerminalProbe;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use AlecRabbit\Tests\Unit\Spinner\Asynchronous\Factory\Stub\TerminalProbeStub;
use ArrayObject;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Traversable;

final class TerminalProbeFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $terminalProbeFactory = $this->getTesteeInstance();

        self::assertInstanceOf(TerminalProbeFactory::class, $terminalProbeFactory);
    }

    public function getTesteeInstance(
        ?Traversable $terminalProbes = null,
    ): ITerminalProbeFactory {
        return new TerminalProbeFactory(
            terminalProbes: $terminalProbes ?? $this->getTerminalProbesMock(),
        );
    }

    private function getTerminalProbesMock(): MockObject&Traversable
    {
        return $this->createMock(Traversable::class);
    }

    #[Test]
    public function throwsWhenNoSupportedLoopFound(): void
    {
        $terminalProbeFactory = $this->getTesteeInstance();

        $exception = DomainException::class;
        $exceptionMessage = 'No terminal probe found.';

        $this->expectException($exception);
        $this->expectExceptionMessage($exceptionMessage);

        $loopProbe = $terminalProbeFactory->getProbe();

        self::assertInstanceOf(ALoopProbe::class, $loopProbe);

        self::failTest(self::exceptionNotThrownString($exception, $exceptionMessage));
    }

    #[Test]
    public function canReturnTerminalProbe(): void
    {
        $terminalProbes = new ArrayObject([
            TerminalProbeStub::class,
        ]);

        $terminalProbeFactory = $this->getTesteeInstance(terminalProbes: $terminalProbes);

        $loopProbe = $terminalProbeFactory->getProbe();

        self::assertInstanceOf(ATerminalProbe::class, $loopProbe);
    }
}
