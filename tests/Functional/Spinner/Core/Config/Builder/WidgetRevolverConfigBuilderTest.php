<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Builder\WidgetRevolverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IWidgetRevolverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Config\WidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetRevolverConfigBuilderTest extends TestCase
{
    #[Test]
    public function canBuild(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $stylePalette = $this->getPaletteMock();
        $charPalette = $this->getPaletteMock();

        $config = $configBuilder
            ->withStylePalette($stylePalette)
            ->withCharPalette($charPalette)
            ->build()
        ;

        self::assertInstanceOf(WidgetRevolverConfig::class, $config);

        self::assertSame($stylePalette, $config->getStylePalette());
        self::assertSame($charPalette, $config->getCharPalette());
    }

    protected function getTesteeInstance(): IWidgetRevolverConfigBuilder
    {
        return
            new WidgetRevolverConfigBuilder();
    }

    #[Test]
    public function throwsIfStylePatternIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Style palette is not set.';

        $test = function (): void {
            $configBuilder = $this->getTesteeInstance();

            $configBuilder
                ->withCharPalette($this->getPaletteMock())
                ->build()
            ;
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    private function getPaletteMock(): MockObject&IPalette
    {
        return $this->createMock(IPalette::class);
    }

    #[Test]
    public function throwsIfCharPatternIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Char palette is not set.';

        $test = function (): void {
            $configBuilder = $this->getTesteeInstance();

            $configBuilder
                ->withStylePalette($this->getPaletteMock())
                ->build()
            ;
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    protected function getRevolverConfigMock(): MockObject&IWidgetRevolverConfig
    {
        return $this->createMock(IWidgetRevolverConfig::class);
    }
}
