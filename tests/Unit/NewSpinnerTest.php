<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner;

use PHPUnit\Framework\TestCase;
use const AlecRabbit\NO_COLOR_TERMINAL;

class NewSpinnerTest extends TestCase
{
    protected const PROCESSING = 'Processing';
    protected const COMPUTING = 'computing';

    /** @var ExtendedSpinner */
    private $spinner;

    /**
     * @test
     * @dataProvider processDataProvider
     * @param array $params
     * @param array $expected
     * @param string $end
     */
    public function process(array $params, array $expected, string $end): void
    {
        $spinner = new ExtendedSpinner(...$params);
        $begin = array_shift($expected)[0];
        $this->assertSame($begin, Helper::stripEscape($spinner->begin()));
        foreach ($expected as $data) {
            [$spin, $additional] = $data;
            if (!empty($additional)) {
                [$progress, $message] = $additional;
                if (null !== $progress) {
                    $spinner->progress($progress);
                }
                if (null !== $message) {
                    $spinner->message($message);
                }
            }
            $this->assertSame($spin, Helper::stripEscape($spinner->spin()));
        }
        $this->assertSame($end, Helper::stripEscape($spinner->end()));

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
                    ['\033[?25l1 Processing... \033[16D', []],
                    ['2 Processing... \033[16D', []],
                    ['3 Processing... \033[16D', []],
                    ['4 Processing... \033[16D', []],
                    ['1 Processing... \033[16D', []],
                    ['2 Processing... \033[16D', []],
                    ['3 Processing... 0% \033[19D', [0, null]],
                    ['4 Processing... 2% \033[19D', [0.02, null]],
                    ['1 Computing... 2%     \033[22D', [0.02, self::COMPUTING]],
                    ['2 Computing... 3%    \033[21D', [0.03, self::COMPUTING]],
                    ['3 Computing... 3%    \033[21D', []],
                ],
                '                     \033[21D\033[?25h\033[?0c',
            ],
        ];
    }
}
