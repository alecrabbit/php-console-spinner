<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Integration\Config;

use AlecRabbit\Spinner\Container\Reference;
use AlecRabbit\Spinner\Container\ServiceDefinition;
use AlecRabbit\Spinner\Contract\Mode\NormalizerMode;
use AlecRabbit\Spinner\Contract\Option\NormalizerOption;
use AlecRabbit\Spinner\Core\Config\Contract\INormalizerConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\NormalizerSettings;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\TestCase\ConfigurationTestCase;
use AlecRabbit\Tests\TestCase\Stub\DetectedSettingsFactoryFactoryStub;
use PHPUnit\Framework\Attributes\Test;

final class NormalizerModeConfigTest extends ConfigurationTestCase
{
    protected static function setTestContainer(): void
    {
        self::setContainer(
            self::modifyContainer(
                [
                    // Detected settings considered as AUTO
                    new ServiceDefinition(
                        IDetectedSettingsFactory::class,
                        new Reference(DetectedSettingsFactoryFactoryStub::class),
                    ),
                    new ServiceDefinition(
                        DetectedSettingsFactoryFactoryStub::class,
                        DetectedSettingsFactoryFactoryStub::class,
                    ),
                ]
            )
        );
    }

    #[Test]
    public function canSetNormalizerOptionStill(): void
    {
        Facade::getSettings()
            ->set(
                new NormalizerSettings(
                    normalizerOption: NormalizerOption::STILL,
                ),
            )
        ;

        /** @var INormalizerConfig $normalizerConfig */
        $normalizerConfig = self::getRequiredConfig(INormalizerConfig::class);

        self::assertSame(NormalizerMode::STILL, $normalizerConfig->getNormalizerMode());
    }

    #[Test]
    public function canSetNormalizerOptionSmooth(): void
    {
        Facade::getSettings()
            ->set(
                new NormalizerSettings(
                    normalizerOption: NormalizerOption::SMOOTH,
                ),
            )
        ;

        /** @var INormalizerConfig $normalizerConfig */
        $normalizerConfig = self::getRequiredConfig(INormalizerConfig::class);

        self::assertSame(NormalizerMode::SMOOTH, $normalizerConfig->getNormalizerMode());
    }

    #[Test]
    public function canSetNormalizerOptionBalanced(): void
    {
        Facade::getSettings()
            ->set(
                new NormalizerSettings(
                    normalizerOption: NormalizerOption::BALANCED,
                ),
            )
        ;

        /** @var INormalizerConfig $normalizerConfig */
        $normalizerConfig = self::getRequiredConfig(INormalizerConfig::class);

        self::assertSame(NormalizerMode::BALANCED, $normalizerConfig->getNormalizerMode());
    }

    #[Test]
    public function canSetNormalizerOptionPerformance(): void
    {
        Facade::getSettings()
            ->set(
                new NormalizerSettings(
                    normalizerOption: NormalizerOption::PERFORMANCE,
                ),
            )
        ;

        /** @var INormalizerConfig $normalizerConfig */
        $normalizerConfig = self::getRequiredConfig(INormalizerConfig::class);

        self::assertSame(NormalizerMode::PERFORMANCE, $normalizerConfig->getNormalizerMode());
    }
}
