<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Asynchronous\Factory;

use AlecRabbit\Spinner\Asynchronous\React\ReactLoopAdapter;
use AlecRabbit\Spinner\Asynchronous\React\ReactLoopCreator;
use AlecRabbit\Spinner\Asynchronous\React\ReactLoopProbe;
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
                (new ReactLoopCreator)->create(),
            );
        } else {
            self::markTestSkipped('ReactLoop is not supported');
        }
    }
}
