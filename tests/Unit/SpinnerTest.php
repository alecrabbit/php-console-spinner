<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner;

use AlecRabbit\Cli\Tools\Core\TerminalStatic;
use AlecRabbit\Spinner\Core\Contracts\Juggler;
use AlecRabbit\Spinner\Core\Contracts\SpinnerOutputInterface;
use AlecRabbit\Spinner\Core\Contracts\StylesInterface;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use AlecRabbit\Spinner\Settings\Settings;
use PHPUnit\Framework\TestCase;
use const AlecRabbit\COLOR256_TERMINAL;
use const AlecRabbit\NO_COLOR_TERMINAL;

class SpinnerTest extends TestCase
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
        $this->assertIsString($spinner->begin());
        $this->assertIsString($spinner->spin());
        $this->assertIsString($spinner->end());
        $this->assertStringContainsString(self::PROCESSING, $spinner->begin());
        $this->assertStringContainsString(Defaults::ONE_SPACE_SYMBOL, $spinner->begin());
        $this->assertStringContainsString(Defaults::DEFAULT_SUFFIX, $spinner->begin());
        $this->assertStringContainsString(self::PROCESSING, $spinner->spin());
        $this->assertStringContainsString(Defaults::ONE_SPACE_SYMBOL, $spinner->spin());
        $this->assertStringContainsString(Defaults::DEFAULT_SUFFIX, $spinner->spin());
        $this->assertStringNotContainsString(self::PROCESSING, $spinner->end());
    }

    /** @test */
    public function instanceWithUpdatingMessage(): void
    {
        $messageComputing = ucfirst(self::COMPUTING);

        $spinner = new ExtendedSpinner(self::PROCESSING, false, NO_COLOR_TERMINAL);
        $this->assertInstanceOf(Spinner::class, $spinner);
        $this->assertSame(0.1, $spinner->interval());
        $this->assertNull($spinner->getOutput());
        $this->assertIsString($spinner->begin());
        $this->assertIsString($spinner->spin());
        $this->assertIsString($spinner->end());
        $this->assertStringContainsString(self::PROCESSING, $spinner->begin());
        $this->assertStringContainsString(Defaults::ONE_SPACE_SYMBOL, $spinner->begin());
        $this->assertStringContainsString(Defaults::DEFAULT_SUFFIX, $spinner->begin());
        $this->assertStringContainsString(self::PROCESSING, $spinner->spin());
        $this->assertStringContainsString(Defaults::ONE_SPACE_SYMBOL, $spinner->spin());
        $this->assertStringContainsString(Defaults::DEFAULT_SUFFIX, $spinner->spin());
        $spinner->message($messageComputing);
        $this->assertStringContainsString($messageComputing, $spinner->spin());
        $this->assertStringContainsString(Defaults::ONE_SPACE_SYMBOL, $spinner->spin());
        $this->assertStringContainsString(Defaults::DEFAULT_SUFFIX, $spinner->spin());
        $this->assertStringNotContainsString($messageComputing, $spinner->end());
    }

    /** @test */
    public function wrongFirstArgument(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Instance of [' . Settings::class . '] or string expected integer given.');
        new ExtendedSpinner(1);
    }

    /** @test */
    public function wrongSecondArgumentInteger(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Incorrect parameter: [null|false|' . SpinnerOutputInterface::class . '] expected "integer" given.'
        );
        new ExtendedSpinner(null, 1);
    }

    /** @test */
    public function wrongSecondArgumentTrue(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Incorrect parameter: [null|false|' . SpinnerOutputInterface::class . '] expected "true" given.'
        );
        new ExtendedSpinner(null, true);
    }

    /** @test */
    public function wrongArgumentSettings(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $settings = new Settings();
        $settings->setStyles(
            [
                Juggler::FRAMES_STYLES =>
                    [
                        Juggler::COLOR256 => 1,
                        Juggler::COLOR => 1,
                    ],
            ]
        );
        $spinner = new ExtendedSpinner($settings, null, COLOR256_TERMINAL);
//        dump($spinner);
    }

    /** @test */
    public function addingTooMuchSymbols(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $count = 56;
        $this->expectExceptionMessage(
            'MAX_SYMBOLS_COUNT limit [' . Defaults::MAX_FRAMES_COUNT . '] exceeded: [' . $count . '].'
        );
        (new Settings())->setFrames(array_fill(0, $count, '-'));
    }

    /** @test */
    public function nullSpinner(): void
    {
        $styles = [
            Juggler::FRAMES_STYLES =>
                [
                    Juggler::COLOR256 => StylesInterface::DISABLED,
                    Juggler::COLOR => StylesInterface::DISABLED,
                ],
            Juggler::MESSAGE_STYLES =>
                [
                    Juggler::COLOR256 => StylesInterface::DISABLED,
                    Juggler::COLOR => StylesInterface::DISABLED,
                ],
            Juggler::PROGRESS_STYLES =>
                [
                    Juggler::COLOR256 => StylesInterface::DISABLED,
                    Juggler::COLOR => StylesInterface::DISABLED,
                ],
        ];
        $settings = new Settings();
        $settings->setInlinePaddingStr('');
        $settings->setMessage(self::PROCESSING);
        $settings->setStyles($styles);
        $spinner = new NullSpinner($settings, false, COLOR256_TERMINAL);
        $begin = $spinner->begin();

        // DO NOT CHANGE ORDER!!!
        $this->assertEquals(
            Helper::stripEscape("\033[?25lProcessing... \033[14D"),
            Helper::stripEscape($begin)
        );
        $this->assertEquals(
            "\033[?25lProcessing... \033[14D",
            $begin
        );
        $this->assertEquals(
            Helper::stripEscape("Processing... \033[14D"),
            Helper::stripEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::stripEscape("              \033[14D\033[?25h\033[?0c"),
            Helper::stripEscape($spinner->end())
        );
    }

    /** @test */
    public function wrongStylesSettings(): void
    {
        $styles = [
        ];
        $settings = new Settings();
        $settings->setStyles($styles);
        $spinner = new NullSpinner($settings, false, NO_COLOR_TERMINAL);
        $begin = $spinner->begin();

        // DO NOT CHANGE ORDER!!!
        $this->assertEquals(
            Helper::stripEscape("\033[?25l\033[0D"),
            Helper::stripEscape($begin)
        );
        $this->assertEquals(
            "\033[?25l\033[0D",
            $begin
        );
        $this->assertEquals(
            Helper::stripEscape("\033[0D"),
            Helper::stripEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::stripEscape("\033[0D\033[?25h\033[?0c"),
            Helper::stripEscape($spinner->end())
        );
    }

    /** @test */
    public function interface(): void
    {
        $spinner = new ExtendedSpinner(self::PROCESSING, false, COLOR256_TERMINAL);
        $this->assertInstanceOf(Spinner::class, $spinner->inline(true));
        $this->assertInstanceOf(Spinner::class, $spinner->inline(false));

        $begin = $spinner->begin();

        // DO NOT CHANGE ORDER!!!
        $this->assertEquals(
            Helper::stripEscape("\033[?25l\033[1m1 \033[0m\033[2mProcessing... \033[0m\033[16D"),
            Helper::stripEscape($begin)
        );
        $this->assertEquals(
            "\033[?25l\033[1m1 \033[0m\033[2mProcessing... \033[0m\033[16D",
            $begin
        );

        $this->assertEquals(
            Helper::stripEscape("\033[2m2 \033[0m\033[2mProcessing... \033[0m\033[16D"),
            Helper::stripEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::stripEscape("\033[3m3 \033[0m\033[2mProcessing... \033[0m\033[16D"),
            Helper::stripEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::stripEscape("\033[4m4 \033[0m\033[2mProcessing... \033[0m\033[16D"),
            Helper::stripEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::stripEscape("\033[1m1 \033[0m\033[2mProcessing... \033[0m\033[16D"),
            Helper::stripEscape($spinner->spin())
        );

        $this->assertEquals(
            "\033[2m2 \033[0m\033[2mProcessing... \033[0m\033[16D",
            $spinner->spin()
        );
        $this->assertEquals(
            "\033[3m3 \033[0m\033[2mProcessing... \033[0m\033[16D",
            $spinner->spin()
        );
        $this->assertEquals(
            "\033[4m4 \033[0m\033[2mProcessing... \033[0m\033[16D",
            $spinner->spin()
        );
        $this->assertEquals(
            "\033[1m1 \033[0m\033[2mProcessing... \033[0m\033[16D",
            $spinner->spin()
        );
        $spinner->progress(0);
        $this->assertEquals(
            Helper::stripEscape("\033[2m2 \033[0m\033[2mProcessing... \033[0m\033[2m0% \033[0m\033[19D"),
            Helper::stripEscape($spinner->spin())
        );
        $spinner->progress(0.5);

        $this->assertEquals(
            Helper::stripEscape("\033[3m3 \033[0m\033[2mProcessing... \033[0m\033[2m50% \033[0m\033[20D"),
            Helper::stripEscape($spinner->spin())
        );
        $spinner->progress(1);
        $this->assertEquals(
            Helper::stripEscape("\033[4m4 \033[0m\033[2mProcessing... \033[0m\033[2m100% \033[0m\033[21D"),
            Helper::stripEscape($spinner->spin())
        );

        $this->assertEquals(
            Helper::stripEscape("                     \033[21D"),
            Helper::stripEscape($spinner->erase())
        );
        $this->assertEquals(
            Helper::stripEscape("                     \033[21D\033[?25h\033[?0c"),
            Helper::stripEscape($spinner->end())
        );
        $this->assertEquals("                     \033[21D", $spinner->erase());
        $this->assertEquals("                     \033[21D\033[?25h\033[?0c", $spinner->end());
    }

    /** @test */
    public function interfaceWithBg(): void
    {
        $spinner = new ExtendedBgSpinner(self::PROCESSING, false, COLOR256_TERMINAL);
        $this->assertInstanceOf(Spinner::class, $spinner->inline(true));
        $this->assertInstanceOf(Spinner::class, $spinner->inline(false));

        $begin = $spinner->begin();

        // DO NOT CHANGE ORDER!!!
        $this->assertEquals(
            Helper::stripEscape("\033[?25l\033[1;1m1 \033[0m\033[2mProcessing... \033[0m\033[16D"),
            Helper::stripEscape($begin)
        );
        $this->assertEquals(
            "\033[?25l\033[1;1m1 \033[0m\033[2mProcessing... \033[0m\033[16D",
            $begin
        );

        $this->assertEquals(
            Helper::stripEscape("\033[2;2m2 \033[0m\033[2mProcessing... \033[0m\033[16D"),
            Helper::stripEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::stripEscape("\033[3;3m3 \033[0m\033[2mProcessing... \033[0m\033[16D"),
            Helper::stripEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::stripEscape("\033[4;4m4 \033[0m\033[2mProcessing... \033[0m\033[16D"),
            Helper::stripEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::stripEscape("\033[1;1m1 \033[0m\033[2mProcessing... \033[0m\033[16D"),
            Helper::stripEscape($spinner->spin())
        );

        $this->assertEquals(
            "\033[2;2m2 \033[0m\033[2mProcessing... \033[0m\033[16D",
            $spinner->spin()
        );
        $this->assertEquals(
            "\033[3;3m3 \033[0m\033[2mProcessing... \033[0m\033[16D",
            $spinner->spin()
        );
        $this->assertEquals(
            "\033[4;4m4 \033[0m\033[2mProcessing... \033[0m\033[16D",
            $spinner->spin()
        );
        $this->assertEquals(
            "\033[1;1m1 \033[0m\033[2mProcessing... \033[0m\033[16D",
            $spinner->spin()
        );
        $spinner->progress(0);
        $this->assertEquals(
            Helper::stripEscape("\033[2;2m2 \033[0m\033[2mProcessing... \033[0m\033[2m0% \033[0m\033[19D"),
            Helper::stripEscape($spinner->spin())
        );
        $spinner->progress(0.33);
        $this->assertEquals(
            Helper::stripEscape("\033[3;3m3 \033[0m\033[2mProcessing... \033[0m\033[2m33% \033[0m\033[20D"),
            Helper::stripEscape($spinner->spin())
        );
        $spinner->progress(0.5);
        $this->assertEquals(
            Helper::stripEscape("\033[4;4m4 \033[0m\033[2mProcessing... \033[0m\033[2m50% \033[0m\033[20D"),
            Helper::stripEscape($spinner->spin())
        );
        $spinner->progress(1);
        $this->assertEquals(
            Helper::stripEscape("\033[1;1m1 \033[0m\033[2mProcessing... \033[0m\033[2m100% \033[0m\033[21D"),
            Helper::stripEscape($spinner->spin())
        );

        $this->assertEquals(
            Helper::stripEscape("                     \033[21D"),
            Helper::stripEscape($spinner->erase())
        );
        $this->assertEquals(
            Helper::stripEscape("                     \033[21D\033[?25h\033[?0c"),
            Helper::stripEscape($spinner->end())
        );
        $this->assertEquals("                     \033[21D", $spinner->erase());
        $this->assertEquals("                     \033[21D\033[?25h\033[?0c", $spinner->end());
    }

    /** @test */
    public function interfaceWith256Bg(): void
    {
        $spinner = new Extended256BgSpinner(self::PROCESSING, false, COLOR256_TERMINAL);
        $this->assertInstanceOf(Spinner::class, $spinner->inline(true));
        $this->assertInstanceOf(Spinner::class, $spinner->inline(false));


        if (TerminalStatic::supports256Color()) {
            $begin = $spinner->begin();

            // DO NOT CHANGE ORDER!!!
            $this->assertEquals(
                Helper::stripEscape(
                    "\033[?25l\033[38;5;1;48;5;1m1 \033[0m\033[2mProcessing... \033[0m\033[16D"
                ),
                Helper::stripEscape($begin)
            );
            $this->assertEquals(
                "\033[?25l\033[38;5;1;48;5;1m1 \033[0m\033[2mProcessing... \033[0m\033[16D",
                $begin
            );

            $this->assertEquals(
                Helper::stripEscape("\033[38;5;2;48;5;2m2 \033[0m\033[2mProcessing... \033[0m\033[16D"),
                Helper::stripEscape($spinner->spin())
            );
            $this->assertEquals(
                Helper::stripEscape("\033[38;5;3;48;5;3m3 \033[0m\033[2mProcessing... \033[0m\033[16D"),
                Helper::stripEscape($spinner->spin())
            );
            $this->assertEquals(
                Helper::stripEscape("\033[38;5;4;48;5;4m4 \033[0m\033[2mProcessing... \033[0m\033[16D"),
                Helper::stripEscape($spinner->spin())
            );
            $this->assertEquals(
                Helper::stripEscape("\033[38;5;1;48;5;1m1 \033[0m\033[2mProcessing... \033[0m\033[16D"),
                Helper::stripEscape($spinner->spin())
            );

            $this->assertEquals(
                "\033[38;5;2;48;5;2m2 \033[0m\033[2mProcessing... \033[0m\033[16D",
                $spinner->spin()
            );
            $this->assertEquals(
                "\033[38;5;3;48;5;3m3 \033[0m\033[2mProcessing... \033[0m\033[16D",
                $spinner->spin()
            );
            $this->assertEquals(
                "\033[38;5;4;48;5;4m4 \033[0m\033[2mProcessing... \033[0m\033[16D",
                $spinner->spin()
            );
            $this->assertEquals(
                "\033[38;5;1;48;5;1m1 \033[0m\033[2mProcessing... \033[0m\033[16D",
                $spinner->spin()
            );
            $spinner->progress(0);

            $this->assertEquals(
                Helper::stripEscape(
                    "\033[38;5;2;48;5;2m2 \033[0m\033[2mProcessing... \033[0m\033[2m0% \033[0m\033[19D"
                ),
                Helper::stripEscape($spinner->spin())
            );
            $spinner->progress(0.5);

            $this->assertEquals(
                Helper::stripEscape(
                    "\033[38;5;3;48;5;3m3 \033[0m\033[2mProcessing... \033[0m\033[2m50% \033[0m\033[20D"
                ),
                Helper::stripEscape($spinner->spin())
            );
            $spinner->progress(1);
            $this->assertEquals(
                Helper::stripEscape(
                    "\033[38;5;4;48;5;4m4 \033[0m\033[2mProcessing... \033[0m\033[2m100% \033[0m\033[21D"
                ),
                Helper::stripEscape($spinner->spin())
            );
            $this->assertEquals(
                Helper::stripEscape("                     \033[21D"),
                Helper::stripEscape($spinner->erase())
            );
            $this->assertEquals(
                Helper::stripEscape("                     \033[21D\033[?25h\033[?0c"),
                Helper::stripEscape($spinner->end())
            );
            $this->assertEquals("                     \033[21D", $spinner->erase());
            $this->assertEquals("                     \033[21D\033[?25h\033[?0c", $spinner->end());
        }
    }

    /** @test */
    public function noColor(): void
    {
        $spinner = new ExtendedSpinner(self::PROCESSING, false, NO_COLOR_TERMINAL);
        $this->assertInstanceOf(Spinner::class, $spinner->inline(true));
        $this->assertInstanceOf(Spinner::class, $spinner->inline(false));
        $begin = $spinner->begin();

        // DO NOT CHANGE ORDER!!!
        $this->assertEquals(
            Helper::stripEscape("\033[?25l1 Processing... \033[16D"),
            Helper::stripEscape($begin)
        );
        $this->assertEquals(
            "\033[?25l1 Processing... \033[16D",
            $begin
        );

        $this->assertEquals(
            Helper::stripEscape("2 Processing... \033[16D"),
            Helper::stripEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::stripEscape("3 Processing... \033[16D"),
            Helper::stripEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::stripEscape("4 Processing... \033[16D"),
            Helper::stripEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::stripEscape("1 Processing... \033[16D"),
            Helper::stripEscape($spinner->spin())
        );

        $this->assertEquals(
            "2 Processing... \033[16D",
            $spinner->spin()
        );
        $this->assertEquals(
            "3 Processing... \033[16D",
            $spinner->spin()
        );
        $this->assertEquals(
            "4 Processing... \033[16D",
            $spinner->spin()
        );
        $this->assertEquals(
            "1 Processing... \033[16D",
            $spinner->spin()
        );
        $spinner->progress(0);
        $this->assertEquals(
            Helper::stripEscape("2 Processing... 0% \033[19D"),
            Helper::stripEscape($spinner->spin())
        );
        $spinner->progress(0.5);
        $this->assertEquals(
            Helper::stripEscape("3 Processing... 50% \033[20D"),
            Helper::stripEscape($spinner->spin())
        );
        $spinner->progress(1);
        $this->assertEquals(
            Helper::stripEscape("4 Processing... 100% \033[21D"),
            Helper::stripEscape($spinner->spin())
        );

        $this->assertEquals(
            Helper::stripEscape("                     \033[21D"),
            Helper::stripEscape($spinner->erase())
        );
        $this->assertEquals(
            Helper::stripEscape("                     \033[21D\033[?25h\033[?0c"),
            Helper::stripEscape($spinner->end())
        );
        $this->assertEquals("                     \033[21D", $spinner->erase());
        $this->assertEquals("                     \033[21D\033[?25h\033[?0c", $spinner->end());
    }
}
