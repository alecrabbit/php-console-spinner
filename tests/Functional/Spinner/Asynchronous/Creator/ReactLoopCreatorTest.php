<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Asynchronous\Creator;

use AlecRabbit\Spinner\Asynchronous\Loop\Adapter\ReactLoopAdapter;
use AlecRabbit\Spinner\Asynchronous\Loop\Creator\ReactLoopCreator;
use AlecRabbit\Spinner\Asynchronous\Loop\Probe\ReactLoopProbe;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class ReactLoopCreatorTest extends TestCase
{
    #[Test]
    public function canCreate(): void
    {
        if (ReactLoopProbe::isSupported()) {
            self::assertInstanceOf(
                ReactLoopAdapter::class,
                ReactLoopCreator::create(),
            );
        } else {
            self::markTestSkipped('ReactLoop is not supported');
        }
    }
}
