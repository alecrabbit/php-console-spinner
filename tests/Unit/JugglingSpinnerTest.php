<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Tools;

use AlecRabbit\Spinner\Core\Jugglers\FrameJuggler;
use AlecRabbit\Spinner\Core\Jugglers\MessageJuggler;
use AlecRabbit\Spinner\Core\Jugglers\ProgressJuggler;
use AlecRabbit\Spinner\Core\Spinner;
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
    }

//    /** @test */
//    public function withMessage(): void
//    {
//        $spinner = new ExtendedJugglingSpinner(self::PROCESSING, false, NO_COLOR_TERMINAL);
//
//        $this->assertInstanceOf(Spinner::class, $spinner);
//        $frameJuggler = getValue($spinner, 'frameJuggler');
//        $messageJuggler = getValue($spinner, 'messageJuggler');
//        $progressJuggler = getValue($spinner, 'progressJuggler');
//        $this->assertInstanceOf(FrameJuggler::class, $frameJuggler);
//        $this->assertInstanceOf(MessageJuggler::class, $messageJuggler);
//        $this->assertNull($progressJuggler);
//        $begin = $spinner->begin(0.0);
//        $progressJuggler = getValue($spinner, 'progressJuggler');
//        $this->assertInstanceOf(ProgressJuggler::class, $progressJuggler);
//        $this->assertIsString($begin);
//        $this->assertEquals(
//            '\033[?25l1 Processing... 0% \033[18D',
//            Helper::stripEscape($begin)
//        );
//        $spin = $spinner->spin();
//        $this->assertEquals(
//            '\033[?25l2 Processing... 0%',
//            Helper::stripEscape($begin)
//        );
//
//    }
}
