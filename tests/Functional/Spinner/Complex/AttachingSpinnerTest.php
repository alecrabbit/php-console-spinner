<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Complex;

use AlecRabbit\Spinner\Core\Settings\SpinnerSettings;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\TestCase\ContainerModifyingTestCase;
use PHPUnit\Framework\Attributes\Test;

final class AttachingSpinnerTest extends ContainerModifyingTestCase
{
    #[Test]
    public function spinnerCanBeCreatedUnattachedToDriver(): void
    {
        $spinnerSettings = new SpinnerSettings(autoAttach: false);

        $spinner = Facade::createSpinner($spinnerSettings);

        self::assertInstanceOf(Spinner::class, $spinner);

        $driver = Facade::getDriver();

        self::assertFalse($driver->has($spinner));
    }

    public function byDefaultSpinnerIsAttachedToDriver(): void
    {
        $spinner = Facade::createSpinner();

        self::assertInstanceOf(Spinner::class, $spinner);

        $driver = Facade::getDriver();

        self::assertFalse($driver->has($spinner));
    }
}
