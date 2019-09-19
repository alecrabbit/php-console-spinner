<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Tools;

use AlecRabbit\Spinner\PercentSpinner;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use AlecRabbit\Spinner\Settings\Settings;
use AlecRabbit\Tests\Spinner\ExtendedSpinner;
use AlecRabbit\Tests\Spinner\Helper;
use AlecRabbit\Tests\Spinner\Unit\Contracts\TestMessages;
use PHPUnit\Framework\TestCase;
use function AlecRabbit\Helpers\getValue;
use const AlecRabbit\NO_COLOR_TERMINAL;

class PercentSpinnerTest extends TestCase implements TestMessages
{
    /** @test */
    public function instance(): void
    {
        $spinner = new PercentSpinner(self::PROCESSING, false);
        $this->assertInstanceOf(PercentSpinner::class, $spinner);
        $begin = $spinner->begin(0.0);
        $this->assertIsString($begin);
        $spin_10percent = $spinner->spin(0.1);
        $this->assertIsString($spin_10percent);
        $this->assertIsString($spinner->end());
        $this->assertStringContainsString(self::PROCESSING, $begin);
        $this->assertStringContainsString(Defaults::ONE_SPACE_SYMBOL, $begin);
        $this->assertStringContainsString(Defaults::DEFAULT_SUFFIX, $begin);
        $this->assertStringContainsString(self::PROCESSING, $spin_10percent);
        $this->assertStringContainsString(Defaults::ONE_SPACE_SYMBOL, $spin_10percent);
        $this->assertStringContainsString(Defaults::DEFAULT_SUFFIX, $spin_10percent);
        $this->assertStringNotContainsString(self::PROCESSING, $spinner->end());
    }

    /**
     * @test
     * @dataProvider processDataProvider
     * @param array $params
     * @param array $expected
     * @param string $end
     */
    public function withDataProvider(array $params, array $expected, string $end): void
    {
        $spinner = new PercentSpinner(...$params);
        $begin = array_shift($expected)[0];
        $this->assertSame($begin, Helper::replaceEscape($spinner->begin()));
        foreach ($expected as $data) {
            [$spin, $additional] = $data;
            if (!empty($additional)) {
                [$progress, $message] = $additional;
                if (false !== $progress) {
                    $spinner->spin($progress);
                }
                if (false !== $message) {
                    $spinner->message($message);
                }
            }
            $this->assertSame($spin, Helper::replaceEscape($spinner->last()));
        }
        $this->assertSame($end, Helper::replaceEscape($spinner->end()));
    }

    public function processDataProvider(): array
    {
        return [
            [
                [
                    null,
                    false,
                    NO_COLOR_TERMINAL,
                ],
                [
                    ['\033[?25l0% \033[3D', []],
                    ['0% \033[3D', []],
                    ['0% \033[3D', []],
                    ['0% \033[3D', []],
                    ['0% \033[3D', []],
                    ['0% \033[3D', []],
                    ['0% \033[3D', [0, false]],
                    ['2% \033[3D', [0.02, false]],
                    ['100% \033[5D', [1, false]],
                    [
                        '2%   \033[5D',
                        [0.02, self::COMPUTING],
                    ],
                    [
                        '2% \033[3D',
                        [0.02, self::COMPUTING],
                    ],
                    [
                        '2% \033[3D',
                        [null, self::COMPUTING],
                    ],
                    [
                        '3% \033[3D',
                        [0.03, self::COMPUTING],
                    ],
                    ['3% \033[3D', []],
                ],
                '   \033[3D\033[?25h\033[?0c',
            ],
        ];
    }
}
