<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Tools;

use AlecRabbit\Spinner\MoonSpinner;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use PHPUnit\Framework\TestCase;

class MoonSpinnerTest extends TestCase
{
    protected const PROCESSING = 'Processing';

    /**
     * @test

     */
    public function instance(): void
    {
        $spinner = new MoonSpinner(self::PROCESSING, false);
        $this->assertInstanceOf(MoonSpinner::class, $spinner);
        $this->assertIsString($spinner->begin());
        $this->assertIsString($spinner->spin());
        $this->assertIsString($spinner->end());
        $this->assertStringContainsString(self::PROCESSING, $spinner->begin());
        $this->assertStringContainsString(Defaults::ONE_SPACE_SYMBOL, $spinner->begin());
        $this->assertStringContainsString(Defaults::DEFAULT_SUFFIX, $spinner->begin());
        $this->assertStringContainsString(self::PROCESSING, $spinner->spin());
        $this->assertStringContainsString(Defaults::ONE_SPACE_SYMBOL, $spinner->spin());
        $this->assertStringContainsString(Defaults::DEFAULT_SUFFIX, $spinner->spin());
        $this->assertStringNotContainsString(self::PROCESSING, $spinner->end());
    }
}
