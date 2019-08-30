<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Tools;

use AlecRabbit\Spinner\Core\Coloring\Scott;
use AlecRabbit\Spinner\Core\Contracts\Styles;
use AlecRabbit\Spinner\Core\Jugglers\FrameJuggler;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use PHPUnit\Framework\TestCase;
use const AlecRabbit\NO_COLOR_TERMINAL;

class FrameJugglerTest extends TestCase
{
    /**
     * @test
     * @dataProvider valuesDataProvider
     * @param string $exceptionClass
     * @param string $exceptionMessage
     * @param array $frames
     */
    public function instanceWithException(string $exceptionClass, string $exceptionMessage, array $frames): void
    {
        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);
        $fg = new FrameJuggler($frames, new Scott(Styles::DEFAULT_STYLES_ELEMENT, NO_COLOR_TERMINAL));
    }

    public function valuesDataProvider(): array
    {
        return [
            [
                \InvalidArgumentException::class,
                sprintf(
                    'Frames count limit [%s] exceeded: [%s].',
                    Defaults::MAX_FRAMES_COUNT,
                    Defaults::MAX_FRAMES_COUNT + 6
                ),
                array_fill(0, Defaults::MAX_FRAMES_COUNT + 6, ' '),
            ],
            [\InvalidArgumentException::class, 'All frames should be of string type.', ['1', 1]],
            [\InvalidArgumentException::class, 'All frames should be of string type.', ['1', null]],
            [\InvalidArgumentException::class, 'All frames should be of string type.', ['1', new \stdClass()]],
            [
                \InvalidArgumentException::class,
                sprintf(
                    'Single frame max length [%s] exceeded [%s]',
                    Defaults::MAX_FRAME_LENGTH,
                    Defaults::MAX_FRAME_LENGTH + 2
                ),
                ['1', str_repeat(' ', Defaults::MAX_FRAME_LENGTH + 2)],
            ],
        ];
    }
}
