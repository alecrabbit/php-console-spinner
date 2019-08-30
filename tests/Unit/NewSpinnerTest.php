<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner;

use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use AlecRabbit\Spinner\Settings\Settings;
use AlecRabbit\Tests\Spinner\Unit\Contracts\TestMessages;
use PHPUnit\Framework\TestCase;
use const AlecRabbit\NO_COLOR_TERMINAL;

class NewSpinnerTest extends TestCase implements TestMessages
{
    /** @var ExtendedSpinner */
    private $spinner;

    /**
     * @test
     * @dataProvider processDataProvider
     * @param array $params
     * @param array $expected
     * @param string $end
     */
    public function withDataProvider(array $params, array $expected, string $end): void
    {
        $spinner = new ExtendedSpinner(...$params);
        $begin = array_shift($expected)[0];
        $this->assertSame($begin, Helper::replaceEscape($spinner->begin()));
        foreach ($expected as $data) {
            [$spin, $additional] = $data;
            if (!empty($additional)) {
                [$progress, $message] = $additional;
                if (false !== $progress) {
                    $spinner->progress($progress);
                }
                if (false !== $message) {
                    $spinner->message($message);
                }
            }
            $this->assertSame($spin, Helper::replaceEscape($spinner->spin()));
        }
        $this->assertSame($end, Helper::replaceEscape($spinner->end()));
    }

    public function processDataProvider(): array
    {
        return [
            [
                [
                    self::PROCESSING,
                    false,
                    NO_COLOR_TERMINAL,
                ],
                [
                    ['\033[?25l1 ' . self::PROCESSING . Defaults::DOTS_SUFFIX . ' \033[16D', []],
                    ['2 ' . self::PROCESSING . Defaults::DOTS_SUFFIX . ' \033[16D', []],
                    ['3 ' . self::PROCESSING . Defaults::DOTS_SUFFIX . ' \033[16D', []],
                    ['4 ' . self::PROCESSING . Defaults::DOTS_SUFFIX . ' \033[16D', []],
                    ['1 ' . self::PROCESSING . Defaults::DOTS_SUFFIX . ' \033[16D', []],
                    ['2 ' . self::PROCESSING . Defaults::DOTS_SUFFIX . ' \033[16D', []],
                    ['3 ' . self::PROCESSING . Defaults::DOTS_SUFFIX . ' 0% \033[19D', [0, false]],
                    ['4 ' . self::PROCESSING . Defaults::DOTS_SUFFIX . ' 2% \033[19D', [0.02, false]],
                    [
                        '1 ' . ucfirst(self::COMPUTING) . Defaults::DOTS_SUFFIX . ' 2%  \033[19D',
                        [0.02, self::COMPUTING],
                    ],
                    [
                        '2 ' . ucfirst(self::COMPUTING) . Defaults::DOTS_SUFFIX . ' 3% \033[18D',
                        [0.03, self::COMPUTING],
                    ],
                    ['3 ' . ucfirst(self::COMPUTING) . Defaults::DOTS_SUFFIX . ' 3% \033[18D', []],
                ],
                '                  \033[18D\033[?25h\033[?0c',
            ],
            [
                [
                    (new Settings())->setMessage(self::MB_MESSAGE, 8),
                    false,
                    NO_COLOR_TERMINAL,
                ],
                [
                    ['\033[?25l1 ' . ucfirst(self::MB_MESSAGE) . Defaults::DOTS_SUFFIX . ' \033[14D', []],
                    ['2 ' . ucfirst(self::MB_MESSAGE) . Defaults::DOTS_SUFFIX . ' \033[14D', []],
                    ['3 ' . ucfirst(self::MB_MESSAGE) . Defaults::DOTS_SUFFIX . ' \033[14D', []],
                    ['4 ' . ucfirst(self::MB_MESSAGE) . Defaults::DOTS_SUFFIX . ' \033[14D', []],
                    ['1 ' . ucfirst(self::MB_MESSAGE) . Defaults::DOTS_SUFFIX . ' \033[14D', []],
                    ['2 ' . ucfirst(self::MB_MESSAGE) . Defaults::DOTS_SUFFIX . ' \033[14D', []],
                    ['3 ' . ucfirst(self::MB_MESSAGE) . Defaults::DOTS_SUFFIX . ' 0% \033[17D', [0, false]],
                    ['4 ' . ucfirst(self::MB_MESSAGE) . Defaults::DOTS_SUFFIX . ' 2% \033[17D', [0.02, false]],
                    [
                        '1 ' . ucfirst(self::COMPUTING) . Defaults::DOTS_SUFFIX . ' 2% \033[18D',
                        [0.02, self::COMPUTING],
                    ],
                    [
                        '2 ' . ucfirst(self::COMPUTING) . Defaults::DOTS_SUFFIX . ' 3% \033[18D',
                        [0.03, self::COMPUTING],
                    ],
                    ['3 ' . ucfirst(self::COMPUTING) . Defaults::DOTS_SUFFIX . ' 3% \033[18D', []],
                    ['4 10%             \033[18D', [0.1, null]],
                    ['1 10% \033[6D', [0.1, null]],
                ],
                '      \033[6D\033[?25h\033[?0c',
            ],
        ];
    }
}
