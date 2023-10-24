<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Benchmark\Factory;


use AlecRabbit\Benchmark\BenchmarkResults;
use AlecRabbit\Benchmark\Contract\Factory\IBenchmarkResultsFactory;
use AlecRabbit\Benchmark\Contract\Factory\IResultMaker;
use AlecRabbit\Benchmark\Contract\IMeasurement;
use AlecRabbit\Benchmark\Contract\IResult;
use AlecRabbit\Benchmark\Exception\MeasurementException;
use AlecRabbit\Benchmark\Factory\BenchmarkResultsFactory;
use AlecRabbit\Benchmark\Factory\ResultMaker;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class BenchmarkResultsFactoryTest extends TestCase
{
    private const A_1 = 'a1';
    private const A_2 = 'a2';
    private const A_3 = 'a3';
    private const A_4 = 'a4';
    private const A_5 = 'a5';

    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(BenchmarkResultsFactory::class, $factory);
    }

    private function getTesteeInstance(
        ?IResultMaker $resultMaker = null,
    ): IBenchmarkResultsFactory {
        return
            new BenchmarkResultsFactory(
                resultMaker: $resultMaker ?? $this->getResultMaker(),
            );
    }

    private function getResultMaker(): IResultMaker
    {
        return new ResultMaker();
    }

    #[Test]
    public function canCreate(): void
    {
        $measurements = $this->getMeasurements();
        $factory = $this->getTesteeInstance();

        $benchmarkResults = $factory->create($measurements);

        self::assertInstanceOf(BenchmarkResultsFactory::class, $factory);
        self::assertInstanceOf(BenchmarkResults::class, $benchmarkResults);

        // unwrap generator
        $arr = iterator_to_array($benchmarkResults->getResults());

        self::assertArrayHasKey(self::A_1, $arr);
        self::assertArrayHasKey(self::A_2, $arr);
        self::assertArrayHasKey(self::A_3, $arr);

        self::assertInstanceOf(IResult::class, $arr[self::A_1]);
        self::assertInstanceOf(IResult::class, $arr[self::A_2]);
        self::assertInstanceOf(IResult::class, $arr[self::A_3]);
    }

    private function getMeasurements(): \Traversable
    {
        yield from [
            self::A_1 => $this->getMeasurementMock(),
            self::A_2 => $this->getMeasurementMock(),
            self::A_3 => $this->getMeasurementMock(),
        ];
    }

    private function getMeasurementMock(): MockObject&IMeasurement
    {
        return $this->createMock(IMeasurement::class);
    }

    #[Test]
    public function canCreateWithExceptions(): void
    {
        $measurements = $this->getMeasurementsWithExceptions();
        $factory = $this->getTesteeInstance();

        $benchmarkResults = $factory->create($measurements);

        self::assertInstanceOf(BenchmarkResultsFactory::class, $factory);
        self::assertInstanceOf(BenchmarkResults::class, $benchmarkResults);

        // unwrap generator
        $arr = iterator_to_array($benchmarkResults->getResults());

        self::assertArrayHasKey(self::A_1, $arr);
        self::assertArrayHasKey(self::A_3, $arr);
        self::assertArrayHasKey(self::A_5, $arr);

        self::assertInstanceOf(IResult::class, $arr[self::A_1]);
        self::assertInstanceOf(IResult::class, $arr[self::A_3]);
        self::assertInstanceOf(IResult::class, $arr[self::A_5]);
    }

    private function getMeasurementsWithExceptions(): \Traversable
    {
        $measurementA2 = $this->getMeasurementMock();
        $measurementA2
            ->expects(self::once())
            ->method('getAverage')
            ->willThrowException(new MeasurementException())
        ;

        $measurementA4 = $this->getMeasurementMock();
        $measurementA4
            ->expects(self::once())
            ->method('getAverage')
            ->willThrowException(new MeasurementException())
        ;

        yield from [
            self::A_1 => $this->getMeasurementMock(),
            self::A_2 => $measurementA2,
            self::A_3 => $this->getMeasurementMock(),
            self::A_4 => $measurementA4,
            self::A_5 => $this->getMeasurementMock(),
        ];
    }
}
