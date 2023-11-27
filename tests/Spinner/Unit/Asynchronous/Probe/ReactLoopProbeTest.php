<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Asynchronous\Probe;

use AlecRabbit\Spinner\Asynchronous\React\ReactLoopCreator;
use AlecRabbit\Spinner\Asynchronous\React\ReactLoopProbe;
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
