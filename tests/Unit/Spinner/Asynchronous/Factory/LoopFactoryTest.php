<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Asynchronous\Factory;

use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\A\ALoopAdapter;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopCreator;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopCreatorClassProvider;
use AlecRabbit\Spinner\Core\Loop\Factory\LoopFactory;
use AlecRabbit\Spinner\Exception\LoopException;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Spinner\Asynchronous\Stub\LoopCreatorStub;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use stdClass;

final class LoopFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $loopFactory = $this->getTesteeInstance();

        self::assertInstanceOf(LoopFactory::class, $loopFactory);
    }

    public function getTesteeInstance(
        ?ILoopCreatorClassProvider $LoopClassProvider = null,
    ): ILoopFactory {
        return new LoopFactory(
            classProvider: $LoopClassProvider ?? $this->getLoopCreatorClassProviderMock(),
        );
    }

    private function getLoopCreatorClassProviderMock(): MockObject&ILoopCreatorClassProvider
    {
        return $this->createMock(ILoopCreatorClassProvider::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $classProvider = $this->getLoopCreatorClassProviderMock();
        $classProvider
            ->expects(self::once())
            ->method('getCreatorClass')
            ->willReturn(LoopCreatorStub::class)
        ;
        $loopFactory = $this->getTesteeInstance(
            LoopClassProvider: $classProvider,
        );

        self::assertInstanceOf(ALoopAdapter::class, $loopFactory->create());
    }

    #[Test]
    public function throwsIfClassReturnedByProviderIsInvalid(): void
    {
        $loopCreator = stdClass::class;

        $this->expectException(LoopException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Class "%s" must implement "%s" interface.',
                $loopCreator,
                ILoopCreator::class
            )
        );

        $classProvider = $this->getLoopCreatorClassProviderMock();
        $classProvider
            ->expects(self::once())
            ->method('getCreatorClass')
            ->willReturn($loopCreator)
        ;

        $loopFactory = $this->getTesteeInstance(
            LoopClassProvider: $classProvider,
        );

        self::assertInstanceOf(ALoopAdapter::class, $loopFactory->create());
        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwsIfProviderReturnsNull(): void
    {
        $loopCreator = null;

        $this->expectException(LoopException::class);
        $this->expectExceptionMessage('Loop creator class is not provided.');

        $classProvider = $this->getLoopCreatorClassProviderMock();
        $classProvider
            ->expects(self::once())
            ->method('getCreatorClass')
            ->willReturn($loopCreator)
        ;

        $loopFactory = $this->getTesteeInstance(
            LoopClassProvider: $classProvider,
        );

        self::assertInstanceOf(ALoopAdapter::class, $loopFactory->create());
        self::fail('Exception was not thrown.');
    }
}
