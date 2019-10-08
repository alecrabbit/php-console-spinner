<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Tools;

use AlecRabbit\Spinner\Core\Contracts\Frames;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use AlecRabbit\Spinner\SnakeSpinner;
use PHPUnit\Framework\TestCase;

use function AlecRabbit\Helpers\getValue;

class SnakeSpinnerTest extends TestCase
{
    protected const PROCESSING = 'Processing';

    /** @test */
    public function instance(): void
    {
        $spinner = new SnakeSpinner(self::PROCESSING, false);
        $this->assertInstanceOf(SnakeSpinner::class, $spinner);
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

//    /** @test */
//    public function symbols(): void
//    {
//        $spinner = new SnakeSpinner();
//        $circular = getValue($spinner, 'symbols');
//        $rewindable = getValue($circular, 'data');
//        $this->assertEquals(Frames::SNAKE_VARIANT_0, iterator_to_array($rewindable));
//    }
}
