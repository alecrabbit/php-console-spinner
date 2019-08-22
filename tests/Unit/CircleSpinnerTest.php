<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Tools;

use AlecRabbit\Spinner\CircleSpinner;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use PHPUnit\Framework\TestCase;

class CircleSpinnerTest extends TestCase
{
    protected const PROCESSING = 'Processing';

    /**
     * @test
     */
    public function instance(): void
    {
        $spinner = new CircleSpinner(self::PROCESSING, false);
        $this->assertInstanceOf(CircleSpinner::class, $spinner);
        $begin = $spinner->begin();
        $this->assertIsString($begin);
        $this->assertStringContainsString(self::PROCESSING, $begin);
        $this->assertStringContainsString(Defaults::ONE_SPACE_SYMBOL, $begin);
        $this->assertStringContainsString(Defaults::DEFAULT_SUFFIX, $begin);
        $this->assertIsString($spinner->spin());
        $this->assertStringContainsString(self::PROCESSING, $spinner->spin());
        $this->assertStringContainsString(Defaults::ONE_SPACE_SYMBOL, $spinner->spin());
        $this->assertStringContainsString(Defaults::DEFAULT_SUFFIX, $spinner->spin());
        $end = $spinner->end();
        $this->assertIsString($end);
        $this->assertStringNotContainsString(self::PROCESSING, $end);
    }
}
