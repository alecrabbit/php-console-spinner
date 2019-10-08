<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Tools;

use AlecRabbit\Spinner\TimeSpinner;
use AlecRabbit\Tests\Spinner\Helper;
use PHPUnit\Framework\TestCase;

use const AlecRabbit\COLOR256_TERMINAL;

class TimeSpinnerTest extends TestCase
{
    protected const PROCESSING = 'Processing';

    /** @test */
    public function instance(): void
    {
        $spinner = new TimeSpinner(self::PROCESSING, false, COLOR256_TERMINAL);
        $timeFormat = 'Y-m-d';
        $spinner->setTimeFormat($timeFormat);
        $this->assertInstanceOf(TimeSpinner::class, $spinner);
        $begin = $spinner->begin(0.0);
        $this->assertIsString($begin);
        $date = date($timeFormat);
        $this->assertEquals(0.5, $spinner->interval());
        $this->assertEquals(
            '\033[?25l\033[2m' . $date . '\033[0m \033[11D',
            Helper::replaceEscape($begin)
        );
        $this->assertEquals(
            '\033[2m' . $date . '\033[0m \033[11D',
            Helper::replaceEscape($spinner->spin())
        );
        $spinner->inline(true);
        $begin = $spinner->begin();
        $this->assertEquals(
            '\033[?25l \033[2m' . $date . '\033[0m \033[12D',
            Helper::replaceEscape($begin)
        );
        $this->assertEquals(
            ' \033[2m' . $date . '\033[0m \033[12D',
            Helper::replaceEscape($spinner->spin())
        );
    }
}
