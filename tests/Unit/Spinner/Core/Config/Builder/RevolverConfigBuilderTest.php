<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Builder\RevolverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Builder\WidgetConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IRevolverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IWidgetConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Config\RevolverConfig;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class RevolverConfigBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $configBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(RevolverConfigBuilder::class, $configBuilder);
    }

    protected function getTesteeInstance(): IRevolverConfigBuilder
    {
        return
            new RevolverConfigBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $config = $configBuilder
            ->withStylePalette($this->getPaletteMock())
            ->withCharPalette($this->getPaletteMock())
            ->build()
        ;

        self::assertInstanceOf(RevolverConfig::class, $config);
    }

    private function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }

    protected function getRevolverConfigMock(): MockObject&IRevolverConfig
    {
        return $this->createMock(IRevolverConfig::class);
    }

    private function getPaletteMock(): MockObject&IPalette
    {
        return $this->createMock(IPalette::class);
    }

    #[Test]
    public function withStylePatternReturnsOtherInstanceOfBuilder(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $builder =
            $configBuilder
                ->withStylePalette($this->getPaletteMock())
        ;

        self::assertNotSame($builder, $configBuilder);
    }

    #[Test]
    public function withCharPatternReturnsOtherInstanceOfBuilder(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $builder =
            $configBuilder
                ->withCharPalette($this->getPaletteMock())
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
}
