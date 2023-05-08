<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Unit\Spinner\Core\Config;

use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class WidgetConfigTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreatedEmpty(): void
    {
        $config = new WidgetConfig();
        self::assertNull($config->getLeadingSpacer());
        self::assertNull($config->getTrailingSpacer());
        self::assertNull($config->getStylePattern());
        self::assertNull($config->getCharPattern());
    }

    #[Test]
    public function canOverrideEmptyValues(): void
    {
        $config = new WidgetConfig();
        self::assertNull($config->getLeadingSpacer());
        self::assertNull($config->getTrailingSpacer());
        self::assertNull($config->getStylePattern());
        self::assertNull($config->getCharPattern());

        $leadingSpacer = $this->getFrameMock();
        $trailingSpacer = $this->getFrameMock();
        $stylePattern = $this->getStylePatternMock();
        $charPattern = $this->getCharPatternMock();

        $config->setLeadingSpacer($leadingSpacer);
        $config->setTrailingSpacer($trailingSpacer);
        $config->setStylePattern($stylePattern);
        $config->setCharPattern($charPattern);

        self::assertNotNull($config->getLeadingSpacer());
        self::assertNotNull($config->getTrailingSpacer());
        self::assertNotNull($config->getStylePattern());
        self::assertNotNull($config->getCharPattern());

        self::assertSame($leadingSpacer, $config->getLeadingSpacer());
        self::assertSame($trailingSpacer, $config->getTrailingSpacer());
        self::assertSame($stylePattern, $config->getStylePattern());
        self::assertSame($charPattern, $config->getCharPattern());
    }

    #[Test]
    public function canBeCreatedWithValues(): void
    {
        $leadingSpacer = $this->getFrameMock();
        $trailingSpacer = $this->getFrameMock();
        $stylePattern = $this->getStylePatternMock();
        $charPattern = $this->getCharPatternMock();

        $config = new WidgetConfig(
            leadingSpacer: $leadingSpacer,
            trailingSpacer: $trailingSpacer,
            stylePattern: $stylePattern,
            charPattern: $charPattern,
        );
        self::assertNotNull($config->getLeadingSpacer());
        self::assertNotNull($config->getTrailingSpacer());
        self::assertNotNull($config->getStylePattern());
        self::assertNotNull($config->getCharPattern());

        self::assertSame($leadingSpacer, $config->getLeadingSpacer());
        self::assertSame($trailingSpacer, $config->getTrailingSpacer());
        self::assertSame($stylePattern, $config->getStylePattern());
        self::assertSame($charPattern, $config->getCharPattern());
    }

    #[Test]
    public function canOverrideCreatedWithValues(): void
    {
        $leadingSpacer = $this->getFrameMock();
        $trailingSpacer = $this->getFrameMock();
        $stylePattern = $this->getStylePatternMock();
        $charPattern = $this->getCharPatternMock();

        $config = new WidgetConfig(
            leadingSpacer: $leadingSpacer,
            trailingSpacer: $trailingSpacer,
            stylePattern: $stylePattern,
            charPattern: $charPattern,
        );
        self::assertNotNull($config->getLeadingSpacer());
        self::assertNotNull($config->getTrailingSpacer());
        self::assertNotNull($config->getStylePattern());
        self::assertNotNull($config->getCharPattern());

        self::assertSame($leadingSpacer, $config->getLeadingSpacer());
        self::assertSame($trailingSpacer, $config->getTrailingSpacer());
        self::assertSame($stylePattern, $config->getStylePattern());
        self::assertSame($charPattern, $config->getCharPattern());

        $leadingSpacer = $this->getFrameMock();
        $trailingSpacer = $this->getFrameMock();
        $stylePattern = $this->getStylePatternMock();
        $charPattern = $this->getCharPatternMock();

        $config->setLeadingSpacer($leadingSpacer);
        $config->setTrailingSpacer($trailingSpacer);
        $config->setStylePattern($stylePattern);
        $config->setCharPattern($charPattern);

        self::assertNotNull($config->getLeadingSpacer());
        self::assertNotNull($config->getTrailingSpacer());
        self::assertNotNull($config->getStylePattern());
        self::assertNotNull($config->getCharPattern());

        self::assertSame($leadingSpacer, $config->getLeadingSpacer());
        self::assertSame($trailingSpacer, $config->getTrailingSpacer());
        self::assertSame($stylePattern, $config->getStylePattern());
        self::assertSame($charPattern, $config->getCharPattern());
    }

    #[Test]
    public function canMergeIfEmpty(): void
    {
        $config = new WidgetConfig();

        $leadingSpacer = $this->getFrameMock();
        $trailingSpacer = $this->getFrameMock();
        $stylePattern = $this->getStylePatternMock();
        $charPattern = $this->getCharPatternMock();

        $configToMerge = new WidgetConfig(
            leadingSpacer: $leadingSpacer,
            trailingSpacer: $trailingSpacer,
            stylePattern: $stylePattern,
            charPattern: $charPattern,
        );

        self::assertNull($config->getLeadingSpacer());
        self::assertNull($config->getTrailingSpacer());
        self::assertNull($config->getStylePattern());
        self::assertNull($config->getCharPattern());

        $config = $config->merge($configToMerge);

        self::assertNotNull($config->getLeadingSpacer());
        self::assertNotNull($config->getTrailingSpacer());
        self::assertNotNull($config->getStylePattern());
        self::assertNotNull($config->getCharPattern());

        self::assertSame($leadingSpacer, $config->getLeadingSpacer());
        self::assertSame($trailingSpacer, $config->getTrailingSpacer());
        self::assertSame($stylePattern, $config->getStylePattern());
        self::assertSame($charPattern, $config->getCharPattern());
    }

    #[Test]
    public function canMergeIfNotEmpty(): void
    {
        $trailingSpacer = $this->getFrameMock();
        $stylePattern = $this->getStylePatternMock();

        $config = new WidgetConfig(
            trailingSpacer: $trailingSpacer,
            stylePattern: $stylePattern,
        );

        $leadingSpacer = $this->getFrameMock();
        $charPattern = $this->getCharPatternMock();

        $configToMerge = new WidgetConfig(
            leadingSpacer: $leadingSpacer,
            charPattern: $charPattern,
        );

        self::assertNull($config->getLeadingSpacer());
        self::assertNotNull($config->getTrailingSpacer());
        self::assertNotNull($config->getStylePattern());
        self::assertNull($config->getCharPattern());

        $config = $config->merge($configToMerge);

        self::assertNotNull($config->getLeadingSpacer());
        self::assertNotNull($config->getTrailingSpacer());
        self::assertNotNull($config->getStylePattern());
        self::assertNotNull($config->getCharPattern());

        self::assertSame($leadingSpacer, $config->getLeadingSpacer());
        self::assertSame($trailingSpacer, $config->getTrailingSpacer());
        self::assertSame($stylePattern, $config->getStylePattern());
        self::assertSame($charPattern, $config->getCharPattern());
    }
}
