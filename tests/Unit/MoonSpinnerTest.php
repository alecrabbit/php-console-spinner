<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Tools;

use AlecRabbit\Spinner\Contracts\SpinnerInterface;
use AlecRabbit\Spinner\MoonSpinner;
use PHPUnit\Framework\TestCase;

/**
 * @group time-sensitive
 */
class MoonSpinnerTest extends TestCase
{
    protected const PROCESSING = 'Processing';

    /**
     * @test

     */
    public function instance(): void
    {
        $spinner = new MoonSpinner(self::PROCESSING);
        $this->assertInstanceOf(MoonSpinner::class, $spinner);
        $this->assertIsString($spinner->begin());
        $this->assertIsString($spinner->spin());
        $this->assertIsString($spinner->end());
        $this->assertStringContainsString(self::PROCESSING, $spinner->begin());
        $this->assertStringContainsString(SpinnerInterface::ONE_SPACE_SYMBOL, $spinner->begin());
        $this->assertStringContainsString(SpinnerInterface::DEFAULT_SUFFIX, $spinner->begin());
        $this->assertStringContainsString(self::PROCESSING, $spinner->spin());
        $this->assertStringContainsString(SpinnerInterface::ONE_SPACE_SYMBOL, $spinner->spin());
        $this->assertStringContainsString(SpinnerInterface::DEFAULT_SUFFIX, $spinner->spin());
        $this->assertStringNotContainsString(self::PROCESSING, $spinner->end());
    }
}
