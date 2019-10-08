<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Tools;

use AlecRabbit\Spinner\Core\Contracts\Frames;
use AlecRabbit\Spinner\Core\Contracts\Juggler;
use AlecRabbit\Spinner\Core\Contracts\Styles;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use AlecRabbit\Spinner\Settings\Settings;
use PHPUnit\Framework\TestCase;

class SettingsTest extends TestCase
{
    protected const PROCESSING = 'Processing';
    protected const PROCESSING_LENGTH = 10;
    protected const COMPUTING = 'Computing';
    protected const COMPUTING_LENGTH = 9;
    protected const MB_STRING_1 = 'ᚹädm漢字';
    protected const MB_STRING_1_LENGTH = 8;

    /** @test */
    public function instance(): void
    {
        $settings = new Settings();
        $this->assertInstanceOf(Settings::class, $settings);
        $this->assertEquals(Defaults::EMPTY_STRING, $settings->getMessage());
        $this->assertEquals(0.1, $settings->getInterval());
        $this->assertTrue($settings->isEnabled());
        $this->assertEquals(Defaults::ONE_SPACE_SYMBOL, $settings->getInlineSpacer());

        $this->assertEquals(Defaults::DEFAULT_SUFFIX, $settings->getMessageSuffix());
        $this->assertEquals(Styles::STYLING_DISABLED, $settings->getStyles());
        $this->assertEquals(Defaults::DEFAULT_FRAMES, $settings->getFrames());
        $this->assertEquals(Defaults::EMPTY_STRING, $settings->getSpacer());
//        $this->assertEquals(0, $settings->getMessageErasingLength());

        $settings->setMessage(Defaults::EMPTY_STRING);
        $this->assertEquals(Defaults::EMPTY_STRING, $settings->getMessage());
//        $this->assertEquals(0, $settings->getMessageErasingLength());
        $settings->setMessage(self::PROCESSING);
        $this->assertEquals(self::PROCESSING, $settings->getMessage());
//        $this->assertEquals(self::PROCESSING_LENGTH, $settings->getMessageErasingLength());
        $settings->setMessage(self::COMPUTING);
        $this->assertEquals(self::COMPUTING, $settings->getMessage());
//        $this->assertEquals(self::COMPUTING_LENGTH, $settings->getMessageErasingLength());
        $settings->setMessage(self::MB_STRING_1);
        $this->assertEquals(self::MB_STRING_1, $settings->getMessage());
//        $this->assertEquals(self::MB_STRING_1_LENGTH, $settings->getMessageErasingLength());
        $settings->setEnabled(false);
        $this->assertFalse($settings->isEnabled());
        $settings->setHideCursor(false);
        $this->assertFalse($settings->isHideCursor());
        $settings->setHideCursor();
        $this->assertTrue($settings->isHideCursor());
    }

    /** @test */
    public function mergeEmpty(): void
    {
        $settings = new Settings();
        $newSettings = new Settings();
        $settings->merge($newSettings);
        $this->assertEquals(Defaults::EMPTY_STRING, $settings->getMessage());
        $this->assertEquals(0.1, $settings->getInterval());
        $this->assertEquals(Defaults::ONE_SPACE_SYMBOL, $settings->getInlineSpacer());
        $this->assertEquals(Defaults::DEFAULT_SUFFIX, $settings->getMessageSuffix());
        $this->assertEquals(Styles::STYLING_DISABLED, $settings->getStyles());
        $this->assertEquals(Defaults::DEFAULT_FRAMES, $settings->getFrames());
        $this->assertEquals(Defaults::EMPTY_STRING, $settings->getSpacer());
//        $this->assertEquals(0, $settings->getMessageErasingLength());
    }

    /** @test */
    public function framesWithNull(): void
    {
        $newSettings = new Settings();
        $frames = [null];
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('All frames should be of string type.');
        $newSettings->setFrames($frames);
    }

    /** @test */
    public function jugglersOrderNotFull(): void
    {
        $newSettings = new Settings();
        $order = [Juggler::MESSAGE, Juggler::FRAMES];
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Incorrect count of order directives [%s] when exactly %s was expected',
                count($order),
                Defaults::NUMBER_OF_ORDER_DIRECTIVES
            )
        );
        $newSettings->setJugglersOrder($order);
    }

    /** @test */
    public function jugglersOrderFullButIncorrect(): void
    {
        $newSettings = new Settings();
        $order = [10, Juggler::MESSAGE, Juggler::FRAMES];
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Directive for %s position not found',
                Defaults::DIRECTIVES_NAMES[Juggler::PROGRESS]
            )
        );
        $newSettings->setJugglersOrder($order);
    }

    /** @test */
    public function mergeNotEmpty(): void
    {
        $settings = new Settings();
        $interval = 0.2;
        $message = 'message';
        $inlinePaddingStr = Defaults::ONE_SPACE_SYMBOL;
        $messageSuffix = '';
        $styles = [
            Juggler::FRAMES_STYLES =>
                [
                    Juggler::COLOR256 => Styles::C_DARK,
                    Juggler::COLOR => Styles::DISABLED,
                ],
            Juggler::MESSAGE_STYLES =>
                [
                    Juggler::COLOR256 => Styles::C_DARK,
                    Juggler::COLOR => Styles::DISABLED,
                ],
            Juggler::PROGRESS_STYLES =>
                [
                    Juggler::COLOR256 => Styles::C_DARK,
                    Juggler::COLOR => Styles::DISABLED,
                ],
        ];
        $frames = Frames::DIAMOND;
        $spacer = Defaults::ONE_SPACE_SYMBOL;

        $order = [1, 2, 0];
        $newSettings =
            (new Settings())
                ->setMessage($message)
                ->setInterval($interval)
                ->setInlineSpacer($inlinePaddingStr)
                ->setJugglersOrder($order)
                ->setMessageSuffix($messageSuffix)
                ->setFrames($frames)
                ->setStyles($styles)
                ->setSpacer($spacer);
        $settings->merge($newSettings);
        $this->assertEquals($message, $settings->getMessage());
        $this->assertEquals($interval, $settings->getInterval());
        $this->assertEquals($inlinePaddingStr, $settings->getInlineSpacer());
        $this->assertEquals($order, $settings->getJugglersOrder());
        $this->assertEquals($messageSuffix, $settings->getMessageSuffix());

        $this->assertEquals($frames, $settings->getFrames());
        $this->assertEquals($styles, $settings->getStyles());
        $this->assertEquals($spacer, $settings->getSpacer());
//        $this->assertEquals(7, $settings->getMessageErasingLength());
    }
}
