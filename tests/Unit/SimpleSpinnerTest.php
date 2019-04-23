<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Tools;

use AlecRabbit\Spinner\Core\Contracts\SettingsInterface;
use AlecRabbit\Spinner\SimpleSpinner;
use PHPUnit\Framework\TestCase;

class SimpleSpinnerTest extends TestCase
{
    protected const PROCESSING = 'Processing';

    /**
     * @test
     */
    public function instance(): void
    {
        $spinner = new SimpleSpinner(self::PROCESSING, false);
        $this->assertInstanceOf(SimpleSpinner::class, $spinner);
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
}
