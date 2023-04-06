<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ILoopSetupBuilder;
use AlecRabbit\Spinner\Core\LoopSetup;
use AlecRabbit\Spinner\Core\LoopSetupBuilder;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;


final class LoopSetupBuilderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $loopSetupBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(LoopSetupBuilder::class, $loopSetupBuilder);
    }

    public function getTesteeInstance(): ILoopSetupBuilder
    {
        return
            new LoopSetupBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $loopSetupBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(LoopSetupBuilder::class, $loopSetupBuilder);

        $loopSetupBuilder = $loopSetupBuilder
            ->withLoop($this->getLoopMock())
            ->withConfig($this->getLoopConfigStub())
        ;

        self::assertInstanceOf(LoopSetup::class, $loopSetupBuilder->build());
    }

    #[Test]
    public function throwsIfLoopIsNotSet(): void
    {
        $loopSetupBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(LoopSetupBuilder::class, $loopSetupBuilder);

        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Loop is not set.';
        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $loopSetupBuilder->build();

        self::fail(self::exceptionNotThrownString($exceptionClass, $exceptionMessage));
    }

    #[Test]
    public function throwsIfConfigIsNotSet(): void
    {
        $loopSetupBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(LoopSetupBuilder::class, $loopSetupBuilder);

        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Loop config is not set.';
        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $loopSetupBuilder
            ->withLoop($this->getLoopMock())
            ->build()
        ;

        self::fail(self::exceptionNotThrownString($exceptionClass, $exceptionMessage));
    }
}
