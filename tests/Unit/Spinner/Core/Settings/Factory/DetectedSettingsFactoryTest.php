<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings\Factory;

use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Factory\DetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Settings;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class DetectedSettingsFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(DetectedSettingsFactory::class, $factory);
    }

    public function getTesteeInstance(): IDetectedSettingsFactory
    {
        return
            new DetectedSettingsFactory();
    }

    #[Test]
    public function canCreate(): void
    {
        $factory = $this->getTesteeInstance();

        $settings = $factory->create();

        self::assertInstanceOf(Settings::class, $settings);
    }
}
