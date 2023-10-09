<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Asynchronous\Factory;

use AlecRabbit\Spinner\Core\Contract\Loop\A\ALoopAdapter;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoopCreator;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\LoopFactory;
use AlecRabbit\Spinner\Exception\LoopException;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Spinner\Asynchronous\Factory\Stub\LoopCreatorStub;
use PHPUnit\Framework\Attributes\Test;

final class LoopFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $loopFactory = $this->getTesteeInstance();

        self::assertInstanceOf(LoopFactory::class, $loopFactory);
    }

    public function getTesteeInstance(
        ?string $loopCreator = 'invalid',
    ): ILoopFactory {
        return new LoopFactory(
            loopCreator: $loopCreator,
        );
    }

    #[Test]
    public function canCreate(): void
    {
        $loopCreator = LoopCreatorStub::class;

        $loopFactory = $this->getTesteeInstance(
            loopCreator: $loopCreator,
        );

        self::assertInstanceOf(ALoopAdapter::class, $loopFactory->create());
    }

    #[Test]
    public function throwsIfArgumentIsInvalid(): void
    {
        $loopCreator = \stdClass::class;

        $this->expectException(LoopException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Class "%s" must implement "%s" interface.',
                $loopCreator,
                ILoopCreator::class
            )
        );

        $loopFactory = $this->getTesteeInstance(
            loopCreator: $loopCreator,
        );

        self::assertInstanceOf(ALoopAdapter::class, $loopFactory->create());
        self::fail('Exception was not thrown.');
    }
}
