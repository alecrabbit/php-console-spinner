<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IDriver;
use AlecRabbit\Spinner\Core\A\ASpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use AlecRabbit\Tests\Spinner\Unit\Spinner\Core\A\Override\ASpinnerOverride;
use PHPUnit\Framework\Attributes\Test;

final class ASpinnerTest extends TestCase
{
    #[Test]
    public function isCreatedInactiveAndUninterrupted(): void
    {
        $spinner = $this->getTesteeInstance();

        self::assertInstanceOf(ASpinner::class, $spinner);
        self::assertFalse(self::getValue('active', $spinner));
        self::assertFalse(self::getValue('interrupted', $spinner));

        self::assertEquals(FrameFactory::createEmpty(), self::getValue('currentFrame', $spinner));
    }

    public function getTesteeInstance(
        ?IDriver $driver = null,
        ?IWidgetComposite $rootWidget = null,
    ): ISpinner {
        return
            new ASpinnerOverride(
                driver: $driver ?? $this->getDriverMock(),
                rootWidget: $rootWidget ?? $this->getRootWidgetMock(),
            );
    }

    protected function getDriverMock(): IDriver
    {
        return $this->createMock(IDriver::class);
    }

    protected function getRootWidgetMock(): IWidgetComposite
    {
        return $this->createMock(IWidgetComposite::class);
    }

    #[Test]
    public function canBeInitializedAfterCreation(): void
    {
        $rootWidget = $this->createMock(IWidgetComposite::class);
        $rootWidget->expects(self::once())->method('update');

        $spinner = $this->getTesteeInstance(rootWidget: $rootWidget);

        $spinner->initialize();
        self::assertTrue(self::getValue('active', $spinner));
        self::assertFalse(self::getValue('interrupted', $spinner));

        $spinner->deactivate();
        self::assertFalse(self::getValue('active', $spinner));
    }

}
