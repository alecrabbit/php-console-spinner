<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Benchmark\Spinner;

use AlecRabbit\Benchmark\Contract\IBenchmark;
use AlecRabbit\Benchmark\Contract\IStopwatch;
use AlecRabbit\Benchmark\Spinner\BenchmarkingDriver;
use AlecRabbit\Benchmark\Spinner\Contract\IBenchmarkingDriver;
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
        ?IStopwatch $stopwatch = null,
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
    public function prefixForBenchmarkIsSet(): void
    {
        $benchmark = $this->getBenchmarkMock();
        $benchmark
            ->expects(self::once())
            ->method('setPrefix')
            ->with(self::identicalTo(BenchmarkingDriver::class))
        ;

        $driver = $this->getTesteeInstance(
            benchmark: $benchmark
        );
        
        self::assertInstanceOf(BenchmarkingDriver::class, $driver);
    }

    #[Test]
    public function canGetStopwatch(): void
    {
        $stopwatch = $this->getStopwatchMock();

        $benchmark = $this->getBenchmarkMock();
        $benchmark
            ->expects(self::once())
            ->method('getStopwatch')
            ->willReturn($stopwatch)
        ;

        $driver =
            $this->getTesteeInstance(
                benchmark: $benchmark
            );

        self::assertSame($stopwatch, $driver->getStopwatch(),);
    }

    private function getStopwatchMock(): MockObject&IStopwatch
    {
        return $this->createMock(IStopwatch::class);
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
                'render',
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
                'add',
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
        $driver
            ->expects(self::once())
            ->method('remove')
            ->with(self::identicalTo($spinner))
        ;

        $stopwatch = $this->getStopwatchMock();
        $stopwatch
            ->expects(self::once())
            ->method('start')
        ;
        $stopwatch
            ->expects(self::once())
            ->method('stop')
        ;

        $benchmarkingDriver = $this->getTesteeInstance(
            driver: $driver,
            stopwatch: $stopwatch,
        );

        $benchmarkingDriver->remove($spinner);
    }

    #[Test]
    public function canInitialize(): void
    {
        $driver = $this->getDriverMock();
        $driver
            ->expects(self::once())
            ->method('initialize')
        ;

        $stopwatch = $this->getStopwatchMock();
        $stopwatch
            ->expects(self::once())
            ->method('start')
        ;
        $stopwatch
            ->expects(self::once())
            ->method('stop')
        ;

        $benchmarkingDriver = $this->getTesteeInstance(
            driver: $driver,
            stopwatch: $stopwatch,
        );

        $benchmarkingDriver->initialize();
    }

    #[Test]
    public function canInterrupt(): void
    {
        $message = 'message';
        $driver = $this->getDriverMock();
        $driver
            ->expects(self::once())
            ->method('interrupt')
            ->with(self::identicalTo($message))
        ;

        $stopwatch = $this->getStopwatchMock();
        $stopwatch
            ->expects(self::once())
            ->method('start')
        ;
        $stopwatch
            ->expects(self::once())
            ->method('stop')
        ;

        $benchmarkingDriver = $this->getTesteeInstance(
            driver: $driver,
            stopwatch: $stopwatch,
        );

        $benchmarkingDriver->interrupt($message);
    }

    #[Test]
    public function canFinalize(): void
    {
        $message = 'message';
        $driver = $this->getDriverMock();
        $driver
            ->expects(self::once())
            ->method('finalize')
            ->with(self::identicalTo($message))
        ;

        $stopwatch = $this->getStopwatchMock();
        $stopwatch
            ->expects(self::once())
            ->method('start')
        ;
        $stopwatch
            ->expects(self::once())
            ->method('stop')
        ;

        $benchmarkingDriver = $this->getTesteeInstance(
            driver: $driver,
            stopwatch: $stopwatch,
        );

        $benchmarkingDriver->finalize($message);
    }

    #[Test]
    public function canUpdate(): void
    {
        $subject = $this->getSubjectMock();
        $driver = $this->getDriverMock();
        $driver
            ->expects(self::once())
            ->method('update')
            ->with(self::identicalTo($subject))
        ;

        $stopwatch = $this->getStopwatchMock();
        $stopwatch
            ->expects(self::exactly(2))
            ->method('start')
        ;
        $stopwatch
            ->expects(self::exactly(2))
            ->method('stop')
        ;

        $observer = $this->getObserverMock();

        $benchmarkingDriver = $this->getTesteeInstance(
            driver: $driver,
            stopwatch: $stopwatch,
            observer: $observer,
        );

        $observer
            ->expects(self::once())
            ->method('update')
            ->with(self::identicalTo($benchmarkingDriver))
        ;

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
        $driver
            ->expects(self::once())
            ->method('has')
            ->with(self::identicalTo($spinner))
            ->willReturn($has)
        ;

        $stopwatch = $this->getStopwatchMock();
        $stopwatch
            ->expects(self::once())
            ->method('start')
        ;
        $stopwatch
            ->expects(self::once())
            ->method('stop')
        ;

        $benchmarkingDriver = $this->getTesteeInstance(
            driver: $driver,
            stopwatch: $stopwatch,
        );

        self::assertSame($has, $benchmarkingDriver->has($spinner));
    }

    #[Test]
    public function canWrap(): void
    {
        $wrapper = fn() => null;
        $closure = fn() => null;
        $driver = $this->getDriverMock();
        $driver
            ->expects(self::once())
            ->method('wrap')
            ->with(self::identicalTo($closure))
            ->willReturn($wrapper)
        ;

        $stopwatch = $this->getStopwatchMock();
        $stopwatch
            ->expects(self::once())
            ->method('start')
        ;
        $stopwatch
            ->expects(self::once())
            ->method('stop')
        ;

        $benchmarkingDriver = $this->getTesteeInstance(
            driver: $driver,
            stopwatch: $stopwatch,
        );

        self::assertSame($wrapper, $benchmarkingDriver->wrap($closure));
    }

    #[Test]
    public function canGetInterval(): void
    {
        $interval = $this->getIntervalMock();
        $driver = $this->getDriverMock();
        $driver
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;

        $stopwatch = $this->getStopwatchMock();
        $stopwatch
            ->expects(self::once())
            ->method('start')
        ;
        $stopwatch
            ->expects(self::once())
            ->method('stop')
        ;

        $benchmarkingDriver = $this->getTesteeInstance(
            driver: $driver,
            stopwatch: $stopwatch,
        );

        self::assertSame($interval, $benchmarkingDriver->getInterval());
    }

    private function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }
}
