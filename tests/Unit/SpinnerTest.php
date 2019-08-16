<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner;

use AlecRabbit\Spinner\Core\Contracts\SettingsInterface;
use AlecRabbit\Spinner\Core\Contracts\StylesInterface;
use AlecRabbit\Spinner\Core\Settings;
use AlecRabbit\Spinner\Core\Spinner;
use PHPUnit\Framework\TestCase;
use const AlecRabbit\NO_COLOR_TERMINAL;

class SpinnerTest extends TestCase
{
    protected const PROCESSING = 'Processing';
    protected const COMPUTING = 'computing';

    /** @test */
    public function instance(): void
    {
        $spinner = new ExtendedSpinner(self::PROCESSING, false);
        $this->assertInstanceOf(Spinner::class, $spinner);
        $this->assertSame(0.1, $spinner->interval());
        $this->assertNull($spinner->getOutput());
        $this->assertIsString($spinner->begin());
        $this->assertIsString($spinner->spin());
        $this->assertIsString($spinner->end());
        $this->assertStringContainsString(self::PROCESSING, $spinner->begin());
        $this->assertStringContainsString(SettingsInterface::ONE_SPACE_SYMBOL, $spinner->begin());
        $this->assertStringContainsString(SettingsInterface::DEFAULT_SUFFIX, $spinner->begin());
        $this->assertStringContainsString(self::PROCESSING, $spinner->spin());
        $this->assertStringContainsString(SettingsInterface::ONE_SPACE_SYMBOL, $spinner->spin());
        $this->assertStringContainsString(SettingsInterface::DEFAULT_SUFFIX, $spinner->spin());
        $this->assertStringNotContainsString(self::PROCESSING, $spinner->end());
    }

    /** @test */
    public function instanceWithUpdatingMessage(): void
    {
        $messageComputing = ucfirst(self::COMPUTING);

        $spinner = new ExtendedSpinner(self::PROCESSING, false);
        $this->assertInstanceOf(Spinner::class, $spinner);
        $this->assertSame(0.1, $spinner->interval());
        $this->assertNull($spinner->getOutput());
        $this->assertIsString($spinner->begin());
        $this->assertIsString($spinner->spin(null, self::PROCESSING));
        $this->assertIsString($spinner->end());
        $this->assertStringContainsString(self::PROCESSING, $spinner->begin());
        $this->assertStringContainsString(SettingsInterface::ONE_SPACE_SYMBOL, $spinner->begin());
        $this->assertStringContainsString(SettingsInterface::DEFAULT_SUFFIX, $spinner->begin());
        $this->assertStringContainsString(self::PROCESSING, $spinner->spin(null, self::PROCESSING));
        $this->assertStringContainsString(SettingsInterface::ONE_SPACE_SYMBOL, $spinner->spin(null, self::PROCESSING));
        $this->assertStringContainsString(SettingsInterface::DEFAULT_SUFFIX, $spinner->spin(null, self::PROCESSING));
        $this->assertStringContainsString($messageComputing, $spinner->spin(null, self::COMPUTING));
        $this->assertStringContainsString(SettingsInterface::ONE_SPACE_SYMBOL, $spinner->spin(null, self::COMPUTING));
        $this->assertStringContainsString(SettingsInterface::DEFAULT_SUFFIX, $spinner->spin(null, self::COMPUTING));
        $this->assertStringNotContainsString($messageComputing, $spinner->end());
    }

    /** @test */
    public function wrongFirstArgument(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Instance of SettingsInterface or string expected integer given.');
        new ExtendedSpinner(1);
    }

    /** @test */
    public function wrongSecondArgumentInteger(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Incorrect $output param [null|false|SpinnerOutputInterface] expected "integer" given.'
        );
        new ExtendedSpinner(null, 1);
    }

    /** @test */
    public function wrongSecondArgumentTrue(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Incorrect $output param [null|false|SpinnerOutputInterface] expected "true" given.'
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
                StylesInterface::SPINNER_STYLES =>
                    [
                        StylesInterface::COLOR256 => 1,
                        StylesInterface::COLOR => 1,
                    ],
            ]
        );
        new ExtendedSpinner($settings);
    }

    /** @test */
    public function addingTooMuchSymbols(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('MAX_SYMBOLS_COUNT limit [50] exceeded.');
        (new Settings())->setSymbols(array_fill(0, 56, '-'));
    }

    /** @test */
    public function nullSpinner(): void
    {
        $styles = [
            StylesInterface::SPINNER_STYLES =>
                [
                    StylesInterface::COLOR256 => StylesInterface::DISABLED,
                    StylesInterface::COLOR => StylesInterface::DISABLED,
                ],
            StylesInterface::MESSAGE_STYLES =>
                [
                    StylesInterface::COLOR256 => StylesInterface::DISABLED,
                    StylesInterface::COLOR => StylesInterface::DISABLED,
                ],
            StylesInterface::PERCENT_STYLES =>
                [
                    StylesInterface::COLOR256 => StylesInterface::DISABLED,
                    StylesInterface::COLOR => StylesInterface::DISABLED,
                ],
        ];
        $settings = new Settings();
        $settings->setInlinePaddingStr('');
        $settings->setMessage(self::PROCESSING);
        $settings->setStyles($styles);
        $spinner = new NullSpinner($settings, false);
        $begin = $spinner->begin();

        // DO NOT CHANGE ORDER!!!
        $this->assertEquals(
            Helper::stripEscape("\033[?25l Processing...\033[14D"),
            Helper::stripEscape($begin)
        );
        $this->assertEquals(
            "\033[?25l Processing...\033[14D",
            $begin
        );
        $this->assertEquals(
            Helper::stripEscape(" Processing...\033[14D"),
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
            Helper::stripEscape("\033[?25l \033[1D"),
            Helper::stripEscape($begin)
        );
        $this->assertEquals(
            "\033[?25l \033[1D",
            $begin
        );
        $this->assertEquals(
            Helper::stripEscape(" \033[1D"),
            Helper::stripEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::stripEscape(" \033[1D\033[?25h\033[?0c"),
            Helper::stripEscape($spinner->end())
        );
    }

    /** @test */
    public function interface(): void
    {
        $spinner = new ExtendedSpinner(self::PROCESSING, false);
        $this->assertInstanceOf(Spinner::class, $spinner->inline(true));
        $this->assertInstanceOf(Spinner::class, $spinner->inline(false));

        $begin = $spinner->begin();

        // DO NOT CHANGE ORDER!!!
        $this->assertEquals(
            Helper::stripEscape("\033[?25l\033[1m1\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D"),
            Helper::stripEscape($begin)
        );
        $this->assertEquals(
            "\033[?25l\033[1m1\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D",
            $begin
        );

        $this->assertEquals(
            Helper::stripEscape("\033[2m2\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D"),
            Helper::stripEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::stripEscape("\033[3m3\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D"),
            Helper::stripEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::stripEscape("\033[4m4\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D"),
            Helper::stripEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::stripEscape("\033[1m1\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D"),
            Helper::stripEscape($spinner->spin())
        );

        $this->assertEquals(
            "\033[2m2\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D",
            $spinner->spin()
        );
        $this->assertEquals(
            "\033[3m3\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D",
            $spinner->spin()
        );
        $this->assertEquals(
            "\033[4m4\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D",
            $spinner->spin()
        );
        $this->assertEquals(
            "\033[1m1\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D",
            $spinner->spin()
        );

        $this->assertEquals(
            Helper::stripEscape("\033[2m2\033[0m\033[2m Processing...\033[0m\033[2m 0% \033[0m\033[19D"),
            Helper::stripEscape($spinner->spin(0.0))
        );
        $this->assertEquals(
            Helper::stripEscape("\033[3m3\033[0m\033[2m Processing...\033[0m\033[2m 50% \033[0m\033[20D"),
            Helper::stripEscape($spinner->spin(0.5))
        );
        $this->assertEquals(
            Helper::stripEscape("\033[4m4\033[0m\033[2m Processing...\033[0m\033[2m 100% \033[0m\033[21D"),
            Helper::stripEscape($spinner->spin(1.0))
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
        $spinner = new ExtendedBgSpinner(self::PROCESSING, false);
        $this->assertInstanceOf(Spinner::class, $spinner->inline(true));
        $this->assertInstanceOf(Spinner::class, $spinner->inline(false));

        $begin = $spinner->begin();

        // DO NOT CHANGE ORDER!!!
        $this->assertEquals(
            Helper::stripEscape("\033[?25l\033[1;1m1\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D"),
            Helper::stripEscape($begin)
        );
        $this->assertEquals(
            "\033[?25l\033[1;1m1\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D",
            $begin
        );

        $this->assertEquals(
            Helper::stripEscape("\033[2;2m2\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D"),
            Helper::stripEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::stripEscape("\033[3;3m3\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D"),
            Helper::stripEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::stripEscape("\033[4;4m4\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D"),
            Helper::stripEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::stripEscape("\033[1;1m1\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D"),
            Helper::stripEscape($spinner->spin())
        );

        $this->assertEquals(
            "\033[2;2m2\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D",
            $spinner->spin()
        );
        $this->assertEquals(
            "\033[3;3m3\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D",
            $spinner->spin()
        );
        $this->assertEquals(
            "\033[4;4m4\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D",
            $spinner->spin()
        );
        $this->assertEquals(
            "\033[1;1m1\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D",
            $spinner->spin()
        );

        $this->assertEquals(
            Helper::stripEscape("\033[2;2m2\033[0m\033[2m Processing...\033[0m\033[2m 0% \033[0m\033[19D"),
            Helper::stripEscape($spinner->spin(0.0))
        );
        $this->assertEquals(
            Helper::stripEscape("\033[3;3m3\033[0m\033[2m Processing...\033[0m\033[2m 50% \033[0m\033[20D"),
            Helper::stripEscape($spinner->spin(0.5))
        );
        $this->assertEquals(
            Helper::stripEscape("\033[4;4m4\033[0m\033[2m Processing...\033[0m\033[2m 100% \033[0m\033[21D"),
            Helper::stripEscape($spinner->spin(1.0))
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
        $spinner = new Extended256BgSpinner(self::PROCESSING, false);
        $this->assertInstanceOf(Spinner::class, $spinner->inline(true));
        $this->assertInstanceOf(Spinner::class, $spinner->inline(false));

        $begin = $spinner->begin();

        // DO NOT CHANGE ORDER!!!
        $this->assertEquals(
            Helper::stripEscape("\033[?25l\033[38;5;1;48;5;1m1\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D"),
            Helper::stripEscape($begin)
        );
        $this->assertEquals(
            "\033[?25l\033[38;5;1;48;5;1m1\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D",
            $begin
        );

        $this->assertEquals(
            Helper::stripEscape("\033[38;5;2;48;5;2m2\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D"),
            Helper::stripEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::stripEscape("\033[38;5;3;48;5;3m3\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D"),
            Helper::stripEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::stripEscape("\033[38;5;4;48;5;4m4\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D"),
            Helper::stripEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::stripEscape("\033[38;5;1;48;5;1m1\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D"),
            Helper::stripEscape($spinner->spin())
        );

        $this->assertEquals(
            "\033[38;5;2;48;5;2m2\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D",
            $spinner->spin()
        );
        $this->assertEquals(
            "\033[38;5;3;48;5;3m3\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D",
            $spinner->spin()
        );
        $this->assertEquals(
            "\033[38;5;4;48;5;4m4\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D",
            $spinner->spin()
        );
        $this->assertEquals(
            "\033[38;5;1;48;5;1m1\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D",
            $spinner->spin()
        );

        $this->assertEquals(
            Helper::stripEscape("\033[38;5;2;48;5;2m2\033[0m\033[2m Processing...\033[0m\033[2m 0% \033[0m\033[19D"),
            Helper::stripEscape($spinner->spin(0.0))
        );
        $this->assertEquals(
            Helper::stripEscape("\033[38;5;3;48;5;3m3\033[0m\033[2m Processing...\033[0m\033[2m 50% \033[0m\033[20D"),
            Helper::stripEscape($spinner->spin(0.5))
        );
        $this->assertEquals(
            Helper::stripEscape("\033[38;5;4;48;5;4m4\033[0m\033[2m Processing...\033[0m\033[2m 100% \033[0m\033[21D"),
            Helper::stripEscape($spinner->spin(1.0))
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
    public function unimplemented(): void
    {
        $spinner = new ExtendedSpinner(self::PROCESSING, false, NO_COLOR_TERMINAL);
        $this->assertInstanceOf(Spinner::class, $spinner);
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(
            'AlecRabbit\Tests\Spinner\ExtendedSpinner: ' .
            'Call to unimplemented functionality ' .
            'AlecRabbit\Spinner\Core\Spinner::getSettings'
        );
        $spinner->getSettings();
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
            Helper::stripEscape("\033[?25l1 Processing...\033[15D"),
            Helper::stripEscape($begin)
        );
        $this->assertEquals(
            "\033[?25l1 Processing...\033[15D",
            $begin
        );

        $this->assertEquals(
            Helper::stripEscape("2 Processing...\033[15D"),
            Helper::stripEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::stripEscape("3 Processing...\033[15D"),
            Helper::stripEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::stripEscape("4 Processing...\033[15D"),
            Helper::stripEscape($spinner->spin())
        );
        $this->assertEquals(
            Helper::stripEscape("1 Processing...\033[15D"),
            Helper::stripEscape($spinner->spin())
        );

        $this->assertEquals(
            "2 Processing...\033[15D",
            $spinner->spin()
        );
        $this->assertEquals(
            "3 Processing...\033[15D",
            $spinner->spin()
        );
        $this->assertEquals(
            "4 Processing...\033[15D",
            $spinner->spin()
        );
        $this->assertEquals(
            "1 Processing...\033[15D",
            $spinner->spin()
        );

        $this->assertEquals(
            Helper::stripEscape("2 Processing... 0% \033[19D"),
            Helper::stripEscape($spinner->spin(0.0))
        );
        $this->assertEquals(
            Helper::stripEscape("3 Processing... 50% \033[20D"),
            Helper::stripEscape($spinner->spin(0.5))
        );
        $this->assertEquals(
            Helper::stripEscape("4 Processing... 100% \033[21D"),
            Helper::stripEscape($spinner->spin(1.0))
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
