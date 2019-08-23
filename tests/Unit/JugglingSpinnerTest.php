<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Tools;

use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\TimeSpinner;
use AlecRabbit\Tests\Spinner\Helper;
use PHPUnit\Framework\TestCase;
use const AlecRabbit\COLOR256_TERMINAL;

class JugglingSpinnerTest extends TestCase
{
    protected const PROCESSING = 'Processing';

    /** @test */
    public function instance(): void
    {
        $spinner = new Spinner(self::PROCESSING, false, COLOR256_TERMINAL);
        $this->assertInstanceOf(Spinner::class, $spinner);
        $begin = $spinner->begin(0.0);
        $this->assertIsString($begin);
        $this->assertEquals(
            '---',
            Helper::stripEscape($begin)
        );
    }
}
