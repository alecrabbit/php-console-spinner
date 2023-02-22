<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Config\Defaults\A;

use AlecRabbit\Spinner\Config\Defaults\A\ADefaults;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\Loop\ReactLoopProbe;
use AlecRabbit\Spinner\Core\Loop\RevoltLoopProbe;
use AlecRabbit\Spinner\Core\Widget\WidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\WidgetRevolverBuilder;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;

use const AlecRabbit\Cli\TERM_NOCOLOR;

final class ADefaultsTest extends TestCase
{
    /** @test */
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

    /** @test */
    public function canSetHideCursor(): void
    {
        $defaults = self::getInstance();
        $defaults->setHideCursor(false);
        self::assertFalse($defaults->isHideCursor());
    }

    /** @test */
    public function canSetShutdownDelay(): void
    {
        $shutdownDelay = 10;
        $defaults = self::getInstance();
        $defaults->setShutdownDelay($shutdownDelay);
        self::assertSame($shutdownDelay, $defaults->getShutdownDelay());
    }

    /** @test */
    public function canSetFinalMessage(): void
    {
        $message = 'test';
        $defaults = self::getInstance();
        $defaults->setFinalMessage($message);
        self::assertSame($message, $defaults->getFinalMessage());
    }

    /** @test */
    public function canSetOutputStream(): void
    {
        $stream = STDOUT;
        $defaults = self::getInstance();
        $defaults->setOutputStream($stream);
        self::assertSame($stream, $defaults->getOutputStream());
    }

    /** @test */
    public function canSetLoopProbes(): void
    {
        $defaults = self::getInstance();
        $loopProbes = [
            RevoltLoopProbe::class,
            ReactLoopProbe::class,
        ];
        $defaults->setLoopProbes(
            $loopProbes
        );
        $loopProbesCount = 0;
        foreach ($defaults->getLoopProbeClasses() as $loopProbe) {
            self::assertContains($loopProbe, $loopProbes);
            $loopProbesCount++;
        }
        self::assertEquals(count($loopProbes), $loopProbesCount);
    }

    /** @test */
    public function canGetClasses(): void
    {
        $defaults = self::getInstance();
        self::assertSame(WidgetBuilder::class, $defaults->getClasses()->getWidgetBuilderClass());
        self::assertSame(WidgetRevolverBuilder::class, $defaults->getClasses()->getWidgetRevolverBuilderClass());
    }

    /** @test */
    public function setOutputStreamThrowsOnInvalidArgument(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument is expected to be a stream(resource), "string" given.');

        $stream = 'string';
        $defaults = self::getInstance();
        $defaults->setOutputStream($stream);
        self::assertSame($stream, $defaults->getOutputStream());
    }

    /** @test */
    public function canSetMillisecondsInterval(): void
    {
        $millisecondsInterval = 10;
        $defaults = self::getInstance();
        $defaults->setIntervalMilliseconds($millisecondsInterval);
        self::assertSame($millisecondsInterval, $defaults->getIntervalMilliseconds());
    }

    /** @test */
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

    /** @test */
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

    /** @test */
    public function defaultAndMainLeadingSpacersAreSame(): void
    {
        $defaults = self::getInstance();
        self::assertSame($defaults->getDefaultLeadingSpacer(), $defaults->getMainLeadingSpacer());
    }

    /** @test */
    public function canSetMainLeadingSpacer(): void
    {
        $defaults = self::getInstance();

        $spacer = new Frame('test', 4);
        $defaults->setMainLeadingSpacer($spacer);
        self::assertSame($spacer, $defaults->getMainLeadingSpacer());
    }

    /** @test */
    public function defaultAndMainTrailingSpacersAreSame(): void
    {
        $defaults = self::getInstance();
        self::assertSame($defaults->getDefaultTrailingSpacer(), $defaults->getMainTrailingSpacer());
    }

    /** @test */
    public function canSetMainTrailingSpacer(): void
    {
        $defaults = self::getInstance();

        $spacer = new Frame('test', 4);
        $defaults->setMainTrailingSpacer($spacer);
        self::assertSame($spacer, $defaults->getMainTrailingSpacer());
    }

    /** @test */
    public function canSetPercentNumberFormat(): void
    {
        $defaults = self::getInstance();
        $defaults->setPercentNumberFormat('%.2f');
        self::assertSame('%.2f', $defaults->getPercentNumberFormat());
    }

    /** @test */
    public function canSetMessageOnExit(): void
    {
        $defaults = self::getInstance();
        $defaults->setMessageOnExit('test');
        self::assertSame('test', $defaults->getMessageOnExit());
    }

    /** @test */
    public function canSetInterruptMessage(): void
    {
        $defaults = self::getInstance();
        $defaults->setInterruptMessage('test');
        self::assertSame('test', $defaults->getInterruptMessage());
    }

    /** @test */
    public function canSetMaxShutdownDelay(): void
    {
        $defaults = self::getInstance();
        $defaults->setMaxShutdownDelay(10);
        self::assertSame(10, $defaults->getMaxShutdownDelay());
    }

    /** @test */
    public function canSetColorSupportLevels(): void
    {
        $defaults = self::getInstance();
        $colorSupportLevels = [TERM_NOCOLOR];
        $defaults->setColorSupportLevels($colorSupportLevels);
        self::assertSame($colorSupportLevels, $defaults->getColorSupportLevels());
    }

    /** @test */
    public function etColorSupportLevelsThrowsOnInvalidArgument(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Color support levels must not be empty.');

        $defaults = self::getInstance();
        $defaults->setColorSupportLevels([]);
        self::assertSame(10, $defaults->getColorSupportLevels());
    }

    protected function setUp(): void
    {
        self::getInstance()->reset();
    }
}
