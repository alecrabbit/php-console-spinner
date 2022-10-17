<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\CharPattern;
use AlecRabbit\Spinner\Core\Contract\StylePattern;
use AlecRabbit\Spinner\Core\Defaults;
use AlecRabbit\Spinner\Core\Frame\CharFrame;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;

use const AlecRabbit\Cli\ALLOWED_TERM_COLOR;

class DefaultsTest extends TestCase
{
    private const MIN_INTERVAL_MILLISECONDS = 0;
    private const MAX_INTERVAL_MILLISECONDS = 1000000;
    private const MODE_IS_SYNCHRONOUS = false;
    private const HIDE_CURSOR = true;
    private const SHUTDOWN_DELAY = 0.15;
    private const MAX_SHUTDOWN_DELAY = 10;
    private const FINAL_MESSAGE = PHP_EOL;
    private const MESSAGE_ON_EXIT = 'Exiting... (CTRL+C to force)' . PHP_EOL;
    private const INTERRUPT_MESSAGE = 'Interrupted!' . PHP_EOL;
    private const PROGRESS_FORMAT = '%0.1f%%';

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
    public function canGetDefaultStylePattern(): void
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
    public function canGetFinalMessage(): void
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
    public function canGetMessageOnExit(): void
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

    /** @test */
    public function canGetInterruptMessage(): void
    {
        self::assertEquals(self::INTERRUPT_MESSAGE, Defaults::getInterruptMessage());
    }

    /** @test */
    public function canSetInterruptMessage(): void
    {
        $message = 'test';
        Defaults::setInterruptMessage($message);
        self::assertEquals($message, Defaults::getInterruptMessage());
    }

    /** @test */
    public function canGetMaxShutdownDelay(): void
    {
        self::assertSame(self::MAX_SHUTDOWN_DELAY, Defaults::getMaxShutdownDelay());
    }

    /** @test */
    public function canSetMaxShutdownDelay(): void
    {
        $shutdownDelay = 10;
        Defaults::setMaxShutdownDelay($shutdownDelay);
        self::assertSame($shutdownDelay, Defaults::getMaxShutdownDelay());
    }

    /** @test */
    public function canGetColorSupportLevels(): void
    {
        self::assertEquals(ALLOWED_TERM_COLOR, Defaults::getColorSupportLevels());
    }

    /** @test */
    public function canSetColorSupportLevels(): void
    {
        $levels = [0];
        Defaults::setColorSupportLevels($levels);
        self::assertEquals($levels, Defaults::getColorSupportLevels());
    }

    /** @test */
    public function throwsOnEmptyColorSupportLevels(): void
    {
        $levels = [];
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Color support levels must not be empty.');
        Defaults::setColorSupportLevels($levels);
    }

    /** @test */
    public function throwsOnUnknownColorSupportLevels(): void
    {
        $levels = ['1'];
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Color support level "1" is not allowed. Allowed values are [0, 16, 255, 65535].'
        );
        Defaults::setColorSupportLevels($levels);
    }

    /** @test */
    public function canGetProgressFormat(): void
    {
        self::assertEquals(self::PROGRESS_FORMAT, Defaults::getProgressFormat());
    }

    /** @test */
    public function canSetProgressFormat(): void
    {
        $format = 'test';
        Defaults::setProgressFormat($format);
        self::assertEquals($format, Defaults::getProgressFormat());
    }

    /** @test */
    public function canGetSpinnerStylePattern(): void
    {
        self::assertEquals(StylePattern::rainbow(), Defaults::getSpinnerStylePattern());
    }

    /** @test */
    public function canSetSpinnerStylePattern(): void
    {
        $pattern = StylePattern::none();
        Defaults::setSpinnerStylePattern($pattern);
        self::assertEquals($pattern, Defaults::getSpinnerStylePattern());
    }

    /** @test */
    public function canGetSpinnerCharPattern(): void
    {
        self::assertEquals(CharPattern::SNAKE_VARIANT_0, Defaults::getSpinnerCharPattern());
    }

    /** @test */
    public function canSetSpinnerCharPattern(): void
    {
        $pattern = CharPattern::none();
        Defaults::setSpinnerCharPattern($pattern);
        self::assertEquals($pattern, Defaults::getSpinnerCharPattern());
    }

    /** @test */
    public function canGetSpinnerTrailingSpacer(): void
    {
        self::assertEquals(CharFrame::createSpace(), Defaults::getSpinnerTrailingSpacer());
    }

    /** @test */
    public function canSetSpinnerTrailingSpacer(): void
    {
        $spacer = CharFrame::createEmpty();
        Defaults::setSpinnerTrailingSpacer($spacer);
        self::assertEquals($spacer, Defaults::getSpinnerTrailingSpacer());
    }

    protected function setUp(): void
    {
        Defaults::reset();
    }

}
