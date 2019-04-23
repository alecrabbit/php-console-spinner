<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner;

use AlecRabbit\Spinner\Core\Contracts\SettingsInterface;
use AlecRabbit\Spinner\Core\Contracts\SpinnerOutputInterface;
use AlecRabbit\Spinner\Core\Contracts\StylesInterface;
use AlecRabbit\Spinner\Core\Settings;
use AlecRabbit\Spinner\Core\Spinner;
use PHPUnit\Framework\TestCase;

class SpinnerWithOutputTest extends TestCase
{
    protected const PROCESSING = 'Processing';

    /** @test */
    public function instance(): void
    {
        $output = new BufferOutputAdapter();
        $spinner = new ExtendedSpinner(self::PROCESSING, $output, StylesInterface::NO_COLOR);
        $this->assertInstanceOf(Spinner::class, $spinner);
        $this->assertSame(0.1, $spinner->interval());
        $this->assertNotNull($spinner->getOutput());
        $this->assertInstanceOf(SpinnerOutputInterface::class, $spinner->getOutput());
        $this->assertIsString($spinner->begin());
        $this->assertIsString($spinner->spin());
        $this->assertIsString($spinner->end());
        $this->assertStringNotContainsString(self::PROCESSING, $spinner->begin());
        $this->assertStringNotContainsString(SettingsInterface::ONE_SPACE_SYMBOL, $spinner->begin());
        $this->assertStringNotContainsString(SettingsInterface::DEFAULT_SUFFIX, $spinner->begin());
        $this->assertStringNotContainsString(self::PROCESSING, $spinner->spin());
        $this->assertStringNotContainsString(SettingsInterface::ONE_SPACE_SYMBOL, $spinner->spin());
        $this->assertStringNotContainsString(SettingsInterface::DEFAULT_SUFFIX, $spinner->spin());
        $this->assertStringNotContainsString(self::PROCESSING, $spinner->end());
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
        $output = new BufferOutputAdapter();
        $settings = new Settings();
        $settings->setInlinePaddingStr('');
        $settings->setMessage(self::PROCESSING);
        $settings->setStyles($styles);
        $spinner = new NullSpinner($settings, $output, null);
        $spinner->begin();
        $begin = $output->getBuffer();

        // DO NOT CHANGE ORDER!!!
        $this->assertEquals(
            Helper::stripEscape("\033[?25l Processing...\033[15D"),
            Helper::stripEscape($begin)
        );
        $this->assertEquals(
            "\033[?25l Processing...\033[15D",
            $begin
        );
        $spinner->spin();
        $spin = $output->getBuffer();
        $this->assertEquals(
            Helper::stripEscape(" Processing...\033[15D"),
            Helper::stripEscape($spin)
        );
        $spinner->spin();
        $spin = $output->getBuffer();
        $this->assertEquals(
            Helper::stripEscape(" Processing...\033[15D"),
            Helper::stripEscape($spin)
        );
        $spinner->spin();
        $spin = $output->getBuffer();
        $this->assertEquals(
            Helper::stripEscape(" Processing...\033[15D"),
            Helper::stripEscape($spin)
        );
        $spinner->end();
        $end = $output->getBuffer();
        $this->assertEquals(
            Helper::stripEscape("               \033[15D\033[?25h\033[?0c"),
            Helper::stripEscape($end)
        );
    }

    /** @test */
    public function interface(): void
    {
        $output = new BufferOutputAdapter();
        $spinner = new ExtendedSpinner(self::PROCESSING, $output, null);
        $this->assertInstanceOf(Spinner::class, $spinner->inline(true));
        $this->assertInstanceOf(Spinner::class, $spinner->inline(false));
        $spinner->begin();
        $begin = $output->getBuffer();

        // DO NOT CHANGE ORDER!!!
        $this->assertEquals(
            Helper::stripEscape("\033[?25l\033[1m1\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D"),
            Helper::stripEscape($begin)
        );
        $this->assertEquals(
            "\033[?25l\033[1m1\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D",
            $begin
        );

        $spinner->spin();
        $spin = $output->getBuffer();
        $this->assertEquals(
            Helper::stripEscape("\033[2m2\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D"),
            Helper::stripEscape($spin)
        );
        $spinner->spin();
        $spin = $output->getBuffer();
        $this->assertEquals(
            Helper::stripEscape("\033[3m3\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D"),
            Helper::stripEscape($spin)
        );
        $spinner->spin();
        $spin = $output->getBuffer();
        $this->assertEquals(
            Helper::stripEscape("\033[4m4\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D"),
            Helper::stripEscape($spin)
        );
        $spinner->spin();
        $spin = $output->getBuffer();
        $this->assertEquals(
            Helper::stripEscape("\033[1m1\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D"),
            Helper::stripEscape($spin)
        );

        $spinner->spin();
        $spin = $output->getBuffer();
        $this->assertEquals(
            "\033[2m2\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D",
            $spin
        );
        $spinner->spin();
        $spin = $output->getBuffer();
        $this->assertEquals(
            "\033[3m3\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D",
            $spin
        );
        $spinner->spin();
        $spin = $output->getBuffer();
        $this->assertEquals(
            "\033[4m4\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D",
            $spin
        );
        $spinner->spin();
        $spin = $output->getBuffer();
        $this->assertEquals(
            "\033[1m1\033[0m\033[2m Processing...\033[0m\033[2m\033[0m\033[15D",
            $spin
        );
        $spinner->spin(0.0);
        $spin = $output->getBuffer();

        $this->assertEquals(
            Helper::stripEscape("\033[2m2\033[0m\033[2m Processing...\033[0m\033[2m 0%\033[0m\033[18D"),
            Helper::stripEscape($spin)
        );
        $spinner->spin(0.5);
        $spin = $output->getBuffer();
        $this->assertEquals(
            Helper::stripEscape("\033[3m3\033[0m\033[2m Processing...\033[0m\033[2m 50%\033[0m\033[19D"),
            Helper::stripEscape($spin)
        );
        $spinner->spin(1.0);
        $spin = $output->getBuffer();
        $this->assertEquals(
            Helper::stripEscape("\033[4m4\033[0m\033[2m Processing...\033[0m\033[2m 100%\033[0m\033[20D"),
            Helper::stripEscape($spin)
        );

        $spinner->erase();
        $erase = $output->getBuffer();

        $this->assertEquals(
            Helper::stripEscape("                    \033[20D"),
            Helper::stripEscape($erase)
        );
        $spinner->end();
        $end = $output->getBuffer();
        $this->assertEquals(
            Helper::stripEscape("                    \033[20D\033[?25h\033[?0c"),
            Helper::stripEscape($end)
        );
        $this->assertEquals("                    \033[20D", $erase);
        $this->assertEquals("                    \033[20D\033[?25h\033[?0c", $end);
    }
}
