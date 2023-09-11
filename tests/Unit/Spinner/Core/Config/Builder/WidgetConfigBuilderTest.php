<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Builder\WidgetConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IWidgetConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetConfigBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $configBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetConfigBuilder::class, $configBuilder);
    }

    protected function getTesteeInstance(): IWidgetConfigBuilder
    {
        return
            new WidgetConfigBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $config = $configBuilder
            ->withLeadingSpacer($this->getFrameMock())
            ->withTrailingSpacer($this->getFrameMock())
            ->withRevolverConfig($this->getRevolverConfigMock())
            ->withStylePalette($this->getPatternMarkerMock())
            ->withCharPalette($this->getPatternMarkerMock())
            ->build()
        ;

        self::assertInstanceOf(WidgetConfig::class, $config);
    }

    private function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }

    protected function getRevolverConfigMock(): MockObject&IRevolverConfig
    {
        return $this->createMock(IRevolverConfig::class);
    }

    private function getPatternMarkerMock(): MockObject&IPalette
    {
        return $this->createMock(IPalette::class);
    }

    #[Test]
    public function withLeadingSpacerReturnsOtherInstanceOfBuilder(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $builder =
            $configBuilder
                ->withLeadingSpacer($this->getFrameMock())
        ;

        self::assertNotSame($builder, $configBuilder);
    }

    #[Test]
    public function withTrailingSpacerReturnsOtherInstanceOfBuilder(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $builder =
            $configBuilder
                ->withTrailingSpacer($this->getFrameMock())
        ;

        self::assertNotSame($builder, $configBuilder);
    }

    #[Test]
    public function withStylePatternReturnsOtherInstanceOfBuilder(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $builder =
            $configBuilder
                ->withStylePalette($this->getPatternMarkerMock())
        ;

        self::assertNotSame($builder, $configBuilder);
    }

    #[Test]
    public function withCharPatternReturnsOtherInstanceOfBuilder(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $builder =
            $configBuilder
                ->withCharPalette($this->getPatternMarkerMock())
        ;

        self::assertNotSame($builder, $configBuilder);
    }

    #[Test]
    public function throwsIfLeadingSpacerIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Leading spacer is not set.';

        $test = function (): void {
            $configBuilder = $this->getTesteeInstance();

            $configBuilder
                ->withTrailingSpacer($this->getFrameMock())
                ->withStylePalette($this->getPatternMarkerMock())
                ->withCharPalette($this->getPatternMarkerMock())
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
    public function throwsIfTrailingSpacerIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Trailing spacer is not set.';

        $test = function (): void {
            $configBuilder = $this->getTesteeInstance();

            $configBuilder
                ->withLeadingSpacer($this->getFrameMock())
                ->withStylePalette($this->getPatternMarkerMock())
                ->withCharPalette($this->getPatternMarkerMock())
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
                ->withLeadingSpacer($this->getFrameMock())
                ->withTrailingSpacer($this->getFrameMock())
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
