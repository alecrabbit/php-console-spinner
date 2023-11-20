<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Lib\Spinner\Core;

use AlecRabbit\Benchmark\Contract\IBenchmark;
use AlecRabbit\Benchmark\Contract\IStopwatch;
use AlecRabbit\Lib\Spinner\Contract\IBenchmarkingDriver;
use AlecRabbit\Lib\Spinner\Core\BenchmarkingDriver;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class BenchmarkingDriverTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $driver = $this->getTesteeInstance();

        self::assertInstanceOf(BenchmarkingDriver::class, $driver);
    }

    private function getTesteeInstance(
        ?IDriver $driver = null,
        ?IBenchmark $benchmark = null,
        ?IObserver $observer = null,
    ): IBenchmarkingDriver {
        return
            new BenchmarkingDriver(
                driver: $driver ?? $this->getDriverMock(),
                benchmark: $benchmark ?? $this->getBenchmarkMock(),
                observer: $observer,
            );
    }

    private function getDriverMock(): MockObject&IDriver
    {
        return $this->createMock(IDriver::class);
    }

    private function getBenchmarkMock(): MockObject&IBenchmark
    {
        return $this->createMock(IBenchmark::class);
    }

    #[Test]
    public function canGetBenchmark(): void
    {
        $benchmark = $this->getBenchmarkMock();

        $driver =
            $this->getTesteeInstance(
                benchmark: $benchmark
            );

        self::assertSame($benchmark, $driver->getBenchmark(),);
    }

    #[Test]
    public function canRender(): void
    {
        $dt = 100.0;
        $driver = $this->getDriverMock();

        $benchmark = $this->getBenchmarkMock();
        $benchmark
            ->expects(self::once())
            ->method('run')
            ->with(
                $this->getExpectedKey('render'),
                $driver->render(...),
                $dt
            )
        ;

        $benchmarkingDriver = $this->getTesteeInstance(
            driver: $driver,
            benchmark: $benchmark,
        );

        $benchmarkingDriver->render($dt);
    }

    private function getExpectedKey(string $key): string
    {
        return BenchmarkingDriver::class . '::' . $key;
    }

    #[Test]
    public function canAdd(): void
    {
        $spinner = $this->getSpinnerMock();

        $driver = $this->getDriverMock();

        $benchmark = $this->getBenchmarkMock();
        $benchmark
            ->expects(self::once())
            ->method('run')
            ->with(
                $this->getExpectedKey('add'),
                $driver->add(...),
                $spinner
            )
        ;

        $benchmarkingDriver = $this->getTesteeInstance(
            driver: $driver,
            benchmark: $benchmark,
        );

        $benchmarkingDriver->add($spinner);
    }

    private function getSpinnerMock(): MockObject&ISpinner
    {
        return $this->createMock(ISpinner::class);
    }

    #[Test]
    public function canRemove(): void
    {
        $spinner = $this->getSpinnerMock();
        $driver = $this->getDriverMock();
        $benchmark = $this->getBenchmarkMock();
        $benchmark
            ->expects(self::once())
            ->method('run')
            ->with(
                $this->getExpectedKey('remove'),
                $driver->remove(...),
                $spinner
            )
        ;

        $benchmarkingDriver = $this->getTesteeInstance(
            driver: $driver,
            benchmark: $benchmark,
        );

        $benchmarkingDriver->remove($spinner);
    }

    #[Test]
    public function canInitialize(): void
    {
        $driver = $this->getDriverMock();
        $benchmark = $this->getBenchmarkMock();
        $benchmark
            ->expects(self::once())
            ->method('run')
            ->with(
                $this->getExpectedKey('initialize'),
                $driver->initialize(...),
            )
        ;

        $benchmarkingDriver = $this->getTesteeInstance(
            driver: $driver,
            benchmark: $benchmark,
        );

        $benchmarkingDriver->initialize();
    }

    #[Test]
    public function canInterrupt(): void
    {
        $message = 'message';
        $driver = $this->getDriverMock();
        $benchmark = $this->getBenchmarkMock();
        $benchmark
            ->expects(self::once())
            ->method('run')
            ->with(
                $this->getExpectedKey('interrupt'),
                $driver->interrupt(...),
                $message
            )
        ;

        $benchmarkingDriver = $this->getTesteeInstance(
            driver: $driver,
            benchmark: $benchmark,
        );

        $benchmarkingDriver->interrupt($message);
    }

    #[Test]
    public function canFinalize(): void
    {
        $message = 'message';
        $driver = $this->getDriverMock();
        $benchmark = $this->getBenchmarkMock();
        $benchmark
            ->expects(self::once())
            ->method('run')
            ->with(
                $this->getExpectedKey('finalize'),
                $driver->finalize(...),
                $message
            )
        ;

        $benchmarkingDriver = $this->getTesteeInstance(
            driver: $driver,
            benchmark: $benchmark,
        );


        $benchmarkingDriver->finalize($message);
    }

    #[Test]
    public function canUpdate(): void
    {
        $subject = $this->getSubjectMock();
        $driver = $this->getDriverMock();
        $observer = $this->getObserverMock();

        $benchmark = $this->getBenchmarkMock();
        $benchmark
            ->expects(self::exactly(2))
            ->method('run')
        ;

        $benchmarkingDriver = $this->getTesteeInstance(
            driver: $driver,
            benchmark: $benchmark,
            observer: $observer,
        );

        $benchmarkingDriver->update($subject);
    }

    private function getSubjectMock(): MockObject&ISubject
    {
        return $this->createMock(ISubject::class);
    }

    private function getObserverMock(): MockObject&IObserver
    {
        return $this->createMock(IObserver::class);
    }

    #[Test]
    public function canHas(): void
    {
        $has = true;
        $spinner = $this->getSpinnerMock();
        $driver = $this->getDriverMock();

        $benchmark = $this->getBenchmarkMock();
        $benchmark
            ->expects(self::once())
            ->method('run')
            ->with(
                $this->getExpectedKey('has'),
                $driver->has(...),
                $spinner
            )
            ->willReturn($has)
        ;

        $benchmarkingDriver = $this->getTesteeInstance(
            driver: $driver,
            benchmark: $benchmark,
        );


        self::assertSame($has, $benchmarkingDriver->has($spinner));
    }

    #[Test]
    public function canWrap(): void
    {
        $wrapper = fn() => null;
        $closure = fn() => null;
        $driver = $this->getDriverMock();


        $benchmark = $this->getBenchmarkMock();
        $benchmark
            ->expects(self::once())
            ->method('run')
            ->with(
                $this->getExpectedKey('wrap'),
                $driver->wrap(...),
                $closure
            )
            ->willReturn($wrapper)
        ;

        $benchmarkingDriver = $this->getTesteeInstance(
            driver: $driver,
            benchmark: $benchmark,
        );


        self::assertSame($wrapper, $benchmarkingDriver->wrap($closure));
    }

    #[Test]
    public function canGetInterval(): void
    {
        $interval = $this->getIntervalMock();
        $driver = $this->getDriverMock();
        $benchmark = $this->getBenchmarkMock();
        $benchmark
            ->expects(self::once())
            ->method('run')
            ->with(
                $this->getExpectedKey('getInterval'),
                $driver->getInterval(...),
            )
            ->willReturn($interval)
        ;

        $benchmarkingDriver = $this->getTesteeInstance(
            driver: $driver,
            benchmark: $benchmark,
        );


        self::assertSame($interval, $benchmarkingDriver->getInterval());
    }

    private function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    private function getStopwatchMock(): MockObject&IStopwatch
    {
        return $this->createMock(IStopwatch::class);
    }
}
