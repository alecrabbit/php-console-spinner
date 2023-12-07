<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Config\Builder;

use AlecRabbit\Spinner\Core\Config\Builder\WidgetRevolverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IWidgetRevolverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Config\WidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetRevolverConfigBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $configBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetRevolverConfigBuilder::class, $configBuilder);
    }

    protected function getTesteeInstance(): IWidgetRevolverConfigBuilder
    {
        return
            new WidgetRevolverConfigBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $config = $configBuilder
            ->withStylePalette($this->getStylePaletteMock())
            ->withCharPalette($this->getCharPaletteMock())
            ->withRevolverConfig($this->getRevolverConfigMock())
            ->build()
        ;

        self::assertInstanceOf(WidgetRevolverConfig::class, $config);
    }

    private function getStylePaletteMock(): MockObject&IStylePalette
    {
        return $this->createMock(IStylePalette::class);
    }

    private function getCharPaletteMock(): MockObject&ICharPalette
    {
        return $this->createMock(ICharPalette::class);
    }

    protected function getRevolverConfigMock(): MockObject&IRevolverConfig
    {
        return $this->createMock(IRevolverConfig::class);
    }

    #[Test]
    public function withStylePatternReturnsOtherInstanceOfBuilder(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $builder =
            $configBuilder
                ->withStylePalette($this->getStylePaletteMock())
        ;

        self::assertNotSame($builder, $configBuilder);
    }

    #[Test]
    public function withCharPatternReturnsOtherInstanceOfBuilder(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $builder =
            $configBuilder
                ->withCharPalette($this->getCharPaletteMock())
        ;

        self::assertNotSame($builder, $configBuilder);
    }

    #[Test]
    public function throwsIfStylePatternIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Style palette is not set.';

        $test = function (): void {
            $configBuilder = $this->getTesteeInstance();

            $configBuilder
                ->withCharPalette($this->getCharPaletteMock())
                ->build()
            ;
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfCharPatternIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Char palette is not set.';

        $test = function (): void {
            $configBuilder = $this->getTesteeInstance();

            $configBuilder
                ->withStylePalette($this->getStylePaletteMock())
                ->build()
            ;
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfRevolverConfigIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Revolver config is not set.';

        $test = function (): void {
            $configBuilder = $this->getTesteeInstance();

            $configBuilder
                ->withStylePalette($this->getStylePaletteMock())
                ->withCharPalette($this->getCharPaletteMock())
                ->build()
            ;
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    protected function getWidgetRevolverConfigMock(): MockObject&IWidgetRevolverConfig
    {
        return $this->createMock(IWidgetRevolverConfig::class);
    }
}
