<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Tools;

use AlecRabbit\Spinner\Core\Contracts\SettingsInterface;
use AlecRabbit\Spinner\PercentSpinner;
use PHPUnit\Framework\TestCase;
use function AlecRabbit\Helpers\getValue;

class PercentSpinnerTest extends TestCase
{
    protected const PROCESSING = 'Processing';

    /** @test */
    public function instance(): void
    {
        $spinner = new PercentSpinner(self::PROCESSING);
        $this->assertInstanceOf(PercentSpinner::class, $spinner);
        $begin = $spinner->begin(0.0);
        $this->assertIsString($begin);
        $spin_10percent = $spinner->spin(0.1);
        $this->assertIsString($spin_10percent);
        $this->assertIsString($spinner->end());
        $this->assertStringContainsString(self::PROCESSING, $begin);
        $this->assertStringContainsString(SettingsInterface::ONE_SPACE_SYMBOL, $begin);
        $this->assertStringContainsString(SettingsInterface::DEFAULT_SUFFIX, $begin);
        $this->assertStringContainsString(self::PROCESSING, $spin_10percent);
        $this->assertStringContainsString(SettingsInterface::ONE_SPACE_SYMBOL, $spin_10percent);
        $this->assertStringContainsString(SettingsInterface::DEFAULT_SUFFIX, $spin_10percent);
        $this->assertStringNotContainsString(self::PROCESSING, $spinner->end());
    }

    /** @test */
    public function instanceWithException(): void
    {
        $spinner = new PercentSpinner(self::PROCESSING);
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Float percentage value expected NULL given.');
        $spinner->spin();
    }

    /** @test */
    public function symbols(): void
    {
        $spinner = new PercentSpinner();
        $circular = getValue($spinner, 'symbols');
        $data = getValue($circular, 'data');
        $this->assertNull($data);
    }
}
