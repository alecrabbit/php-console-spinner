<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Factory;

use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSetupFactory;
use AlecRabbit\Spinner\Core\Feature\Resolver\Contract\IAutoStartResolver;
use AlecRabbit\Spinner\Core\Loop\Factory\LoopSetupFactory;
use AlecRabbit\Spinner\Core\Loop\LoopSetup;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class LoopSetupFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(LoopSetupFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IAutoStartResolver $autoStartResolver = null,
    ): ILoopSetupFactory {
        return
            new LoopSetupFactory(
                autoStartResolver: $autoStartResolver ?? $this->getAutoStartResolverMock(),
            );
    }

    private function getAutoStartResolverMock(): MockObject&IAutoStartResolver
    {
        return $this->createMock(IAutoStartResolver::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $autoStartResolver = $this->getAutoStartResolverMock();

        $factory = $this->getTesteeInstance($autoStartResolver);

        $loopSetup = $factory->create();

        self::assertInstanceOf(LoopSetup::class, $loopSetup);
    }
}
