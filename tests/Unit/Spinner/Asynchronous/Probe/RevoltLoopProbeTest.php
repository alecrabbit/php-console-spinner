<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Asynchronous\Probe;

use AlecRabbit\Spinner\Asynchronous\Factory\RevoltLoopCreator;
use AlecRabbit\Spinner\Asynchronous\Loop\Probe\RevoltLoopProbe;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class RevoltLoopProbeTest extends TestCase
{
    #[Test]
    public function returnsCreatorClass(): void
    {
        self::assertSame(
            RevoltLoopCreator::class,
            RevoltLoopProbe::getCreatorClass(),
        );
    }

}
