<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Asynchronous\Factory;

use AlecRabbit\Spinner\Asynchronous\Factory\RevoltLoopCreator;
use AlecRabbit\Spinner\Asynchronous\Loop\Adapter\RevoltLoopAdapter;
use AlecRabbit\Spinner\Asynchronous\Loop\Probe\RevoltLoopProbe;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class RevoltLoopCreatorTest extends TestCase
{
    #[Test]
    public function canCreate(): void
    {
        if (RevoltLoopProbe::isSupported()) {
            self::assertInstanceOf(
                RevoltLoopAdapter::class,
                RevoltLoopCreator::create(),
            );
        } else {
            self::markTestSkipped('RevoltLoop is not supported');
        }
    }
}
