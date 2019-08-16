<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Tools;

use AlecRabbit\Spinner\ClockSpinner;
use AlecRabbit\Spinner\Core\Contracts\SettingsInterface;
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
        $this->assertStringContainsString(SettingsInterface::ONE_SPACE_SYMBOL, $spinner->begin());
        $this->assertStringContainsString(SettingsInterface::DEFAULT_SUFFIX, $spinner->begin());
        $this->assertStringContainsString(self::PROCESSING, $spinner->spin());
        $this->assertStringContainsString(SettingsInterface::ONE_SPACE_SYMBOL, $spinner->spin());
        $this->assertStringContainsString(SettingsInterface::DEFAULT_SUFFIX, $spinner->spin());
        $this->assertStringNotContainsString(self::PROCESSING, $spinner->end());
    }

    /**
     * @test
     * @throws \Exception
     */
    public function interface(): void
    {
        $spinner = new ClockSpinner(self::PROCESSING, false, COLOR_TERMINAL);
        $this->assertInstanceOf(ClockSpinner::class, $spinner->inline(true));
        $this->assertInstanceOf(ClockSpinner::class, $spinner->inline(false));
        $begin = $spinner->begin();

        // DO NOT CHANGE ORDER!!!
        $this->assertEquals(
            Helper::stripEscape("\033[?25l🕐\033[2m Processing...\033[0m\033[2m\033[0m\033[16D"),
            Helper::stripEscape($begin)
        );
        $this->assertEquals("🕑\033[2m Processing...\033[0m\033[2m\033[0m\033[16D", $spinner->spin());
        $this->assertEquals("🕒\033[2m Processing...\033[0m\033[2m\033[0m\033[16D", $spinner->spin());
        $this->assertEquals("🕓\033[2m Processing...\033[0m\033[2m\033[0m\033[16D", $spinner->spin());
        $this->assertEquals("🕔\033[2m Processing...\033[0m\033[2m\033[0m\033[16D", $spinner->spin());
        $this->assertEquals("🕕\033[2m Processing...\033[0m\033[2m\033[0m\033[16D", $spinner->spin());
        $this->assertEquals("🕖\033[2m Processing...\033[0m\033[2m\033[0m\033[16D", $spinner->spin());
        $this->assertEquals("🕗\033[2m Processing...\033[0m\033[2m\033[0m\033[16D", $spinner->spin());
        $this->assertEquals("🕘\033[2m Processing...\033[0m\033[2m\033[0m\033[16D", $spinner->spin());
        $this->assertEquals("🕙\033[2m Processing...\033[0m\033[2m\033[0m\033[16D", $spinner->spin());
        $this->assertEquals("🕚\033[2m Processing...\033[0m\033[2m\033[0m\033[16D", $spinner->spin());
        $this->assertEquals("🕛\033[2m Processing...\033[0m\033[2m\033[0m\033[16D", $spinner->spin());
        $this->assertEquals("🕐\033[2m Processing...\033[0m\033[2m\033[0m\033[16D", $spinner->spin());
        $this->assertEquals("🕑\033[2m Processing...\033[0m\033[2m\033[0m\033[16D", $spinner->spin());


        $this->assertEquals(Helper::stripEscape("                \033[16D"), Helper::stripEscape($spinner->erase()));
        $this->assertEquals(
            Helper::stripEscape("                \033[16D\033[?25h\033[?0c"),
            Helper::stripEscape($spinner->end())
        );
        $this->assertEquals("                \033[16D", $spinner->erase());
        $this->assertEquals(
            "                \033[16D\033[?25h\033[?0c",
            $spinner->end()
        );
    }
}
