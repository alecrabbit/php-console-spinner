<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Config\Defaults\A;

use AlecRabbit\Spinner\Asynchronous\Loop\Probe\ReactLoopProbe;
use AlecRabbit\Spinner\Asynchronous\Loop\Probe\RevoltLoopProbe;
use AlecRabbit\Spinner\Contract\RunMode;
use AlecRabbit\Spinner\Core\Defaults\A\ADefaults;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Widget\WidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\WidgetRevolverBuilder;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use ArrayObject;
use PHPUnit\Framework\Attributes\Test;

final class ADefaultsTest extends TestCase
{
    #[Test]
    public function sameInstanceEverytime(): void
    {
        $iterations = self::REPEATS;

        $defaults = self::getTesteeInstance();

        for ($i = 0; $i < $iterations; $i++) {
            self::assertSame($defaults, self::getTesteeInstance());
        }
    }

    private static function getTesteeInstance(): IDefaults
    {
        return ADefaults::getInstance();
    }

//    #[Test]
//    public function canSetHideCursor(): void
//    {
//        $defaults = self::getTesteeInstance();
//        $defaults->setHideCursor(false);
//        self::assertFalse($defaults->isHideCursor());
//    }

    #[Test]
    public function canSetShutdownDelay(): void
    {
        $shutdownDelay = 10;
        $defaults = self::getTesteeInstance();
        $defaults->setShutdownDelay($shutdownDelay);
        self::assertSame($shutdownDelay, $defaults->getShutdownDelay());
    }
//
//    #[Test]
//    public function canSetFinalMessage(): void
//    {
//        $message = 'test';
//        $defaults = self::getTesteeInstance();
//        $defaults->setFinalMessage($message);
//        self::assertSame($message, $defaults->getFinalMessage());
//    }

    #[Test]
    public function canSetOutputStream(): void
    {
        $stream = STDOUT;
        $defaults = self::getTesteeInstance();
        $defaults->setOutputStream($stream);
        self::assertSame($stream, $defaults->getOutputStream());
    }

    #[Test]
    public function canOverrideLoopProbes(): void
    {
        $defaults = self::getTesteeInstance();
        $loopProbes = [
            RevoltLoopProbe::class,
            ReactLoopProbe::class,
        ];
        $defaults->overrideLoopProbeClasses(
            new ArrayObject($loopProbes)
        );
        $loopProbesCount = 0;
        foreach ($defaults->getProbeClasses() as $loopProbe) {
            self::assertContains($loopProbe, $loopProbes);
            $loopProbesCount++;
        }
        self::assertEquals(count($loopProbes), $loopProbesCount);
    }

    #[Test]
    public function canGetClasses(): void
    {
        $defaults = self::getTesteeInstance();
        self::assertSame(WidgetBuilder::class, $defaults->getClasses()->getWidgetBuilderClass());
        self::assertSame(WidgetRevolverBuilder::class, $defaults->getClasses()->getWidgetRevolverBuilderClass());
    }

    #[Test]
    public function setOutputStreamThrowsOnInvalidArgument(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument is expected to be a stream(resource), "string" given.');

        $stream = 'string';
        $defaults = self::getTesteeInstance();
        $defaults->setOutputStream($stream);
        self::assertSame($stream, $defaults->getOutputStream());
    }

//    #[Test]
//    public function canSetMillisecondsInterval(): void
//    {
//        $millisecondsInterval = 10;
//        $defaults = self::getTesteeInstance();
//        $defaults->setIntervalMilliseconds($millisecondsInterval);
//        self::assertSame($millisecondsInterval, $defaults->getIntervalMilliseconds());
//    }

//    #[Test]
//    public function canSetCreateInitialized(): void
//    {
//        $defaults = self::getTesteeInstance();
//        $defaults->overrideInitializationOption(Initialization::ENABLED);
//        self::assertSame(Initialization::ENABLED, $defaults->getInitializationOption());
//        $defaults->overrideInitializationOption(Initialization::DISABLED);
//        self::assertSame(Initialization::DISABLED, $defaults->getInitializationOption());
//        $defaults->overrideInitializationOption(Initialization::ENABLED);
//        self::assertSame(Initialization::ENABLED, $defaults->getInitializationOption());
//    }

    #[Test]
    public function canOverrideRunMode(): void
    {
        $defaults = self::getTesteeInstance();
        $defaults->overrideRunMode(RunMode::SYNCHRONOUS);
        self::assertTrue($defaults->isModeSynchronous());
        $defaults->overrideRunMode(RunMode::ASYNC);
        self::assertFalse($defaults->isModeSynchronous());
        $defaults->overrideRunMode(RunMode::SYNCHRONOUS);
        self::assertTrue($defaults->isModeSynchronous());
    }

//    #[Test]
//    public function defaultAndMainLeadingSpacersAreSame(): void
//    {
//        $defaults = self::getTesteeInstance();
//        self::assertSame($defaults->getDefaultLeadingSpacer(), $defaults->getMainLeadingSpacer());
//    }
//
//    #[Test]
//    public function canSetMainLeadingSpacer(): void
//    {
//        $defaults = self::getTesteeInstance();
//
//        $spacer = FrameFactory::create('test', 4);
//        $defaults->setMainLeadingSpacer($spacer);
//        self::assertSame($spacer, $defaults->getMainLeadingSpacer());
//    }

//    #[Test]
//    public function defaultAndMainTrailingSpacersAreSame(): void
//    {
//        $defaults = self::getTesteeInstance();
//        self::assertSame($defaults->getDefaultTrailingSpacer(), $defaults->getMainTrailingSpacer());
//    }
//
//    #[Test]
//    public function canSetMainTrailingSpacer(): void
//    {
//        $defaults = self::getTesteeInstance();
//
//        $spacer = FrameFactory::create('test', 4);
//        $defaults->setMainTrailingSpacer($spacer);
//        self::assertSame($spacer, $defaults->getMainTrailingSpacer());
//    }

    #[Test]
    public function canSetPercentNumberFormat(): void
    {
        $defaults = self::getTesteeInstance();
        $defaults->setPercentNumberFormat('%.2f');
        self::assertSame('%.2f', $defaults->getPercentNumberFormat());
    }
//
//    #[Test]
//    public function canSetMessageOnExit(): void
//    {
//        $defaults = self::getTesteeInstance();
//        $defaults->setMessageOnExit('test');
//        self::assertSame('test', $defaults->getMessageOnExit());
//    }

//    #[Test]
//    public function canSetInterruptMessage(): void
//    {
//        $defaults = self::getTesteeInstance();
//        $defaults->setInterruptMessage('test');
//        self::assertSame('test', $defaults->getInterruptMessage());
//    }

    #[Test]
    public function canSetMaxShutdownDelay(): void
    {
        $defaults = self::getTesteeInstance();
        $defaults->setMaxShutdownDelay(10);
        self::assertSame(10, $defaults->getMaxShutdownDelay());
    }
//
//    #[Test]
//    public function canSetSupportedColorModes(): void
//    {
//        $defaults = self::getTesteeInstance();
//        $colorSupportLevels = new \ArrayObject([ColorMode::ANSI24]);
//        $defaults->overrideSupportedColorModes($colorSupportLevels);
//        self::assertSame($colorSupportLevels, $defaults->getSupportedColorModes());
//    }
//
//    #[Test]
//    public function setSupportedColorModesThrowsOnInvalidArgument(): void
//    {
//        $exception = InvalidArgumentException::class;
//        $this->expectException($exception);
//        $this->expectExceptionMessage('Color modes must not be empty.');
//
//        $defaults = self::getTesteeInstance();
//        $defaults->overrideSupportedColorModes(new \ArrayObject([]));
//        self::assertSame(10, $defaults->getSupportedColorModes());
//        self::exceptionNotThrown($exception);
//    }

    protected function setUp(): void
    {
        self::callMethod(self::getTesteeInstance(), 'reset');
    }
}
