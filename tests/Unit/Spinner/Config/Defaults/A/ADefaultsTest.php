<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Config\Defaults\A;

use AlecRabbit\Spinner\Asynchronous\Loop\Probe\ReactLoopProbe;
use AlecRabbit\Spinner\Asynchronous\Loop\Probe\RevoltLoopProbe;
use AlecRabbit\Spinner\Contract\ColorMode;
use AlecRabbit\Spinner\Core\Defaults\A\ADefaults;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Widget\WidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\WidgetRevolverBuilder;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class ADefaultsTest extends TestCase
{
    #[Test]
    public function sameInstanceEverytime(): void
    {
        $iterations = self::REPEATS;

        $defaults = self::getInstance();

        for ($i = 0; $i < $iterations; $i++) {
            self::assertSame($defaults, self::getInstance());
        }
    }

    private static function getInstance(): ADefaults
    {
        return ADefaults::getInstance();
    }

//    #[Test]
//    public function canSetHideCursor(): void
//    {
//        $defaults = self::getInstance();
//        $defaults->setHideCursor(false);
//        self::assertFalse($defaults->isHideCursor());
//    }

    #[Test]
    public function canSetShutdownDelay(): void
    {
        $shutdownDelay = 10;
        $defaults = self::getInstance();
        $defaults->setShutdownDelay($shutdownDelay);
        self::assertSame($shutdownDelay, $defaults->getShutdownDelay());
    }

    #[Test]
    public function canSetFinalMessage(): void
    {
        $message = 'test';
        $defaults = self::getInstance();
        $defaults->setFinalMessage($message);
        self::assertSame($message, $defaults->getFinalMessage());
    }

    #[Test]
    public function canSetOutputStream(): void
    {
        $stream = STDOUT;
        $defaults = self::getInstance();
        $defaults->setOutputStream($stream);
        self::assertSame($stream, $defaults->getOutputStream());
    }

    #[Test]
    public function canSetLoopProbes(): void
    {
        $defaults = self::getInstance();
        $loopProbes = [
            RevoltLoopProbe::class,
            ReactLoopProbe::class,
        ];
        $defaults->setLoopProbeClasses(
            $loopProbes
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
        $defaults = self::getInstance();
        self::assertSame(WidgetBuilder::class, $defaults->getClasses()->getWidgetBuilderClass());
        self::assertSame(WidgetRevolverBuilder::class, $defaults->getClasses()->getWidgetRevolverBuilderClass());
    }

    #[Test]
    public function setOutputStreamThrowsOnInvalidArgument(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument is expected to be a stream(resource), "string" given.');

        $stream = 'string';
        $defaults = self::getInstance();
        $defaults->setOutputStream($stream);
        self::assertSame($stream, $defaults->getOutputStream());
    }

    #[Test]
    public function canSetMillisecondsInterval(): void
    {
        $millisecondsInterval = 10;
        $defaults = self::getInstance();
        $defaults->setIntervalMilliseconds($millisecondsInterval);
        self::assertSame($millisecondsInterval, $defaults->getIntervalMilliseconds());
    }

    #[Test]
    public function canSetCreateInitialized(): void
    {
        $defaults = self::getInstance();
        $defaults->setCreateInitialized(true);
        self::assertTrue($defaults->isCreateInitialized());
        $defaults->setCreateInitialized(false);
        self::assertFalse($defaults->isCreateInitialized());
        $defaults->setCreateInitialized(true);
        self::assertTrue($defaults->isCreateInitialized());
    }

    #[Test]
    public function canSetModeAsSynchronous(): void
    {
        $defaults = self::getInstance();
        $defaults->setModeAsSynchronous(true);
        self::assertTrue($defaults->isModeSynchronous());
        $defaults->setModeAsSynchronous(false);
        self::assertFalse($defaults->isModeSynchronous());
        $defaults->setModeAsSynchronous(true);
        self::assertTrue($defaults->isModeSynchronous());
    }

    #[Test]
    public function defaultAndMainLeadingSpacersAreSame(): void
    {
        $defaults = self::getInstance();
        self::assertSame($defaults->getDefaultLeadingSpacer(), $defaults->getMainLeadingSpacer());
    }

    #[Test]
    public function canSetMainLeadingSpacer(): void
    {
        $defaults = self::getInstance();

        $spacer = FrameFactory::create('test', 4);
        $defaults->setMainLeadingSpacer($spacer);
        self::assertSame($spacer, $defaults->getMainLeadingSpacer());
    }

    #[Test]
    public function defaultAndMainTrailingSpacersAreSame(): void
    {
        $defaults = self::getInstance();
        self::assertSame($defaults->getDefaultTrailingSpacer(), $defaults->getMainTrailingSpacer());
    }

    #[Test]
    public function canSetMainTrailingSpacer(): void
    {
        $defaults = self::getInstance();

        $spacer = FrameFactory::create('test', 4);
        $defaults->setMainTrailingSpacer($spacer);
        self::assertSame($spacer, $defaults->getMainTrailingSpacer());
    }

    #[Test]
    public function canSetPercentNumberFormat(): void
    {
        $defaults = self::getInstance();
        $defaults->setPercentNumberFormat('%.2f');
        self::assertSame('%.2f', $defaults->getPercentNumberFormat());
    }

    #[Test]
    public function canSetMessageOnExit(): void
    {
        $defaults = self::getInstance();
        $defaults->setMessageOnExit('test');
        self::assertSame('test', $defaults->getMessageOnExit());
    }

    #[Test]
    public function canSetInterruptMessage(): void
    {
        $defaults = self::getInstance();
        $defaults->setInterruptMessage('test');
        self::assertSame('test', $defaults->getInterruptMessage());
    }

    #[Test]
    public function canSetMaxShutdownDelay(): void
    {
        $defaults = self::getInstance();
        $defaults->setMaxShutdownDelay(10);
        self::assertSame(10, $defaults->getMaxShutdownDelay());
    }

    #[Test]
    public function canSetSupportedColorModes(): void
    {
        $defaults = self::getInstance();
        $colorSupportLevels = [ColorMode::ANSI24];
        $defaults->setSupportedColorModes($colorSupportLevels);
        self::assertSame($colorSupportLevels, $defaults->getSupportedColorModes());
    }

    #[Test]
    public function setSupportedColorModesThrowsOnInvalidArgument(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Color modes must not be empty.');

        $defaults = self::getInstance();
        $defaults->setSupportedColorModes([]);
        self::assertSame(10, $defaults->getSupportedColorModes());
    }

    protected function setUp(): void
    {
        self::callMethod(self::getInstance(), 'reset');
    }
}
