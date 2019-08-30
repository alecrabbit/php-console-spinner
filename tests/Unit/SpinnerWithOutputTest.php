<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner;

use AlecRabbit\Spinner\Core\Contracts\Juggler;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use const AlecRabbit\COLOR256_TERMINAL;
use const AlecRabbit\NO_COLOR_TERMINAL;
use AlecRabbit\Spinner\Core\Contracts\SpinnerOutputInterface;
use AlecRabbit\Spinner\Core\Contracts\StylesInterface;
use AlecRabbit\Spinner\Settings\Settings;
use AlecRabbit\Spinner\Core\Spinner;
use PHPUnit\Framework\TestCase;

class SpinnerWithOutputTest extends TestCase
{
    protected const PROCESSING = 'Processing';

    /** @test */
    public function instance(): void
    {
        $output = new BufferOutputAdapter();
        $spinner = new ExtendedSpinner(self::PROCESSING, $output, NO_COLOR_TERMINAL);
        $this->assertInstanceOf(Spinner::class, $spinner);
        $this->assertSame(0.1, $spinner->interval());
        $spinnerOutput = $spinner->getOutput();
        $this->assertNotNull($spinnerOutput);
        $this->assertInstanceOf(SpinnerOutputInterface::class, $spinnerOutput);
        $this->assertIsString($spinner->begin());
        $this->assertIsString($spinner->spin());
        $this->assertIsString($spinner->end());
        $this->assertStringNotContainsString(self::PROCESSING, $spinner->begin());
        $this->assertStringNotContainsString(Defaults::ONE_SPACE_SYMBOL, $spinner->begin());
        $this->assertStringNotContainsString(Defaults::DOTS_SUFFIX, $spinner->begin());
        $this->assertStringNotContainsString(self::PROCESSING, $spinner->spin());
        $this->assertStringNotContainsString(Defaults::ONE_SPACE_SYMBOL, $spinner->spin());
        $this->assertStringNotContainsString(Defaults::DOTS_SUFFIX, $spinner->spin());
        $this->assertStringNotContainsString(self::PROCESSING, $spinner->end());
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
            Helper::stripEscape("\033[?25lProcessing... \033[14D"),
            Helper::stripEscape($begin)
        );
        $this->assertEquals(
            "\033[?25lProcessing... \033[14D",
            $begin
        );
        $spinner->spin();
        $spin = $output->getBuffer();
        $this->assertEquals(
            Helper::stripEscape("Processing... \033[14D"),
            Helper::stripEscape($spin)
        );
        $spinner->spin();
        $spin = $output->getBuffer();
        $this->assertEquals(
            Helper::stripEscape("Processing... \033[14D"),
            Helper::stripEscape($spin)
        );
        $spinner->spin();
        $spin = $output->getBuffer();
        $this->assertEquals(
            Helper::stripEscape("Processing... \033[14D"),
            Helper::stripEscape($spin)
        );
        $spinner->end();
        $end = $output->getBuffer();
        $this->assertEquals(
            Helper::stripEscape("              \033[14D\033[?25h\033[?0c"),
            Helper::stripEscape($end)
        );
    }

    /** @test */
    public function interface(): void
    {
        $output = new BufferOutputAdapter();
        $spinner = new ExtendedSpinner(self::PROCESSING, $output, COLOR256_TERMINAL);
        $this->assertInstanceOf(Spinner::class, $spinner->inline(true));
        $this->assertInstanceOf(Spinner::class, $spinner->inline(false));
        $spinner->begin();
        $begin = $output->getBuffer();

        // DO NOT CHANGE ORDER!!!
        $this->assertEquals(
            Helper::stripEscape("\033[?25l\033[1m1 \033[0m\033[2mProcessing... \033[0m\033[16D"),
            Helper::stripEscape($begin)
        );
        $this->assertEquals(
            "\033[?25l\033[1m1 \033[0m\033[2mProcessing... \033[0m\033[16D",
            $begin
        );

        $spinner->spin();
        $spin = $output->getBuffer();
        $this->assertEquals(
            Helper::stripEscape("\033[2m2 \033[0m\033[2mProcessing... \033[0m\033[16D"),
            Helper::stripEscape($spin)
        );
        $spinner->spin();
        $spin = $output->getBuffer();
        $this->assertEquals(
            Helper::stripEscape("\033[3m3 \033[0m\033[2mProcessing... \033[0m\033[16D"),
            Helper::stripEscape($spin)
        );
        $spinner->spin();
        $spin = $output->getBuffer();
        $this->assertEquals(
            Helper::stripEscape("\033[4m4 \033[0m\033[2mProcessing... \033[0m\033[16D"),
            Helper::stripEscape($spin)
        );
        $spinner->spin();
        $spin = $output->getBuffer();
        $this->assertEquals(
            Helper::stripEscape("\033[1m1 \033[0m\033[2mProcessing... \033[0m\033[16D"),
            Helper::stripEscape($spin)
        );

        $spinner->spin();
        $spin = $output->getBuffer();
        $this->assertEquals(
            "\033[2m2 \033[0m\033[2mProcessing... \033[0m\033[16D",
            $spin
        );
        $spinner->spin();
        $spin = $output->getBuffer();
        $this->assertEquals(
            "\033[3m3 \033[0m\033[2mProcessing... \033[0m\033[16D",
            $spin
        );
        $spinner->spin();
        $spin = $output->getBuffer();
        $this->assertEquals(
            "\033[4m4 \033[0m\033[2mProcessing... \033[0m\033[16D",
            $spin
        );
        $spinner->spin();
        $spin = $output->getBuffer();
        $this->assertEquals(
            "\033[1m1 \033[0m\033[2mProcessing... \033[0m\033[16D",
            $spin
        );
        $spinner->progress(0);
        $spinner->spin();
        $spin = $output->getBuffer();

        $this->assertEquals(
            Helper::stripEscape("\033[2m2 \033[0m\033[2mProcessing... \033[0m\033[2m0% \033[0m\033[19D"),
            Helper::stripEscape($spin)
        );
        $spinner->progress(0.5);
        $spinner->spin();
        $spin = $output->getBuffer();
        $this->assertEquals(
            Helper::stripEscape("\033[3m3 \033[0m\033[2mProcessing... \033[0m\033[2m50% \033[0m\033[20D"),
            Helper::stripEscape($spin)
        );
        $spinner->progress(1);
        $spinner->spin();
        $spin = $output->getBuffer();
        $this->assertEquals(
            Helper::stripEscape("\033[4m4 \033[0m\033[2mProcessing... \033[0m\033[2m100% \033[0m\033[21D"),
            Helper::stripEscape($spin)
        );

        $spinner->erase();
        $erase = $output->getBuffer();

        $this->assertEquals(
            Helper::stripEscape("                     \033[21D"),
            Helper::stripEscape($erase)
        );
        $spinner->end();
        $end = $output->getBuffer();
        $this->assertEquals(
            Helper::stripEscape("                     \033[21D\033[?25h\033[?0c"),
            Helper::stripEscape($end)
        );
        $this->assertEquals("                     \033[21D", $erase);
        $this->assertEquals("                     \033[21D\033[?25h\033[?0c", $end);
    }
}
