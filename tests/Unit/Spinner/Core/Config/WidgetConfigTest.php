<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPatternMarker;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetConfigTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $config = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetConfig::class, $config);
    }

    protected function getTesteeInstance(
        ?IFrame $leadingSpacer = null,
        ?IFrame $trailingSpacer = null,
        ?IPatternMarker $stylePattern = null,
        ?IPatternMarker $charPattern = null,
    ): IWidgetConfig {
        return
            new WidgetConfig(
                leadingSpacer: $leadingSpacer ?? $this->getFrameMock(),
                trailingSpacer: $trailingSpacer ?? $this->getFrameMock(),
                stylePattern: $stylePattern ?? $this->getBakedPatternMock(),
                charPattern: $charPattern ?? $this->getBakedPatternMock(),
            );
    }

    protected function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }

    protected function getBakedPatternMock(): MockObject&IPatternMarker
    {
        return $this->createMock(IPatternMarker::class);
    }

    #[Test]
    public function canGetLeadingSpacer(): void
    {
        $leadingSpacer = $this->getFrameMock();

        $config = $this->getTesteeInstance(
            leadingSpacer: $leadingSpacer,
        );

        self::assertSame($leadingSpacer, $config->getLeadingSpacer());
    }

    #[Test]
    public function canGetTrailingSpacer(): void
    {
        $trailingSpacer = $this->getFrameMock();

        $config = $this->getTesteeInstance(
            trailingSpacer: $trailingSpacer,
        );

        self::assertSame($trailingSpacer, $config->getTrailingSpacer());
    }

    #[Test]
    public function canGetStylePattern(): void
    {
        $stylePattern = $this->getBakedPatternMock();

        $config = $this->getTesteeInstance(
            stylePattern: $stylePattern,
        );

        self::assertSame($stylePattern, $config->getStylePattern());
    }

    #[Test]
    public function canGetCharPattern(): void
    {
        $charPattern = $this->getBakedPatternMock();

        $config = $this->getTesteeInstance(
            charPattern: $charPattern,
        );

        self::assertSame($charPattern, $config->getCharPattern());
    }
}
