<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Factory\A;

use AlecRabbit\Spinner\Config\ConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Widget\NullWidget;
use AlecRabbit\Spinner\Factory\A\AFactory;
use AlecRabbit\Spinner\Factory\DefaultsFactory;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;

final class AFactoryTest extends TestCase
{
    /** @test */
    public function canCreateDefaultSpinner(): void
    {
        $spinner = AFactory::createSpinner();

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
        $spinner = AFactory::createSpinner($config);

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
