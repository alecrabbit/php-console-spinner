<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Factory\Contract\IFrameFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\RevolverFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Tests\Spinner\TestCase\TestCaseWithPrebuiltMocks;
use PHPUnit\Framework\Attributes\Test;

final class RevolverFactoryTest extends TestCaseWithPrebuiltMocks
{
    #[Test]
    public function canBeCreated(): void
    {
        $revolverFactory = $this->getTesteeInstance();

        self::assertInstanceOf(RevolverFactory::class, $revolverFactory);
    }

    public function getTesteeInstance(
        ?IFrameRevolverBuilder $frameRevolverBuilder = null,
        ?IFrameFactory $frameFactory = null,
    ): IRevolverFactory {
        return
            new RevolverFactory(
                frameRevolverBuilder: $frameRevolverBuilder ?? $this->getFrameRevolverBuilderMock(),
                frameFactory: $frameFactory ?? $this->getFrameFactoryMock(),
            );
    }

    #[Test]
    public function canCreateRevolver(): void
    {
        $frameRevolverBuilder = $this->createMock(IFrameRevolverBuilder::class);

        $frameRevolverBuilder->method('build')->willReturn($this->createMock(IFrameRevolver::class));

        $frameRevolverBuilder
            ->expects(self::once())
            ->method('withPattern')
            ->willReturn($frameRevolverBuilder);

        $revolverFactory = $this->getTesteeInstance(frameRevolverBuilder: $frameRevolverBuilder);

        $revolver = $revolverFactory->create($this->getPatternMock());

        self::assertInstanceOf(IFrameRevolver::class, $revolver);
    }

}
