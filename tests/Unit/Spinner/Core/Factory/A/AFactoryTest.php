<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Factory\A;

use AlecRabbit\Spinner\Core\Config\ConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Factory\A\ASpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\DefaultsFactory;
use AlecRabbit\Spinner\Core\Widget\NullWidget;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;

final class AFactoryTest extends TestCase
{
    /** @test */
    public function canCreateDefaultSpinner(): void
    {
        $spinner = ASpinnerFactory::createSpinner();

        /** @noinspection UnnecessaryAssertionInspection */
        self::assertInstanceOf(ISpinner::class, $spinner);
    }

    /** @test */
    public function canCreateAndAddWidgets(): void
    {
        $config =
            (new ConfigBuilder(DefaultsFactory::create()))
                ->withWidgets([NullWidget::create()])
                ->build();
        $spinner = ASpinnerFactory::createSpinner($config);

        self::assertEquals(1, self::getValue('childrenCount', self::getValue('widget', $spinner)));
    }

    protected function setUp(): void
    {
        DefaultsFactory::create()
            ->setModeAsSynchronous(true)
            ->setHideCursor(false)
            ->setAutoStart(false)
            ->setAttachSignalHandlers(false);
    }
}
