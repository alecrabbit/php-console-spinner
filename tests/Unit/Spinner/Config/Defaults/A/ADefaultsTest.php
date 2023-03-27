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

    #[Test]
    public function canSetShutdownDelay(): void
    {
        $shutdownDelay = 10;
        $defaults = self::getTesteeInstance();
        $defaults->setShutdownDelay($shutdownDelay);
        self::assertSame($shutdownDelay, $defaults->getShutdownDelay());
    }

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

    #[Test]
    public function canSetPercentNumberFormat(): void
    {
        $defaults = self::getTesteeInstance();
        $defaults->setPercentNumberFormat('%.2f');
        self::assertSame('%.2f', $defaults->getPercentNumberFormat());
    }

    #[Test]
    public function canSetMaxShutdownDelay(): void
    {
        $defaults = self::getTesteeInstance();
        $defaults->setMaxShutdownDelay(10);
        self::assertSame(10, $defaults->getMaxShutdownDelay());
    }

    protected function setUp(): void
    {
        self::callMethod(self::getTesteeInstance(), 'reset');
    }
}
