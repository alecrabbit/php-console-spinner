<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Tools;

use AlecRabbit\Spinner\Core\Contracts\SettingsInterface;
use AlecRabbit\Spinner\Core\Contracts\StylesInterface;
use AlecRabbit\Spinner\Core\Settings;
use PHPUnit\Framework\TestCase;

class SettingsTest extends TestCase
{
    protected const PROCESSING = 'Processing';
    protected const COMPUTING = 'Computing';
    protected const MB_STRING_1 = 'ᚹädm漢字';

    /**
     * @test
     */
    public function instance(): void
    {
        $settings = new Settings();
        $this->assertInstanceOf(Settings::class, $settings);
        $this->assertEquals($settings->getMessage(), SettingsInterface::EMPTY);
        $this->assertEquals($settings->getInterval(), 0.1);
        $this->assertEquals($settings->getErasingShift(), 0);
        $this->assertEquals($settings->getInlinePaddingStr(), '');
        $this->assertEquals($settings->getMessagePrefix(), SettingsInterface::ONE_SPACE_SYMBOL);
        $this->assertEquals($settings->getMessageSuffix(), '');
        $this->assertEquals($settings->getStyles(), StylesInterface::DEFAULT_STYLES);
        $this->assertEquals($settings->getSymbols(), SettingsInterface::DEFAULT_FRAMES);
        $settings->setMessage(self::PROCESSING);
        $this->assertEquals($settings->getMessage(), self::PROCESSING);
        $this->assertEquals($settings->getMessageErasingLen(), 10);
        $settings->setMessage(self::COMPUTING, 9);
        $this->assertEquals($settings->getMessage(), self::COMPUTING);
        $this->assertEquals($settings->getMessageErasingLen(), 9);
        $settings->setMessage(self::MB_STRING_1);
        $this->assertEquals($settings->getMessage(), self::MB_STRING_1);
        $this->assertEquals($settings->getMessageErasingLen(), 6);
    }
}
