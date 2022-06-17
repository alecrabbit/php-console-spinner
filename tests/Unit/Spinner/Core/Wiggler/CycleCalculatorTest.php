<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Wiggler;

use AlecRabbit\Spinner\Core\Rotor\Interval;
use AlecRabbit\Spinner\Core\Wiggler\CycleCalculator;
use AlecRabbit\Tests\Spinner\TestCase;

class CycleCalculatorTest extends TestCase
{
    protected const PREFERRED_INTERVAL = 'preferredInterval';
    protected const INTERVAL = 'interval';

    public function calculateDataProvider(): iterable
    {
        // [$expected, $arguments]
        yield from $this->convertDataSetForCalculate(self::dataSetForCalculate());

    }

    /**
     * @test
     * @dataProvider calculateDataProvider
     */
    public function calculate(array $expected, array $arguments): void
    {
        $this->checkForExceptionExpectance($expected);

        $preferredInterval =
            null === $arguments[self::PREFERRED_INTERVAL] ? null : new Interval($arguments[self::PREFERRED_INTERVAL]);
        $interval =
            null === $arguments[self::INTERVAL] ? null : new Interval($arguments[self::INTERVAL]);

        self::assertSame($expected[self::RESULT], CycleCalculator::calculate($preferredInterval, $interval));
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
            [9, 100, null],
            [1, 100, 200],
            [0, 200, 100],
            [1, 200, 400],
            [4, 200, 1000],
            [0, 1000, 200],
            [0, 1000, 345],
            [0, 1000, 645],
            [0, 999, 1000],
            [0, 505, 1000],
            [1, 500, 1000],
            [2, 300, 1000],
        ];
    }
}
