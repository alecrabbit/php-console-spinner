<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Asynchronous\Factory;

use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\LoopFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class LoopFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $loopFactory = $this->getTesteeInstance();

        self::assertInstanceOf(LoopFactory::class, $loopFactory);
    }

    public function getTesteeInstance(): ILoopFactory
    {
        return new LoopFactory();
    }
}
