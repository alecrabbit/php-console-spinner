<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner;

use AlecRabbit\Spinner\Contracts\SettingsInterface;
use AlecRabbit\Spinner\Core\Spinner;
use PHPUnit\Framework\TestCase;

class SpinnerTest extends TestCase
{
    protected const PROCESSING = 'Processing';

    /**
     * @test
     */
    public function instance(): void
    {
        $spinner = new ExtendedSpinner(self::PROCESSING);
        $this->assertInstanceOf(Spinner::class, $spinner);
        $this->assertSame(0.1, $spinner->interval());
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
        $spinner = new ExtendedSpinner(self::PROCESSING);
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
            Helper::stripEscape("\033[2m2\033[0m\033[2m Processing...\033[0m\033[2m 0%\033[0m\033[18D"),
            Helper::stripEscape($spinner->spin(0.0))
        );
        $this->assertEquals(
            Helper::stripEscape("\033[3m3\033[0m\033[2m Processing...\033[0m\033[2m 50%\033[0m\033[19D"),
            Helper::stripEscape($spinner->spin(0.5))
        );
        $this->assertEquals(
            Helper::stripEscape("\033[4m4\033[0m\033[2m Processing...\033[0m\033[2m 100%\033[0m\033[20D"),
            Helper::stripEscape($spinner->spin(1.0))
        );

        $this->assertEquals(
            Helper::stripEscape("                    \033[20D"),
            Helper::stripEscape($spinner->erase())
        );
        $this->assertEquals(
            Helper::stripEscape("                    \033[20D\033[?25h\033[?0c"),
            Helper::stripEscape($spinner->end())
        );
        $this->assertEquals("                    \033[20D", $spinner->erase());
        $this->assertEquals("                    \033[20D\033[?25h\033[?0c", $spinner->end());
    }
}
