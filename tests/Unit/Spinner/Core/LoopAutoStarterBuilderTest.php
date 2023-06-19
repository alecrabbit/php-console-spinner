<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Builder\Contract\ILoopAutoStarterBuilder;
use AlecRabbit\Spinner\Core\Builder\LoopAutoStarterBuilder;
use AlecRabbit\Spinner\Core\LoopAutoStarter;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class LoopAutoStarterBuilderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $loopAutoStarterBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(LoopAutoStarterBuilder::class, $loopAutoStarterBuilder);
    }

    public function getTesteeInstance(): ILoopAutoStarterBuilder
    {
        return new LoopAutoStarterBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $loopAutoStarterBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(LoopAutoStarterBuilder::class, $loopAutoStarterBuilder);

        $loopAutoStarterBuilder = $loopAutoStarterBuilder
            ->withSettings($this->getLoopSettingsMock())
        ;

        self::assertInstanceOf(LoopAutoStarter::class, $loopAutoStarterBuilder->build());
    }

    #[Test]
    public function throwsIfLoopSettingsAreNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Loop settings are not set.';

        $test = function (): void {
            $loopAutoStarterBuilder = $this->getTesteeInstance();
            self::assertInstanceOf(LoopAutoStarterBuilder::class, $loopAutoStarterBuilder);
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
