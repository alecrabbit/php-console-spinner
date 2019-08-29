<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Tools;

use AlecRabbit\Spinner\Core\Jugglers\FrameJuggler;
use AlecRabbit\Spinner\Core\Jugglers\MessageJuggler;
use AlecRabbit\Spinner\Core\Jugglers\ProgressJuggler;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use AlecRabbit\Tests\Spinner\ExtendedJugglingSpinner;
use AlecRabbit\Tests\Spinner\Helper;
use PHPUnit\Framework\TestCase;
use function AlecRabbit\Helpers\getValue;
use const AlecRabbit\NO_COLOR_TERMINAL;

class JugglingSpinnerTest extends TestCase
{
    protected const PROCESSING = 'Processing';

    /** @test */
    public function instance(): void
    {
        $s = new ExtendedJugglingSpinner(null, false, NO_COLOR_TERMINAL);
        $this->assertInstanceOf(Spinner::class, $s);
        $this->assertSame(0.2, $s->interval());
        $frameJuggler = getValue($s, 'frameJuggler');
        $messageJuggler = getValue($s, 'messageJuggler');
        $progressJuggler = getValue($s, 'progressJuggler');
        $this->assertInstanceOf(FrameJuggler::class, $frameJuggler);
        $this->assertNull($messageJuggler);
        $this->assertNull($progressJuggler);

        $begin = $s->begin(0.0);
        $this->assertIsString($begin);
        $this->assertEquals(
            '\033[?25l1 0% \033[5D',
            Helper::stripEscape($begin)
        );
        $this->assertEquals('2 0% \033[5D', Helper::stripEscape($s->spin()));
        $this->assertEquals('3 0% \033[5D', Helper::stripEscape($s->spin()));
        $this->assertEquals('4 0% \033[5D', Helper::stripEscape($s->spin()));
        $this->assertEquals('1 0% \033[5D', Helper::stripEscape($s->spin()));
        $this->assertEquals('2 0% \033[5D', Helper::stripEscape($s->spin()));
        $s->progress(0.022);
        $this->assertEquals('3 2% \033[5D', Helper::stripEscape($s->spin()));
        $this->assertEquals('4 2% \033[5D', Helper::stripEscape($s->spin()));
        $this->assertEquals('1 2% \033[5D', Helper::stripEscape($s->spin()));
        $this->assertEquals('2 2% \033[5D', Helper::stripEscape($s->spin()));
        $this->assertEquals('3 2% \033[5D', Helper::stripEscape($s->spin()));
        $s->progress(0.556);
        $this->assertEquals('4 55% \033[6D', Helper::stripEscape($s->spin()));
        $this->assertEquals('1 55% \033[6D', Helper::stripEscape($s->spin()));
        $this->assertEquals('2 55% \033[6D', Helper::stripEscape($s->spin()));
        $this->assertEquals('3 55% \033[6D', Helper::stripEscape($s->spin()));
        $this->assertEquals('4 55% \033[6D', Helper::stripEscape($s->spin()));
        $s->progress(1);
        $this->assertEquals('1 100% \033[7D', Helper::stripEscape($s->spin()));
        $this->assertEquals('2 100% \033[7D', Helper::stripEscape($s->spin()));
        $this->assertEquals('3 100% \033[7D', Helper::stripEscape($s->spin()));
        $this->assertEquals('4 100% \033[7D', Helper::stripEscape($s->spin()));
        $this->assertEquals('1 100% \033[7D', Helper::stripEscape($s->spin()));

        $this->assertEquals('       \033[7D', Helper::stripEscape($s->erase()));
        $this->assertEquals('       \033[7D\033[?25h\033[?0c', Helper::stripEscape($s->end()));
        $this->assertEquals('       \033[7D\033[?25h\033[?0c', Helper::stripEscape($s->end()));

        $this->assertEquals('\033[?25l2 0%   \033[7D', Helper::stripEscape($s->begin(0.0)));
        $this->assertEquals('3 0% \033[5D', Helper::stripEscape($s->spin()));
        $this->assertEquals('4 0% \033[5D', Helper::stripEscape($s->spin()));
        $this->assertEquals('1 0% \033[5D', Helper::stripEscape($s->spin()));
        $this->assertEquals('2 0% \033[5D', Helper::stripEscape($s->spin()));
        $s->progress(0.022);
        $this->assertEquals('3 2% \033[5D', Helper::stripEscape($s->spin()));
        $this->assertEquals('4 2% \033[5D', Helper::stripEscape($s->spin()));
        $this->assertEquals('1 2% \033[5D', Helper::stripEscape($s->spin()));
        $this->assertEquals('2 2% \033[5D', Helper::stripEscape($s->spin()));
        $this->assertEquals('3 2% \033[5D', Helper::stripEscape($s->spin()));
        $s->progress(0.556);
        $this->assertEquals('4 55% \033[6D', Helper::stripEscape($s->spin()));
        $this->assertEquals('1 55% \033[6D', Helper::stripEscape($s->spin()));
        $this->assertEquals('2 55% \033[6D', Helper::stripEscape($s->spin()));
        $this->assertEquals('3 55% \033[6D', Helper::stripEscape($s->spin()));
        $this->assertEquals('4 55% \033[6D', Helper::stripEscape($s->spin()));
        $s->progress(1);
        $this->assertEquals('1 100% \033[7D', Helper::stripEscape($s->spin()));
        $this->assertEquals('2 100% \033[7D', Helper::stripEscape($s->spin()));
        $this->assertEquals('3 100% \033[7D', Helper::stripEscape($s->spin()));
        $this->assertEquals('4 100% \033[7D', Helper::stripEscape($s->spin()));
        $this->assertEquals('1 100% \033[7D', Helper::stripEscape($s->spin()));

        $this->assertEquals('\033[?25l2      \033[7D', Helper::stripEscape($s->begin()));
        $this->assertEquals('3 \033[2D', Helper::stripEscape($s->spin()));
        $this->assertEquals('4 \033[2D', Helper::stripEscape($s->spin()));
        $this->assertEquals('1 \033[2D', Helper::stripEscape($s->spin()));
        $this->assertEquals('2 \033[2D', Helper::stripEscape($s->spin()));
        $s->progress(0.022);
        $this->assertEquals('3 2% \033[5D', Helper::stripEscape($s->spin()));
        $this->assertEquals('4 2% \033[5D', Helper::stripEscape($s->spin()));
        $this->assertEquals('1 2% \033[5D', Helper::stripEscape($s->spin()));
        $this->assertEquals('2 2% \033[5D', Helper::stripEscape($s->spin()));
        $this->assertEquals('3 2% \033[5D', Helper::stripEscape($s->spin()));
        $s->progress(0.556);
        $s->message(self::PROCESSING);
        $this->assertEquals(
            '4 ' . self::PROCESSING . Defaults::DEFAULT_SUFFIX . ' 55% \033[20D',
            Helper::stripEscape($s->spin())
        );
        $this->assertEquals(
            '1 ' . self::PROCESSING . Defaults::DEFAULT_SUFFIX . ' 55% \033[20D',
            Helper::stripEscape($s->spin())
        );
        $this->assertEquals(
            '2 ' . self::PROCESSING . Defaults::DEFAULT_SUFFIX . ' 55% \033[20D',
            Helper::stripEscape($s->spin())
        );
        $this->assertEquals(
            '3 ' . self::PROCESSING . Defaults::DEFAULT_SUFFIX . ' 55% \033[20D',
            Helper::stripEscape($s->spin())
        );
        $this->assertEquals(
            '4 ' . self::PROCESSING . Defaults::DEFAULT_SUFFIX . ' 55% \033[20D',
            Helper::stripEscape($s->spin())
        );
        $s->progress(1);
        $this->assertEquals(
            '1 ' . self::PROCESSING . Defaults::DEFAULT_SUFFIX . ' 100% \033[21D',
            Helper::stripEscape($s->spin())
        );
        $this->assertEquals(
            '2 ' . self::PROCESSING . Defaults::DEFAULT_SUFFIX . ' 100% \033[21D',
            Helper::stripEscape($s->spin())
        );
        $s->message(Defaults::EMPTY_STRING, 0);
        $this->assertEquals('3 100%               \033[21D', Helper::stripEscape($s->spin()));
    }

    /** @test */
    public function progressOutOfBounds(): void
    {
        $s = new ExtendedJugglingSpinner(null, false, NO_COLOR_TERMINAL);
        $s->inline(true);
        $begin = $s->begin((float) - 0.1); // inspection bug fix
        $this->assertIsString($begin);
        $this->assertEquals(
            '\033[?25l 1 0% \033[6D',
            Helper::stripEscape($begin)
        );
        $this->assertEquals(' 2 0% \033[6D', Helper::stripEscape($s->spin()));
        $this->assertEquals(' 3 0% \033[6D', Helper::stripEscape($s->spin()));
        $this->assertEquals(' 4 0% \033[6D', Helper::stripEscape($s->spin()));
        $this->assertEquals(' 1 0% \033[6D', Helper::stripEscape($s->spin()));
        $this->assertEquals(' 2 0% \033[6D', Helper::stripEscape($s->spin()));
        $s->progress(-2);
        $this->assertEquals(' 3 0% \033[6D', Helper::stripEscape($s->spin()));
        $this->assertEquals(' 4 0% \033[6D', Helper::stripEscape($s->spin()));
        $this->assertEquals(' 1 0% \033[6D', Helper::stripEscape($s->spin()));
        $this->assertEquals(' 2 0% \033[6D', Helper::stripEscape($s->spin()));
        $this->assertEquals(' 3 0% \033[6D', Helper::stripEscape($s->spin()));
        $s->progress(100);
        $this->assertEquals(' 4 100% \033[8D', Helper::stripEscape($s->spin()));
        $this->assertEquals(' 1 100% \033[8D', Helper::stripEscape($s->spin()));
        $this->assertEquals(' 2 100% \033[8D', Helper::stripEscape($s->spin()));
        $this->assertEquals(' 3 100% \033[8D', Helper::stripEscape($s->spin()));
        $this->assertEquals(' 4 100% \033[8D', Helper::stripEscape($s->spin()));
        $s->progress(2);
        $this->assertEquals(' 1 100% \033[8D', Helper::stripEscape($s->spin()));
        $this->assertEquals(' 2 100% \033[8D', Helper::stripEscape($s->spin()));
        $this->assertEquals(' 3 100% \033[8D', Helper::stripEscape($s->spin()));
        $this->assertEquals(' 4 100% \033[8D', Helper::stripEscape($s->spin()));
        $this->assertEquals(' 1 100% \033[8D', Helper::stripEscape($s->spin()));
        $s->progress(null);
        $this->assertEquals(' 2      \033[8D', Helper::stripEscape($s->spin()));
        $this->assertEquals(' 3 \033[3D', Helper::stripEscape($s->spin()));
        $this->assertEquals(' 4 \033[3D', Helper::stripEscape($s->spin()));
        $this->assertEquals(' 1 \033[3D', Helper::stripEscape($s->spin()));
        $this->assertEquals(' 2 \033[3D', Helper::stripEscape($s->spin()));
    }

    /** @test */
    public function withMessage(): void
    {
        $spinner = new ExtendedJugglingSpinner(self::PROCESSING, false, NO_COLOR_TERMINAL);

        $this->assertInstanceOf(Spinner::class, $spinner);
        $frameJuggler = getValue($spinner, 'frameJuggler');
        $messageJuggler = getValue($spinner, 'messageJuggler');
        $progressJuggler = getValue($spinner, 'progressJuggler');
        $this->assertInstanceOf(FrameJuggler::class, $frameJuggler);
        $this->assertInstanceOf(MessageJuggler::class, $messageJuggler);
        $this->assertNull($progressJuggler);
        $begin = $spinner->begin(0.0);
        $progressJuggler = getValue($spinner, 'progressJuggler');
        $this->assertInstanceOf(ProgressJuggler::class, $progressJuggler);
        $this->assertIsString($begin);
        $this->assertEquals(
            '\033[?25l1 Processing... 0% \033[19D',
            Helper::stripEscape($begin)
        );
        $spin = $spinner->spin();
        $this->assertEquals(
            '2 Processing... 0% \033[19D',
            Helper::stripEscape($spin)
        );
    }
}
