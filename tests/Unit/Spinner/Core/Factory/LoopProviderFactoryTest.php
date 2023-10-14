<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopProviderFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopSetup;
use AlecRabbit\Spinner\Core\Loop\Factory\LoopProviderFactory;
use AlecRabbit\Spinner\Core\Loop\LoopProvider;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Tests\TestCase\TestCase;
use Exception;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class LoopProviderFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(LoopProviderFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?ILoopFactory $loopFactory = null,
        ?ILoopSetup $loopSetup = null,
        ?RunMethodMode $runMethodMode = null,
    ): ILoopProviderFactory {
        return
            new LoopProviderFactory(
                loopFactory: $loopFactory ?? $this->getLoopFactoryMock(),
                loopSetup: $loopSetup ?? $this->getLoopSetupMock(),
                runMethodMode: $runMethodMode ?? RunMethodMode::ASYNC,
            );
    }

    protected function getLoopFactoryMock(): MockObject&ILoopFactory
    {
        return $this->createMock(ILoopFactory::class);
    }

    private function getLoopSetupMock(): MockObject&ILoopSetup
    {
        return $this->createMock(ILoopSetup::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $loop = $this->getLoopMock();

        $loopFactory = $this->getLoopFactoryMock();
        $loopFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($loop)
        ;

        $loopSetup = $this->getLoopSetupMock();
        $loopSetup
            ->expects(self::once())
            ->method('setup')
            ->with(self::identicalTo($loop))
        ;


        $factory = $this->getTesteeInstance(
            loopFactory: $loopFactory,
            loopSetup: $loopSetup,
        );

        $loopProvider = $factory->create();

        self::assertInstanceOf(LoopProvider::class, $loopProvider);
        self::assertSame($loop, $loopProvider->getLoop());
    }

    protected function getLoopMock(): MockObject&ILoop
    {
        return $this->createMock(ILoop::class);
    }

    #[Test]
    public function canCreateWithNullLoop(): void
    {
        $loopFactory = $this->getLoopFactoryMock();
        $loopFactory
            ->expects(self::once())
            ->method('create')
            ->willThrowException(new Exception())
        ;

        $factory = $this->getTesteeInstance(
            loopFactory: $loopFactory,
        );

        $loopProvider = $factory->create();

        self::assertInstanceOf(LoopProvider::class, $loopProvider);
        self::assertNull(self::getPropertyValue('loop', $loopProvider));

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Loop is not set.');

        $loopProvider->getLoop();
    }

    #[Test]
    public function canCreateWithRunMethodModeSynchronous(): void
    {
        $factory = $this->getTesteeInstance(
            runMethodMode: RunMethodMode::SYNCHRONOUS,
        );

        $loopProvider = $factory->create();

        self::assertInstanceOf(LoopProvider::class, $loopProvider);
        self::assertNull(self::getPropertyValue('loop', $loopProvider));

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Loop is not set.');

        $loopProvider->getLoop();
    }
}
