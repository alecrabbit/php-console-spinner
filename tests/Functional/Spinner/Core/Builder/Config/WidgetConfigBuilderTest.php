<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Core\Builder\Config;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Builder\Config\Contract\IWidgetConfigBuilder;
use AlecRabbit\Spinner\Core\Builder\Config\WidgetConfigBuilder;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Core\Pattern\Contract\IBakedPattern;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetConfigBuilderTest extends TestCase
{
    protected function getTesteeInstance(): IWidgetConfigBuilder
    {
        return
            new WidgetConfigBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $configBuilder = $this->getTesteeInstance();

        $leadingSpacer = $this->getFrameMock();
        $trailingSpacer = $this->getFrameMock();
        $stylePattern = $this->getBakedPatternMock();
        $charPattern = $this->getBakedPatternMock();

        $config = $configBuilder
            ->withLeadingSpacer($leadingSpacer)
            ->withTrailingSpacer($trailingSpacer)
            ->withStylePattern($stylePattern)
            ->withCharPattern($charPattern)
            ->build()
        ;

        self::assertInstanceOf(WidgetConfig::class, $config);

        self::assertSame($leadingSpacer, $config->getLeadingSpacer());
        self::assertSame($trailingSpacer, $config->getTrailingSpacer());
        self::assertSame($stylePattern, $config->getStylePattern());
        self::assertSame($charPattern, $config->getCharPattern());
    }

    private function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }

    private function getBakedPatternMock(): MockObject&IBakedPattern
    {
        return $this->createMock(IBakedPattern::class);
    }
}
