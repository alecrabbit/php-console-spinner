<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Complex;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Contract\IConfigProvider;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\TestCase\ContainerModifyingTestCase;
use PHPUnit\Framework\Attributes\Test;

final class StylingMethodModeConfigTest extends ContainerModifyingTestCase
{
    #[Test]
    public function canSetStylingMethodOption(): void
    {


        Facade::getSettings()
            ->set(
                new OutputSettings(
                    stylingMethodOption: StylingMethodOption::NONE,
                ),
            );

        $spinner = Facade::createSpinner();

        $container = self::extractContainer();

        /** @var IConfigProvider $configProvider */
        $configProvider = $container->get(IConfigProvider::class);

        /** @var IOutputConfig $outputConfig */
        $outputConfig = $configProvider->getConfig()->get(IOutputConfig::class);

        self::assertSame(StylingMethodMode::NONE, $outputConfig->getStylingMethodMode());
    }
}
