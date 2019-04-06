<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner;

use AlecRabbit\Spinner\Contracts\SpinnerInterface;
use AlecRabbit\Spinner\Core\AbstractSpinner;
use PHPUnit\Framework\TestCase;

class AbstractSpinnerTest extends TestCase
{
    protected const PROCESSING = 'Processing';

    /**
     * @test
     * @throws \Exception
     */
    public function instance(): void
    {
        $spinner = new ExtendAbstractSpinner(self::PROCESSING);
        $this->assertInstanceOf(AbstractSpinner::class, $spinner);
        $this->assertIsString($spinner->begin());
        $this->assertIsString($spinner->spin());
        $this->assertIsString($spinner->end());
        $this->assertStringContainsString(self::PROCESSING, $spinner->begin());
        $this->assertStringContainsString(SpinnerInterface::DEFAULT_PREFIX, $spinner->begin());
        $this->assertStringContainsString(SpinnerInterface::DEFAULT_SUFFIX, $spinner->begin());
        $this->assertStringContainsString(self::PROCESSING, $spinner->spin());
        $this->assertStringContainsString(SpinnerInterface::DEFAULT_PREFIX, $spinner->spin());
        $this->assertStringContainsString(SpinnerInterface::DEFAULT_SUFFIX, $spinner->spin());
        $this->assertStringNotContainsString(self::PROCESSING, $spinner->end());
    }

    /**
     * @test
     * @throws \Exception
     */
    public function interface(): void
    {
        $spinner = new ExtendAbstractSpinner(self::PROCESSING);
        $this->assertInstanceOf(AbstractSpinner::class, $spinner->inline(true));
        $this->assertInstanceOf(AbstractSpinner::class, $spinner->inline(false));
        $this->assertEquals("\033[1m1\033[0m Processing...\033[15D", $spinner->begin());
        $this->assertEquals("\033[2m2\033[0m Processing...\033[15D", $spinner->spin());
        $this->assertEquals("\033[3m3\033[0m Processing...\033[15D", $spinner->spin());
        $this->assertEquals("\033[4m4\033[0m Processing...\033[15D", $spinner->spin());
        $this->assertEquals("\033[1m1\033[0m Processing...\033[15D", $spinner->spin());
        $this->assertEquals("               \033[15D", $spinner->erase());
        $this->assertEquals("               \033[15D", $spinner->end());
//        $this->assertEquals('', Helper::stripEscape($spinner->end()));
    }
}
