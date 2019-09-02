<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Tools;

use AlecRabbit\Spinner\Core\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    /**
     * @test
     * @dataProvider valuesDataProvider
     * @param int $expected
     * @param array $given
     */
    public function values(int $expected, array $given): void
    {
        $this->assertEquals($expected, Calculator::computeErasingLengths($given));
    }

    /** @test */
    public function withException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Strings have different erasing lengths');
        $this->assertEquals(0, Calculator::computeErasingLengths(['1', '22']));
    }

    public function valuesDataProvider(): array
    {
        return [
            [0, []],
            [1, ['1', '1']],
            [0, ['', '']],
            [0, [null, null]],
        ];
    }
}
