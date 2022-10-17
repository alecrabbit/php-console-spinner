<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\CharPattern;
use AlecRabbit\Spinner\Core\Contract\StylePattern;
use AlecRabbit\Spinner\Core\Defaults;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;

class DefaultsTest extends TestCase
{
    private const MIN_INTERVAL_MILLISECONDS = 0;
    private const MAX_INTERVAL_MILLISECONDS = 1000000;
    private const MODE_IS_SYNCHRONOUS = false;
    private const HIDE_CURSOR = true;
    private const SHUTDOWN_DELAY = 0.15;
    private const FINAL_MESSAGE = PHP_EOL;
    private const MESSAGE_ON_EXIT = 'Exiting... (CTRL+C to force)' . PHP_EOL;

    /** @test */
    public function canGetMinIntervalMilliseconds(): void
    {
        self::assertSame(self::MIN_INTERVAL_MILLISECONDS, Defaults::getMinIntervalMilliseconds());
    }

    /** @test */
    public function canSetMinIntervalMilliseconds(): void
    {
        $minIntervalMilliseconds = 10;
        Defaults::setMinIntervalMilliseconds($minIntervalMilliseconds);
        self::assertSame($minIntervalMilliseconds, Defaults::getMinIntervalMilliseconds());
    }

    /** @test */
    public function canGetMaxIntervalMilliseconds(): void
    {
        self::assertSame(self::MAX_INTERVAL_MILLISECONDS, Defaults::getMaxIntervalMilliseconds());
    }

    /** @test */
    public function canSetMaxIntervalMilliseconds(): void
    {
        $maxIntervalMilliseconds = 10;
        Defaults::setMaxIntervalMilliseconds($maxIntervalMilliseconds);
        self::assertSame($maxIntervalMilliseconds, Defaults::getMaxIntervalMilliseconds());
    }

    /** @test */
    public function canGetIsModeSynchronous(): void
    {
        self::assertSame(self::MODE_IS_SYNCHRONOUS, Defaults::isModeSynchronous());
    }

    /** @test */
    public function canSetModeAsSynchronous(): void
    {
        Defaults::setModeAsSynchronous(!self::MODE_IS_SYNCHRONOUS);
        self::assertSame(!self::MODE_IS_SYNCHRONOUS, Defaults::isModeSynchronous());
        Defaults::setModeAsSynchronous(self::MODE_IS_SYNCHRONOUS);
        self::assertSame(self::MODE_IS_SYNCHRONOUS, Defaults::isModeSynchronous());
    }

    /** @test */
    public function canGetHideCursor(): void
    {
        self::assertSame(self::HIDE_CURSOR, Defaults::getHideCursor());
    }

    /** @test */
    public function canSetHideCursor(): void
    {
        Defaults::setHideCursor(false);
        self::assertFalse(Defaults::getHideCursor());
    }

    /** @test */
    public function canGetShutdownDelay(): void
    {
        self::assertSame(self::SHUTDOWN_DELAY, Defaults::getShutdownDelay());
    }

    /** @test */
    public function canSetShutdownDelay(): void
    {
        $shutdownDelay = 10;
        Defaults::setShutdownDelay($shutdownDelay);
        self::assertSame($shutdownDelay, Defaults::getShutdownDelay());
    }

    /** @test */
    public function canGetDefaultCharPattern(): void
    {
        self::assertEquals(CharPattern::none(), Defaults::getDefaultCharPattern());
    }

    /** @test */
    public function canSetDefaultCharPattern(): void
    {
        $pattern = CharPattern::MOON_REVERSED;
        Defaults::setDefaultCharPattern($pattern);
        self::assertEquals($pattern, Defaults::getDefaultCharPattern());
    }

    /** @test */
    public function canDefaultStylePattern(): void
    {
        self::assertEquals(StylePattern::none(), Defaults::getDefaultStylePattern());
    }

    /** @test */
    public function canSetDefaultStylePattern(): void
    {
        $pattern = StylePattern::rainbow();
        Defaults::setDefaultStylePattern($pattern);
        self::assertEquals($pattern, Defaults::getDefaultStylePattern());
    }

    /** @test */
    public function canFinalMessage(): void
    {
        self::assertEquals(self::FINAL_MESSAGE, Defaults::getFinalMessage());
    }

    /** @test */
    public function canSetFinalMessage(): void
    {
        $message = 'test';
        Defaults::setFinalMessage($message);
        self::assertEquals($message, Defaults::getFinalMessage());
    }

    /** @test */
    public function canMessageOnExit(): void
    {
        self::assertEquals(self::MESSAGE_ON_EXIT, Defaults::getMessageOnExit());
    }

    /** @test */
    public function canSetMessageOnExit(): void
    {
        $message = 'test';
        Defaults::setMessageOnExit($message);
        self::assertEquals($message, Defaults::getMessageOnExit());
    }

    protected function setUp(): void
    {
        Defaults::reset();
    }

}
