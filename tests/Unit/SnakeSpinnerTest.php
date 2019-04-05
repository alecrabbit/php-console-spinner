<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Tools;

use AlecRabbit\Tools\HRTimer;
use AlecRabbit\Tools\Spinner\Contracts\SpinnerInterface;
use AlecRabbit\Tools\Spinner\Core\AbstractSpinner;
use AlecRabbit\Tools\Spinner\SnakeSpinner;
use PHPUnit\Framework\TestCase;
use const AlecRabbit\Tools\HRTIMER_VALUE_COEFFICIENT;
use const AlecRabbit\Traits\Constants\DEFAULT_NAME;

/**
 * @group time-sensitive
 */
class SnakeSpinnerTest extends TestCase
{
    protected const PROCESSING = 'Processing';

    /**
     * @test
     * @throws \Exception
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
