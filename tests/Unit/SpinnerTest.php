<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner;

use AlecRabbit\Cli\Tools\Core\Terminal;
use AlecRabbit\Cli\Tools\Core\TerminalStatic;
use AlecRabbit\Spinner\Core\Contracts\Juggler;
use AlecRabbit\Spinner\Core\Contracts\OutputInterface;
use AlecRabbit\Spinner\Core\Contracts\Styles;
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
    public function instanceDisabled(): void
    {
        $spinner = new ExtendedSpinner(self::PROCESSING, false, NO_COLOR_TERMINAL);
        $spinner->disable();
        $this->assertInstanceOf(Spinner::class, $spinner);
        $this->assertSame(0.1, $spinner->interval());
        $this->assertFalse($spinner->isActive());
        $this->assertNull($spinner->getOutput());
        $this->assertIsString($spinner->begin());
        $this->assertIsString($spinner->spin());
        $this->assertIsString($spinner->end());
        $this->assertEquals(Defaults::EMPTY_STRING, $spinner->begin());
        $this->assertEquals(Defaults::EMPTY_STRING, $spinner->begin());
        $this->assertEquals(Defaults::EMPTY_STRING, $spinner->begin());
        $this->assertEquals(Defaults::EMPTY_STRING, $spinner->spin());
        $this->assertEquals(Defaults::EMPTY_STRING, $spinner->spin());
        $this->assertEquals(Defaults::EMPTY_STRING, $spinner->spin());
        $this->assertEquals(Defaults::EMPTY_STRING, $spinner->erase());
        $this->assertEquals(Defaults::EMPTY_STRING, $spinner->last());
        $this->assertEquals(Defaults::EMPTY_STRING, $spinner->end());
        $spinner->enable();
        $this->assertTrue($spinner->isActive());
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
            'Incorrect parameter: [null|false|' . OutputInterface::class . '] expected "integer" given.'
        );
        new ExtendedSpinner(null, 1);
    }

    /** @test */
    public function wrongSecondArgumentTrue(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Incorrect parameter: [null|false|' . OutputInterface::class . '] expected "true" given.'
        );
        new ExtendedSpinner(null, true);
    }

//    /** @test */
//    public function wrongArgumentSettings(): void
//    {
//        $this->expectException(\InvalidArgumentException::class);
//        $settings = new Settings();
//        $settings->setStyles(
//            [
//                Juggler::FRAMES_STYLES =>
//                    [
//                        Juggler::COLOR256 => 1,
//                        Juggler::COLOR => 1,
//                    ],
//            ]
//        );
//        $spinner = new ExtendedSpinner($settings, null, COLOR256_TERMINAL);
//    }

    /** @test */
    public function addingTooMuchSymbols(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $count = Defaults::MAX_FRAMES_COUNT + 10;
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
                    Juggler::COLOR256 => Styles::DISABLED,
                    Juggler::COLOR => Styles::DISABLED,
                ],
            Juggler::MESSAGE_STYLES =>
                [
                    Juggler::COLOR256 => Styles::DISABLED,
                    Juggler::COLOR => Styles::DISABLED,
                ],
            Juggler::PROGRESS_STYLES =>
                [
                    Juggler::COLOR256 => Styles::DISABLED,
                    Juggler::COLOR => Styles::DISABLED,
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
            Helper::replaceEscape("\033[?25lProcessing... \033[14D"),
            Helper::replaceEscape($begin)
        );
        $this->assertEquals(
            "\033[?25lProcessing... \033[14D",
            $begin
        );
        $this->assertEquals(
            Helper::replaceEscape("Processing... \033[14D"),
            Helper::replaceEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::replaceEscape("              \033[14D\033[?25h\033[?0c"),
            Helper::replaceEscape($spinner->end())
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
            Helper::replaceEscape("\033[?25l\033[0D"),
            Helper::replaceEscape($begin)
        );
        $this->assertEquals(
            "\033[?25l\033[0D",
            $begin
        );
        $this->assertEquals(
            Helper::replaceEscape("\033[0D"),
            Helper::replaceEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::replaceEscape("\033[0D\033[?25h\033[?0c"),
            Helper::replaceEscape($spinner->end())
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
            Helper::replaceEscape("\033[?25l\033[1m1\033[0m \033[2mProcessing...\033[0m \033[16D"),
            Helper::replaceEscape($begin)
        );
        $this->assertEquals(
            "\033[?25l\033[1m1\033[0m \033[2mProcessing...\033[0m \033[16D",
            $begin
        );

        $this->assertEquals(
            Helper::replaceEscape("\033[2m2\033[0m \033[2mProcessing...\033[0m \033[16D"),
            Helper::replaceEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::replaceEscape("\033[3m3\033[0m \033[2mProcessing...\033[0m \033[16D"),
            Helper::replaceEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::replaceEscape("\033[4m4\033[0m \033[2mProcessing...\033[0m \033[16D"),
            Helper::replaceEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::replaceEscape("\033[1m1\033[0m \033[2mProcessing...\033[0m \033[16D"),
            Helper::replaceEscape($spinner->spin())
        );

        $this->assertEquals(
            "\033[2m2\033[0m \033[2mProcessing...\033[0m \033[16D",
            $spinner->spin()
        );
        $this->assertEquals(
            "\033[3m3\033[0m \033[2mProcessing...\033[0m \033[16D",
            $spinner->spin()
        );
        $this->assertEquals(
            "\033[4m4\033[0m \033[2mProcessing...\033[0m \033[16D",
            $spinner->spin()
        );
        $this->assertEquals(
            "\033[1m1\033[0m \033[2mProcessing...\033[0m \033[16D",
            $spinner->spin()
        );
        $spinner->progress(0);
        $this->assertEquals(
            Helper::replaceEscape("\033[2m2\033[0m \033[2mProcessing...\033[0m \033[2m0%\033[0m \033[19D"),
            Helper::replaceEscape($spinner->spin())
        );
        $spinner->progress(0.5);

        $this->assertEquals(
            Helper::replaceEscape("\033[3m3\033[0m \033[2mProcessing...\033[0m \033[2m50%\033[0m \033[20D"),
            Helper::replaceEscape($spinner->spin())
        );
        $spinner->progress(1);
        $this->assertEquals(
            Helper::replaceEscape("\033[4m4\033[0m \033[2mProcessing...\033[0m \033[2m100%\033[0m \033[21D"),
            Helper::replaceEscape($spinner->spin())
        );

        $this->assertEquals(
            Helper::replaceEscape("                     \033[21D"),
            Helper::replaceEscape($spinner->erase())
        );
        $this->assertEquals(
            Helper::replaceEscape("                     \033[21D\033[?25h\033[?0c"),
            Helper::replaceEscape($spinner->end())
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
            Helper::replaceEscape("\033[?25l\033[1;1m1\033[0m \033[2mProcessing...\033[0m \033[16D"),
            Helper::replaceEscape($begin)
        );
        $this->assertEquals(
            "\033[?25l\033[1;1m1\033[0m \033[2mProcessing...\033[0m \033[16D",
            $begin
        );

        $this->assertEquals(
            Helper::replaceEscape("\033[2;2m2\033[0m \033[2mProcessing...\033[0m \033[16D"),
            Helper::replaceEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::replaceEscape("\033[3;3m3\033[0m \033[2mProcessing...\033[0m \033[16D"),
            Helper::replaceEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::replaceEscape("\033[4;4m4\033[0m \033[2mProcessing...\033[0m \033[16D"),
            Helper::replaceEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::replaceEscape("\033[1;1m1\033[0m \033[2mProcessing...\033[0m \033[16D"),
            Helper::replaceEscape($spinner->spin())
        );

        $this->assertEquals(
            "\033[2;2m2\033[0m \033[2mProcessing...\033[0m \033[16D",
            $spinner->spin()
        );
        $this->assertEquals(
            "\033[3;3m3\033[0m \033[2mProcessing...\033[0m \033[16D",
            $spinner->spin()
        );
        $this->assertEquals(
            "\033[4;4m4\033[0m \033[2mProcessing...\033[0m \033[16D",
            $spinner->spin()
        );
        $this->assertEquals(
            "\033[1;1m1\033[0m \033[2mProcessing...\033[0m \033[16D",
            $spinner->spin()
        );
        $spinner->progress(0);
        $this->assertEquals(
            Helper::replaceEscape("\033[2;2m2\033[0m \033[2mProcessing...\033[0m \033[2m0%\033[0m \033[19D"),
            Helper::replaceEscape($spinner->spin())
        );
        $spinner->progress(0.33);
        $this->assertEquals(
            Helper::replaceEscape("\033[3;3m3\033[0m \033[2mProcessing...\033[0m \033[2m33%\033[0m \033[20D"),
            Helper::replaceEscape($spinner->spin())
        );
        $spinner->progress(0.5);
        $this->assertEquals(
            Helper::replaceEscape("\033[4;4m4\033[0m \033[2mProcessing...\033[0m \033[2m50%\033[0m \033[20D"),
            Helper::replaceEscape($spinner->spin())
        );
        $spinner->progress(1);
        $this->assertEquals(
            Helper::replaceEscape("\033[1;1m1\033[0m \033[2mProcessing...\033[0m \033[2m100%\033[0m \033[21D"),
            Helper::replaceEscape($spinner->spin())
        );

        $this->assertEquals(
            Helper::replaceEscape("                     \033[21D"),
            Helper::replaceEscape($spinner->erase())
        );
        $this->assertEquals(
            Helper::replaceEscape("                     \033[21D\033[?25h\033[?0c"),
            Helper::replaceEscape($spinner->end())
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


        if (COLOR256_TERMINAL <= Terminal::colorSupport()) {
            $begin = $spinner->begin();

            // DO NOT CHANGE ORDER!!!
            $this->assertEquals(
                Helper::replaceEscape(
                    "\033[?25l\033[38;5;1;48;5;1m1\033[0m \033[2mProcessing...\033[0m \033[16D"
                ),
                Helper::replaceEscape($begin)
            );
            $this->assertEquals(
                "\033[?25l\033[38;5;1;48;5;1m1\033[0m \033[2mProcessing...\033[0m \033[16D",
                $begin
            );

            $this->assertEquals(
                Helper::replaceEscape("\033[38;5;2;48;5;2m2\033[0m \033[2mProcessing...\033[0m \033[16D"),
                Helper::replaceEscape($spinner->spin())
            );
            $this->assertEquals(
                Helper::replaceEscape("\033[38;5;3;48;5;3m3\033[0m \033[2mProcessing...\033[0m \033[16D"),
                Helper::replaceEscape($spinner->spin())
            );
            $this->assertEquals(
                Helper::replaceEscape("\033[38;5;4;48;5;4m4\033[0m \033[2mProcessing...\033[0m \033[16D"),
                Helper::replaceEscape($spinner->spin())
            );
            $this->assertEquals(
                Helper::replaceEscape("\033[38;5;1;48;5;1m1\033[0m \033[2mProcessing...\033[0m \033[16D"),
                Helper::replaceEscape($spinner->spin())
            );

            $this->assertEquals(
                "\033[38;5;2;48;5;2m2\033[0m \033[2mProcessing...\033[0m \033[16D",
                $spinner->spin()
            );
            $this->assertEquals(
                "\033[38;5;3;48;5;3m3\033[0m \033[2mProcessing...\033[0m \033[16D",
                $spinner->spin()
            );
            $this->assertEquals(
                "\033[38;5;4;48;5;4m4\033[0m \033[2mProcessing...\033[0m \033[16D",
                $spinner->spin()
            );
            $this->assertEquals(
                "\033[38;5;1;48;5;1m1\033[0m \033[2mProcessing...\033[0m \033[16D",
                $spinner->spin()
            );
            $spinner->progress(0);

            $this->assertEquals(
                Helper::replaceEscape(
                    "\033[38;5;2;48;5;2m2\033[0m \033[2mProcessing...\033[0m \033[2m0%\033[0m \033[19D"
                ),
                Helper::replaceEscape($spinner->spin())
            );
            $spinner->progress(0.5);

            $this->assertEquals(
                Helper::replaceEscape(
                    "\033[38;5;3;48;5;3m3\033[0m \033[2mProcessing...\033[0m \033[2m50%\033[0m \033[20D"
                ),
                Helper::replaceEscape($spinner->spin())
            );
            $spinner->progress(1);
            $this->assertEquals(
                Helper::replaceEscape(
                    "\033[38;5;4;48;5;4m4\033[0m \033[2mProcessing...\033[0m \033[2m100%\033[0m \033[21D"
                ),
                Helper::replaceEscape($spinner->spin())
            );
            $this->assertEquals(
                Helper::replaceEscape("                     \033[21D"),
                Helper::replaceEscape($spinner->erase())
            );
            $this->assertEquals(
                Helper::replaceEscape("                     \033[21D\033[?25h\033[?0c"),
                Helper::replaceEscape($spinner->end())
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
            Helper::replaceEscape("\033[?25l1 Processing... \033[16D"),
            Helper::replaceEscape($begin)
        );
        $this->assertEquals(
            "\033[?25l1 Processing... \033[16D",
            $begin
        );

        $this->assertEquals(
            Helper::replaceEscape("2 Processing... \033[16D"),
            Helper::replaceEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::replaceEscape("3 Processing... \033[16D"),
            Helper::replaceEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::replaceEscape("4 Processing... \033[16D"),
            Helper::replaceEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::replaceEscape("1 Processing... \033[16D"),
            Helper::replaceEscape($spinner->spin())
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
            Helper::replaceEscape("2 Processing... 0% \033[19D"),
            Helper::replaceEscape($spinner->spin())
        );
        $spinner->progress(0.5);
        $this->assertEquals(
            Helper::replaceEscape("3 Processing... 50% \033[20D"),
            Helper::replaceEscape($spinner->spin())
        );
        $spinner->progress(1);
        $this->assertEquals(
            Helper::replaceEscape("4 Processing... 100% \033[21D"),
            Helper::replaceEscape($spinner->spin())
        );

        $this->assertEquals(
            Helper::replaceEscape("                     \033[21D"),
            Helper::replaceEscape($spinner->erase())
        );
        $this->assertEquals(
            Helper::replaceEscape("                     \033[21D\033[?25h\033[?0c"),
            Helper::replaceEscape($spinner->end())
        );
        $this->assertEquals("                     \033[21D", $spinner->erase());
        $this->assertEquals("                     \033[21D\033[?25h\033[?0c", $spinner->end());
    }
}
