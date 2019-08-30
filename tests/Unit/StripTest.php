<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Tools;

use AlecRabbit\Spinner\Core\Calculator;
use AlecRabbit\Spinner\Core\Strip;
use PHPUnit\Framework\TestCase;

class StripTest extends TestCase
{
    /**
     * @test
     * @dataProvider valuesDataProvider
     * @param string $expected
     * @param string $given
     */
    public function values(string $expected, string $given): void
    {
        $this->assertEquals($expected, Strip::escCodes($given));
    }

    public function valuesDataProvider(): array
    {
        return [
            [
                'Override message coloring by own styles',
                "\e[0mOverride message \e[93mcoloring\e[0m by \e[1mown styles",
            ],
            [
                'Override message coloring by own styles',
                "\e[0mOverride message \e[38;241;48;240mcoloring\e[0m by \e[1mown styles",
            ],
            [
                'Override message coloring by own styles',
                "\e[0mOverride message \e[38;5;211;48;5;237mcoloring\e[0m by \e[1mown styles",
            ],
            [
                'Still processing',
                "\e[0m\e[91mStill processing",
            ],
            [
                'Be patient',
                "\e[0m\e[93mBe patient",
            ],
            [
                'Almost there',
                "\e[0m\e[33mAlmost there",
            ],
            [
                'Done',
                "\e[0m\e[92mDone",
            ],
        ];
    }
}
