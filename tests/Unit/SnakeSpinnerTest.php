<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Tools;

use AlecRabbit\Spinner\Contracts\SpinnerInterface;
use AlecRabbit\Spinner\SnakeSpinner;
use PHPUnit\Framework\TestCase;

/**
 * @group time-sensitive
 */
class SnakeSpinnerTest extends TestCase
{
    protected const PROCESSING = 'Processing';

    /**
     * @test
     */
    public function instance(): void
    {
        $spinner = new SnakeSpinner(self::PROCESSING);
        $this->assertInstanceOf(SnakeSpinner::class, $spinner);
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
}
