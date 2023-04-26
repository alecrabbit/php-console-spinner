<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Core\Widget\Contract\ILegacyWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\ILegacyWidgetContext;
use AlecRabbit\Spinner\Core\Widget\LegacyWidgetContext;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class LegacyWidgetContextTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $widgetContext = $this->getTesteeInstance();

        self::assertInstanceOf(LegacyWidgetContext::class, $widgetContext);
    }

    public function getTesteeInstance(
        ?ILegacyWidgetComposite $widget = null,
    ): ILegacyWidgetContext
    {
        return new LegacyWidgetContext(
            widget: $widget ?? $this->getLegacyWidgetCompositeMock(),
        );
    }

    #[Test]
    public function canGetWidget(): void
    {
        $widget = $this->getLegacyWidgetCompositeMock();
        $widgetContext = $this->getTesteeInstance(
            widget: $widget,
        );

        self::assertInstanceOf(LegacyWidgetContext::class, $widgetContext);
        self::assertSame($widget, $widgetContext->getWidget());
    }

    #[Test]
    public function canReplaceWidget(): void
    {
        $widget = $this->getLegacyWidgetCompositeMock();

        $widgetContext = $this->getTesteeInstance(
            widget: $widget,
        );

        $widget2 = $this->getLegacyWidgetCompositeMock();
        $widget2
            ->expects(self::once())
            ->method('setContext')
            ->with($widgetContext);

        $widgetContext->replaceWidget($widget2);

        self::assertInstanceOf(LegacyWidgetContext::class, $widgetContext);
        self::assertSame($widget2, $widgetContext->getWidget());
    }
}
