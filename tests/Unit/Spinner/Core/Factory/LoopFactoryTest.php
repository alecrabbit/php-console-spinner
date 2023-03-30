<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\LoopFactory;
use AlecRabbit\Spinner\Core\Loop\LoopManagerDummy;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class LoopFactoryTest extends TestCase
{
    #[Test]
    public function canBeCreated(): void
    {
        $loopFactory = $this->getTesteeInstance(container: null);

        self::assertInstanceOf(LoopFactory::class, $loopFactory);
    }

    public function getTesteeInstance(
        (MockObject&IContainer)|null $container,
    ): ILoopFactory {
        return
            new LoopFactory(
                container: $container ?? $this->getContainerMock(),
            );
    }

    protected function getContainerMock(): MockObject&IContainer
    {
        return $this->createMock(IContainer::class);
    }

    #[Test]
    public function throwsOnLoopGet(): void
    {
        $container = $this->createMock(IContainer::class);
        $container
            ->method('get')
            ->willReturn(new LoopManagerDummy())
        ;

        $loopFactory = $this->getTesteeInstance(container: $container);

        $exception = DomainException::class;
        $exceptionMessage =
            'Class [AlecRabbit\Spinner\Core\Loop\LoopManagerDummy] is not supposed to return any loop.'
            . ' Check your configuration.';

        $this->expectException($exception);
        $this->expectExceptionMessage($exceptionMessage);

        $loop = $loopFactory->getLoop();

        self::exceptionNotThrown($exception, $exceptionMessage);
    }
}
