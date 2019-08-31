<?php declare(strict_types=1);

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
    protected const COMPUTING = 'Computing';
    protected const MB_STRING_1 = 'ᚹädm漢字';

    /** @test */
    public function instance(): void
    {
        $settings = new Settings();
        $this->assertInstanceOf(Settings::class, $settings);
        $this->assertEquals(Defaults::EMPTY_STRING, $settings->getMessage());
        $this->assertEquals(0.1, $settings->getInterval());
//        $this->assertEquals(0, $settings->getErasingShift());
        $this->assertEquals('', $settings->getInlinePaddingStr());
//        $this->assertEquals(Defaults::ONE_SPACE_SYMBOL, $settings->getMessagePrefix());
        $this->assertEquals('', $settings->getMessageSuffix());
        $this->assertEquals(Styles::STYLING_DISABLED, $settings->getStyles());
        $this->assertEquals(Defaults::DEFAULT_FRAMES, $settings->getFrames());
        $this->assertEquals(Defaults::EMPTY_STRING, $settings->getSpacer());
        $this->assertEquals(0, $settings->getMessageErasingLen());

        $settings->setMessage(Defaults::EMPTY_STRING);
        $this->assertEquals(Defaults::EMPTY_STRING, $settings->getMessage());
        $this->assertEquals(0, $settings->getMessageErasingLen());
        $settings->setMessage(self::PROCESSING);
        $this->assertEquals(self::PROCESSING, $settings->getMessage());
        $this->assertEquals(10, $settings->getMessageErasingLen());
        $settings->setMessage(self::COMPUTING, 9);
        $this->assertEquals(self::COMPUTING, $settings->getMessage());
        $this->assertEquals(9, $settings->getMessageErasingLen());
        $settings->setMessage(self::MB_STRING_1);
        $this->assertEquals(self::MB_STRING_1, $settings->getMessage());
        $this->assertEquals(6, $settings->getMessageErasingLen());
    }

    /** @test */
    public function mergeEmpty(): void
    {
        $settings = new Settings();
        $newSettings = new Settings();
        $settings->merge($newSettings);
        $this->assertEquals(Defaults::EMPTY_STRING, $settings->getMessage());
        $this->assertEquals(0.1, $settings->getInterval());
//        $this->assertEquals(0, $settings->getErasingShift());
        $this->assertEquals('', $settings->getInlinePaddingStr());
//        $this->assertEquals(Defaults::ONE_SPACE_SYMBOL, $settings->getMessagePrefix());
        $this->assertEquals('', $settings->getMessageSuffix());
        $this->assertEquals(Styles::STYLING_DISABLED, $settings->getStyles());
        $this->assertEquals(Defaults::DEFAULT_FRAMES, $settings->getFrames());
        $this->assertEquals(Defaults::EMPTY_STRING, $settings->getSpacer());
        $this->assertEquals(0, $settings->getMessageErasingLen());
    }

    /** @test */
    public function framesWithNull(): void
    {
        $newSettings = new Settings();
        $frames = [null];
        $newSettings->setFrames($frames);
        $this->assertEquals($frames, $newSettings->getFrames());
    }

    /** @test */
    public function mergeNotEmpty(): void
    {
        $settings = new Settings();
        $interval = 0.2;
        $message = 'message';
        $inlinePaddingStr = Defaults::ONE_SPACE_SYMBOL;
        $messagePrefix = '-';
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

        $newSettings =
            (new Settings())
                ->setMessage($message)
                ->setInterval($interval)
                ->setInlinePaddingStr($inlinePaddingStr)
//                ->setMessagePrefix($messagePrefix)
                ->setMessageSuffix($messageSuffix)
                ->setFrames($frames)
                ->setStyles($styles)
                ->setSpacer($spacer);
        $settings->merge($newSettings);
        $this->assertEquals($message, $settings->getMessage());
        $this->assertEquals($interval, $settings->getInterval());
//        $this->assertEquals(1, $settings->getErasingShift());
        $this->assertEquals($inlinePaddingStr, $settings->getInlinePaddingStr());
//        $this->assertEquals($messagePrefix, $settings->getMessagePrefix());
        $this->assertEquals($messageSuffix, $settings->getMessageSuffix());

        $this->assertEquals($frames, $settings->getFrames());
        $this->assertEquals($styles, $settings->getStyles());
        $this->assertEquals($spacer, $settings->getSpacer());
        $this->assertEquals(7, $settings->getMessageErasingLen());
    }
}
