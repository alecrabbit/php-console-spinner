<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Tools;

use AlecRabbit\Spinner\Core\Calculator;
use AlecRabbit\Spinner\Core\Circular;
use AlecRabbit\Spinner\Core\Contracts\Frames;
use PHPUnit\Framework\TestCase;

class CircularTest extends TestCase
{
    /** @test */
    public function emptyArray(): void
    {
        $c = new Circular([]);
        $this->assertEquals(null, $c->value());
        $this->assertEquals(null, $c());
    }
}
