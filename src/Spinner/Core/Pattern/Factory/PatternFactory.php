<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Factory;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\Pattern\ITemplate;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Contract\IConfigProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Factory\Contract\IPaletteModeFactory;
use AlecRabbit\Spinner\Core\Palette\PaletteMode;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\IPatternFactory;
use AlecRabbit\Spinner\Core\Pattern\Template;

final class PatternFactory implements IPatternFactory
{
    public function __construct(
        protected IIntervalFactory $intervalFactory,
        protected IPaletteModeFactory $paletteModeFactory,
    ) {
    }
    public function create(IPalette $palette): ITemplate
    {
        $entries = $palette->getEntries($this->createPaletteMode());

        return
            new Template(
                interval: $this->createInterval($palette),
                frames: $entries,
            );
    }

    private function createPaletteMode(): IPaletteMode
    {
        return
            $this->paletteModeFactory->create();
    }

    private function createInterval(IPalette $palette): IInterval
    {
        return
            $this->intervalFactory->createNormalized(
                $palette->getOptions()->getInterval()
            );
    }
}
//final class PatternFactory implements IPatternFactory
//{
//    private IOutputConfig $outputConfig;
//
//    public function __construct(
//        protected IIntervalFactory $intervalFactory,
//        IConfigProvider $configProvider,
//    ) {
//        $this->outputConfig = $this->getOutputConfig($configProvider);
//    }
//
//    protected function getOutputConfig(IConfigProvider $configProvider
//    ): IOutputConfig {
//        return
//            $configProvider->getConfig()->get(IOutputConfig::class);
//    }
//
//    public function create(IPalette $palette): ITemplate
//    {
//        $entries = $palette->getEntries($this->createPaletteMode());
//
//        return
//            new Template(
//                interval: $this->createInterval($palette),
//                frames: $entries,
//            );
//    }
//
//    private function createPaletteMode(): IPaletteMode
//    {
//        return
//            new PaletteMode(
//                stylingMode: $this->outputConfig->getStylingMethodMode()
//            );
//    }
//
//    private function createInterval(IPalette $palette): IInterval
//    {
//        return
//            $this->intervalFactory->createNormalized(
//                $palette->getOptions()->getInterval()
//            );
//    }
//}
