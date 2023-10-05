<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Asynchronous\Probe;

use AlecRabbit\Spinner\Asynchronous\Loop\Creator\ReactLoopCreator;
use AlecRabbit\Spinner\Asynchronous\Loop\Probe\ReactLoopProbe;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class ReactLoopProbeTest extends TestCase
{
    #[Test]
    public function returnsCreatorClass(): void
    {
        self::assertSame(
            ReactLoopCreator::class,
            ReactLoopProbe::getCreatorClass(),
        );
    }

}
