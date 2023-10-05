<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Contract\IConfigProvider;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Factory\Contract\IPaletteModeFactory;
use AlecRabbit\Spinner\Core\Palette\PaletteMode;

final class PaletteModeFactory implements IPaletteModeFactory
{
    private IConfig $config;

    public function __construct(
        IConfigProvider $configProvider,
    ) {
        $this->config = $configProvider->getConfig();
    }

    public function create(): IPaletteMode
    {
        return
            new PaletteMode(
                stylingMode: $this->getOutputConfig()->getStylingMethodMode(),
            );
    }

    private function getOutputConfig(): IOutputConfig
    {
        return $this->config->get(IOutputConfig::class);
    }
}
