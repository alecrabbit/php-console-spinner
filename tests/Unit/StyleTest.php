<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Tools;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Spinner\Core\Style;
use PHPUnit\Framework\TestCase;
use function AlecRabbit\Helpers\getValue;
use const AlecRabbit\NO_COLOR_TERMINAL;

class StyleTest extends TestCase
{
    protected const PROCESSING = 'Processing';
    protected const ONE_ELEMENT = 'oneElement';
    protected const DATA = 'data';
    protected const PERCENT_STYLES = 'percentStyles';
    protected const MESSAGE_STYLES = 'messageStyles';
    protected const SPINNER_STYLES = 'spinnerStyles';
    protected const S = '%s';

    /** @test */
    public function instance(): void
    {
        $style = new Style([], NO_COLOR_TERMINAL);
        $this->assertInstanceOf(Style::class, $style);
        $spinnerStyles = getValue($style, self::SPINNER_STYLES);
        if ($spinnerStyles instanceof Circular) {
            $this->assertEquals(self::S, getValue($spinnerStyles, self::DATA));
            $this->assertTrue(getValue($spinnerStyles, self::ONE_ELEMENT));
        }
        $messageStyles = getValue($style, self::MESSAGE_STYLES);
        if ($messageStyles instanceof Circular) {
            $this->assertEquals(self::S, getValue($messageStyles, self::DATA));
            $this->assertTrue(getValue($messageStyles, self::ONE_ELEMENT));
        }
        $percentStyles = getValue($style, self::PERCENT_STYLES);
        if ($percentStyles instanceof Circular) {
            $this->assertEquals(self::S, getValue($percentStyles, self::DATA));
            $this->assertTrue(getValue($percentStyles, self::ONE_ELEMENT));
        }
    }
}
