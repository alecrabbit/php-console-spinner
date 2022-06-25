<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Kernel\Wiggler;

use AlecRabbit\Spinner\Kernel\Rotor\WInterval;
use AlecRabbit\Spinner\Kernel\Wiggler\CycleCalculator;
use AlecRabbit\Tests\Spinner\TestCase;

class CycleCalculatorTest extends TestCase
{
    public function calculateDataProvider(): iterable
    {
        // [$expected, $arguments]
        yield from $this->convertDataSetForCalculate(self::dataSetForCalculate());
    }

    protected function convertDataSetForCalculate(iterable $dataSet): iterable
    {
        foreach ($dataSet as $item) {
            yield [
                [
                    self::RESULT => $item[0],
                ],
                [
                    self::PREFERRED_INTERVAL => $item[1],
                    self::INTERVAL => $item[2],
                ],
            ];
        }
    }

    protected static function dataSetForCalculate(): iterable
    {
        yield from [
            [0, null, null],
            [10, 100, null],
            [2, 100, 200],
            [0, 200, 100],
            [2, 200, 400],
            [5, 200, 1000],
            [0, 1000, 200],
            [0, 1000, 345],
            [0, 1000, 645],
            [1, 999, 1000],
            [1, 505, 1000],
            [2, 500, 1000],
            [3, 300, 1000],
            [3, 300, null],
            [0, 1000, 100],
            [0, null, 100],
            [10, 1000, 10000],
            [10, null, 10000],
            [0, 10000, 1000],
            [0, 10000, null],
            [0, 200000, 1000],
            [0, 200000, null],
            [200, null, 200000],
            [200, 1000, 200000],
        ];
    }

    /**
     * @test
     * @dataProvider calculateDataProvider
     */
    public function calculate(array $expected, array $arguments): void
    {
        $this->setExpectException($expected);

        $preferredInterval = $this->intervalOrNull($arguments[self::PREFERRED_INTERVAL]);

        $interval = $this->intervalOrNull($arguments[self::INTERVAL]);

        self::assertSame($expected[self::RESULT], CycleCalculator::calculate($preferredInterval, $interval));
    }

    private function intervalOrNull(null|int|float $milliseconds): ?WInterval
    {
        return
            null === $milliseconds
                ? null
                : new WInterval($milliseconds);
    }
}
