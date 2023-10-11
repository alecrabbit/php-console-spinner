<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Legacy\ILegacyLoopAutoStarterBuilder;
use AlecRabbit\Spinner\Core\Legacy\LegacyLoopAutoStarter;
use AlecRabbit\Spinner\Core\Legacy\LegacyLoopAutoStarterBuilder;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class LoopAutoStarterBuilderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $loopAutoStarterBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(LegacyLoopAutoStarterBuilder::class, $loopAutoStarterBuilder);
    }

    public function getTesteeInstance(): ILegacyLoopAutoStarterBuilder
    {
        return new LegacyLoopAutoStarterBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $loopAutoStarterBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(LegacyLoopAutoStarterBuilder::class, $loopAutoStarterBuilder);

        $loopAutoStarterBuilder = $loopAutoStarterBuilder
            ->withSettings($this->getLegacyLoopSettingsMock())
        ;

        self::assertInstanceOf(LegacyLoopAutoStarter::class, $loopAutoStarterBuilder->build());
    }

    #[Test]
    public function throwsIfLoopSettingsAreNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Loop settings are not set.';

        $test = function (): void {
            $loopAutoStarterBuilder = $this->getTesteeInstance();
            self::assertInstanceOf(LegacyLoopAutoStarterBuilder::class, $loopAutoStarterBuilder);
            $loopAutoStarterBuilder
                ->build()
            ;
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }
}
