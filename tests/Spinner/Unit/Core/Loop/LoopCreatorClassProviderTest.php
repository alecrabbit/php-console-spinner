<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Loop;

use AlecRabbit\Spinner\Asynchronous\Revolt\RevoltLoopCreator;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopCreator;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopCreatorClassProvider;
use AlecRabbit\Spinner\Core\Loop\LoopCreatorClassProvider;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use stdClass;

final class LoopCreatorClassProviderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $provider = $this->getTesteeInstance();

        self::assertInstanceOf(LoopCreatorClassProvider::class, $provider);
    }

    public function getTesteeInstance(
        ?string $creatorClass = null,
    ): ILoopCreatorClassProvider {
        return
            new LoopCreatorClassProvider(
                creatorClass: $creatorClass
            );
    }

    #[Test]
    public function canGetNullCreatorClass(): void
    {
        $provider = $this->getTesteeInstance();

        self::assertNull($provider->getCreatorClass());
    }

    #[Test]
    public function canGetCreatorClass(): void
    {
        $creatorClass = RevoltLoopCreator::class;

        $provider = $this->getTesteeInstance(
            creatorClass: $creatorClass
        );

        self::assertSame($creatorClass, $provider->getCreatorClass());
    }

    #[Test]
    public function throwsIfCreatorClassIsInvalid(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            sprintf(
                'Creator class must be of "%s" interface.',
                ILoopCreator::class
            )
        );

        $creatorClass = stdClass::class;

        $provider = $this->getTesteeInstance(
            creatorClass: $creatorClass
        );

        self::assertSame($creatorClass, $provider->getCreatorClass());

        self::fail('Exception was not thrown.');
    }
}
