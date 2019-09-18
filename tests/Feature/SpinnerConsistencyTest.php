<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner;

use AlecRabbit\Spinner\Core\Spinner;
use PHPUnit\Framework\TestCase;
use const AlecRabbit\NO_COLOR_TERMINAL;

class SpinnerConsistencyTest extends TestCase
{
    protected const PROCESSING = 'Processing';
    protected const COMPUTING = 'computing';

    /** @test */
    public function instance(): void
    {
        $spinner = new ExtendedSpinner(self::PROCESSING, false, NO_COLOR_TERMINAL);
        $this->assertInstanceOf(Spinner::class, $spinner);
        $this->assertSame(0.1, $spinner->interval());
        $this->assertNull($spinner->getOutput());
        $this->assertEquals('\033[?25l1 Processing... \033[16D', Helper::replaceEscape($spinner->begin()));
        $this->assertEquals('2 Processing... \033[16D', Helper::replaceEscape($spinner->spin()));
        $this->assertEquals('3 Processing... \033[16D', Helper::replaceEscape($spinner->spin()));
        $this->assertEquals('4 Processing... \033[16D', Helper::replaceEscape($spinner->spin()));
        $this->assertEquals('1 Processing... \033[16D', Helper::replaceEscape($spinner->spin()));
        $spinner->progress(0.1);
        $spinner->message('We have here a really long message');
        $this->assertEquals(
            '2 We have here a really long message... 10% \033[44D',
            Helper::replaceEscape($spinner->spin())
        );
        $this->assertEquals(
            '3 We have here a really long message... 10% \033[44D',
            Helper::replaceEscape($spinner->spin())
        );
        $this->assertEquals(
            '4 We have here a really long message... 10% \033[44D',
            Helper::replaceEscape($spinner->spin())
        );
        $this->assertEquals(
            '1 We have here a really long message... 10% \033[44D',
            Helper::replaceEscape($spinner->spin())
        );
        $spinner->message(null);
        $this->assertEquals(
            '2 10%                                       \033[44D',
            Helper::replaceEscape($spinner->spin())
        );
        $this->assertEquals('3 10% \033[6D', Helper::replaceEscape($spinner->spin()));
        $this->assertEquals('4 10% \033[6D', Helper::replaceEscape($spinner->spin()));
        $spinner->progress(null);
        $this->assertEquals('1     \033[6D', Helper::replaceEscape($spinner->spin()));
        $this->assertEquals('2 \033[2D', Helper::replaceEscape($spinner->spin()));
        $spinner->message(self::PROCESSING);
        $this->assertEquals('3 Processing... \033[16D', Helper::replaceEscape($spinner->spin()));
        $this->assertEquals(
            '                \033[16D\033[?25h\033[?0c',
            Helper::replaceEscape($spinner->end())
        );
    }
}
