<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\Factory\Contract\IRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\RevolverFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Tests\Spinner\TestCase\TestCaseWithPrebuiltMocks;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class RevolverFactoryTest extends TestCaseWithPrebuiltMocks
{
    #[Test]
    public function canBeCreated(): void
    {
        $revolverFactory = $this->getTesteeInstance(container: null);

        self::assertInstanceOf(RevolverFactory::class, $revolverFactory);
    }

    public function getTesteeInstance(
        (MockObject&IContainer)|null $container,
    ): IRevolverFactory {
        return
            new RevolverFactory(
                container: $container ?? $this->getContainerMock(),
            );
    }

    #[Test]
    public function canCreateRevolver(): void
    {
        $container = $this->createMock(IContainer::class);

        $frameRevolverBuilder = $this->createMock(IFrameRevolverBuilder::class);

        $frameRevolverBuilder->method('build')->willReturn($this->createMock(IFrameRevolver::class));

        $frameRevolverBuilder
            ->expects(self::once())
            ->method('withPattern')
            ->willReturn($frameRevolverBuilder)
        ;

        $container
            ->method('get')
            ->willReturn($frameRevolverBuilder)
        ;

        $revolverFactory = $this->getTesteeInstance(container: $container);

        $revolver = $revolverFactory->create($this->getPatternMock());

        self::assertInstanceOf(IFrameRevolver::class, $revolver);
    }
}
