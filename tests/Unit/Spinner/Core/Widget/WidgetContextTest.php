<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Core\Widget\Contract\ILegacyWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\WidgetContext;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class WidgetContextTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $widgetContext = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetContext::class, $widgetContext);
    }

    public function getTesteeInstance(
        ?IWidget $widget = null,
    ): IWidgetContext
    {
        return new WidgetContext(
            widget: $widget ?? $this->getWidgetMock(),
        );
    }

    #[Test]
    public function canGetWidget(): void
    {
        $widget = $this->getWidgetMock();
        $widgetContext = $this->getTesteeInstance(
            widget: $widget,
        );

        self::assertInstanceOf(WidgetContext::class, $widgetContext);
        self::assertSame($widget, $widgetContext->getWidget());
    }

    #[Test]
    public function canReplaceWidget(): void
    {
        $widget = $this->getWidgetMock();

        $widgetContext = $this->getTesteeInstance(
            widget: $widget,
        );

        $widget2 = $this->getWidgetMock();
        $widget2
            ->expects(self::once())
            ->method('replaceContext')
            ->with($widgetContext);

        $widgetContext->replaceWidget($widget2);

        self::assertInstanceOf(WidgetContext::class, $widgetContext);
        self::assertSame($widget2, $widgetContext->getWidget());
    }
}
