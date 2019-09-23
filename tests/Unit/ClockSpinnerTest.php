<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Tools;

use AlecRabbit\Spinner\ClockSpinner;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use AlecRabbit\Tests\Spinner\Helper;
use PHPUnit\Framework\TestCase;
use const AlecRabbit\COLOR_TERMINAL;

class ClockSpinnerTest extends TestCase
{
    protected const PROCESSING = 'Processing';

    /**
     * @test
     */
    public function instance(): void
    {
        $spinner = new ClockSpinner(self::PROCESSING, false);
        $this->assertInstanceOf(ClockSpinner::class, $spinner);
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
    public function secondary(): void
    {
        $spinner = new ClockSpinner(self::PROCESSING, false, COLOR_TERMINAL);
        $this->assertInstanceOf(ClockSpinner::class, $spinner->inline(true));
        $this->assertInstanceOf(ClockSpinner::class, $spinner->inline(false));
        $begin = $spinner->begin();

        // DO NOT CHANGE ORDER!!!
        $this->assertEquals(
            Helper::replaceEscape("\033[?25l🕐 \033[2mProcessing...\033[0m \033[17D"),
            Helper::replaceEscape($begin)
        );
        $this->assertEquals("🕑 \033[2mProcessing...\033[0m \033[17D", $spinner->spin());
        $this->assertEquals("🕒 \033[2mProcessing...\033[0m \033[17D", $spinner->spin());
        $this->assertEquals("🕓 \033[2mProcessing...\033[0m \033[17D", $spinner->spin());
        $this->assertEquals("🕔 \033[2mProcessing...\033[0m \033[17D", $spinner->spin());
        $this->assertEquals("🕕 \033[2mProcessing...\033[0m \033[17D", $spinner->spin());
        $this->assertEquals("🕖 \033[2mProcessing...\033[0m \033[17D", $spinner->spin());
        $this->assertEquals("🕗 \033[2mProcessing...\033[0m \033[17D", $spinner->spin());
        $this->assertEquals("🕘 \033[2mProcessing...\033[0m \033[17D", $spinner->spin());
        $this->assertEquals("🕙 \033[2mProcessing...\033[0m \033[17D", $spinner->spin());
        $this->assertEquals("🕚 \033[2mProcessing...\033[0m \033[17D", $spinner->spin());
        $this->assertEquals("🕛 \033[2mProcessing...\033[0m \033[17D", $spinner->spin());
        $this->assertEquals("🕐 \033[2mProcessing...\033[0m \033[17D", $spinner->spin());
        $this->assertEquals("🕑 \033[2mProcessing...\033[0m \033[17D", $spinner->spin());


        $this->assertEquals(
            Helper::replaceEscape("                 \033[17D"),
            Helper::replaceEscape($spinner->erase())
        );
        $this->assertEquals(
            Helper::replaceEscape("                 \033[17D\033[?25h"),
            Helper::replaceEscape($spinner->end())
        );
        $this->assertEquals("                 \033[17D", $spinner->erase());
        $this->assertEquals(
            "                 \033[17D\033[?25h",
            $spinner->end()
        );
    }
}
