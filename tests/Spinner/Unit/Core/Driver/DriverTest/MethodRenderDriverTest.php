<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Driver\DriverTest;

use PHPUnit\Framework\Attributes\Test;

final class MethodRenderDriverTest extends TestCaseForDriver
{
    #[Test]
    public function canRender(): void
    {
        $spinner = $this->getSpinnerMock();

        $renderer = $this->getRendererMock();
        $renderer
            ->expects(self::exactly(2))
            ->method('render')
            ->with(self::identicalTo($spinner))
        ;

        $driver = $this->getTesteeInstance(renderer: $renderer);

        $driver->initialize();

        $driver->add($spinner);

        $driver->render();
    }

    #[Test]
    public function canRenderIfNoSpinnerAdded(): void
    {
        $renderer = $this->getRendererMock();
        $renderer
            ->expects(self::never())
            ->method('render')
        ;

        $driver = $this->getTesteeInstance(renderer: $renderer);

        $driver->initialize();

        $driver->render();
    }
}
