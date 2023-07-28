<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Builder\WidgetConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IWidgetConfigBuilder;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Core\Pattern\Contract\IBakedPattern;
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
            ->withStylePattern($this->getBakedPatternMock())
            ->withCharPattern($this->getBakedPatternMock())
            ->build()
        ;

        self::assertInstanceOf(WidgetConfig::class, $config);
    }

    private function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }

    private function getBakedPatternMock(): MockObject&IBakedPattern
    {
        return $this->createMock(IBakedPattern::class);
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
                ->withStylePattern($this->getBakedPatternMock())
        ;

        self::assertNotSame($builder, $configBuilder);
    }

    #[Test]
    public function withCharPatternReturnsOtherInstanceOfBuilder(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $builder =
            $configBuilder
                ->withCharPattern($this->getBakedPatternMock())
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
                ->withStylePattern($this->getBakedPatternMock())
                ->withCharPattern($this->getBakedPatternMock())
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
                ->withStylePattern($this->getBakedPatternMock())
                ->withCharPattern($this->getBakedPatternMock())
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
    public function throwsIfStylePatternIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Style pattern is not set.';

        $test = function (): void {
            $configBuilder = $this->getTesteeInstance();

            $configBuilder
                ->withLeadingSpacer($this->getFrameMock())
                ->withTrailingSpacer($this->getFrameMock())
                ->withCharPattern($this->getBakedPatternMock())
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
        $exceptionMessage = 'Char pattern is not set.';

        $test = function (): void {
            $configBuilder = $this->getTesteeInstance();

            $configBuilder
                ->withLeadingSpacer($this->getFrameMock())
                ->withTrailingSpacer($this->getFrameMock())
                ->withStylePattern($this->getBakedPatternMock())
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
