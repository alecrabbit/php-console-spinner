<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Unit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Core\Pattern\Contract\IBakedPattern;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class WidgetConfigTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $config = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetConfig::class, $config);
    }

    protected function getTesteeInstance(
        ?IFrame $leadingSpacer = null,
        ?IFrame $trailingSpacer = null,
        ?IBakedPattern $stylePattern = null,
        ?IBakedPattern $charPattern = null,
    ): IWidgetConfig {
        return
            new WidgetConfig(
                leadingSpacer: $leadingSpacer ?? $this->getFrameMock(),
                trailingSpacer: $trailingSpacer ?? $this->getFrameMock(),
                stylePattern: $stylePattern ?? $this->getBakedPatternMock(),
                charPattern: $charPattern ?? $this->getBakedPatternMock(),
            );
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
