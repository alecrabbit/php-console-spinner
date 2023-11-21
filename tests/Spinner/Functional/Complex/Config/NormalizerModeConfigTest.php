<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Complex\Config;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMode;
use AlecRabbit\Spinner\Contract\Option\NormalizerOption;
use AlecRabbit\Spinner\Core\Config\Contract\INormalizerConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\NormalizerSettings;
use AlecRabbit\Spinner\Core\Settings\Settings;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\TestCase\ConfigurationTestCase;
use PHPUnit\Framework\Attributes\Test;

final class NormalizerModeConfigTest extends ConfigurationTestCase
{
    protected static function performContainerModifications(): void
    {
        self::setContainer(
            self::modifyContainer(
                self::getFacadeContainer(),
                [
                    // Detected settings considered as AUTO
                    IDetectedSettingsFactory::class => static function () {
                        return new class() implements IDetectedSettingsFactory {
                            public function create(): ISettings
                            {
                                return new Settings(); // empty object considered as AUTO
                            }
                        };
                    },
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
