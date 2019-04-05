<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Tools;

use AlecRabbit\Tools\Spinner\Contracts\SpinnerInterface;
use AlecRabbit\Tools\Spinner\MoonSpinner;
use AlecRabbit\Tools\Spinner\TrigramSpinner;
use PHPUnit\Framework\TestCase;

/**
 * @group time-sensitive
 */
class TrigramSpinnerTest extends TestCase
{
    protected const PROCESSING = 'Processing';

    /**
     * @test
     * @throws \Exception
     */
    public function instance(): void
    {
        $spinner = new TrigramSpinner(self::PROCESSING);
        $this->assertInstanceOf(TrigramSpinner::class, $spinner);
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
