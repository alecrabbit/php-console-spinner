<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Loop;

use AlecRabbit\Spinner\Core\Feature\Resolver\Contract\IAutoStartResolver;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopSetup;
use AlecRabbit\Spinner\Core\Loop\LoopSetup;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class LoopSetupTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $loopSetup = $this->getTesteeInstance();

        self::assertInstanceOf(LoopSetup::class, $loopSetup);
    }

    public function getTesteeInstance(
        ?IAutoStartResolver $autoStartResolver = null,
    ): ILoopSetup {
        return
            new LoopSetup(
                autoStartResolver: $autoStartResolver ?? $this->getAutoStartResolverMock(),
            );
    }

    private function getAutoStartResolverMock(): MockObject&IAutoStartResolver
    {
        return $this->createMock(IAutoStartResolver::class);
    }

    #[Test]
    public function canSetup(): void
    {
        $loop = $this->getLoopMock();
        $loop
            ->expects(self::once())
            ->method('autoStart')
        ;

        $autoStartResolver = $this->getAutoStartResolverMock();
        $autoStartResolver
            ->expects(self::once())
            ->method('isEnabled')
            ->willReturn(true)
        ;

        $loopSetup = $this->getTesteeInstance(
            autoStartResolver: $autoStartResolver,
        );

        $loopSetup->setup($loop);
    }

    protected function getLoopMock(): MockObject&ILoop
    {
        return $this->createMock(ILoop::class);
    }
}
