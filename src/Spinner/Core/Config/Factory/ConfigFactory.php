<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Config;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IAuxConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IDriverConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\ILoopConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IOutputConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;

final readonly class ConfigFactory implements IConfigFactory
{
    public function __construct(
        protected IAuxConfigFactory $auxConfigFactory,
        protected ILoopConfigFactory $loopConfigFactory,
        protected IOutputConfigFactory $outputConfigFactory,
        protected IDriverConfigFactory $driverConfigFactory,
        protected IWidgetConfigFactory $widgetConfigFactory,
        protected IWidgetConfigFactory $rootWidgetConfigFactory,
    ) {
    }

    public function create(): IConfig
    {
        return
//            new Config(
//                auxConfig: new AuxConfig(
//                    runMethodMode: RunMethodMode::ASYNC,
//                    loopAvailabilityMode: LoopAvailabilityMode::AVAILABLE,
//                    normalizerMethodMode: NormalizerMethodMode::BALANCED,
//                ),
//                loopConfig: new LoopConfig(
//                    autoStartMode: AutoStartMode::ENABLED,
//                    signalHandlersMode: SignalHandlersMode::ENABLED,
//                ),
//                outputConfig: new OutputConfig(
//                    stylingMethodMode: StylingMethodMode::ANSI8,
//                    cursorVisibilityMode: CursorVisibilityMode::HIDDEN,
//                ),
//                driverConfig: new DriverConfig(
//                    linkerMode: LinkerMode::ENABLED,
//                    initializationMode: InitializationMode::ENABLED
//                ),
//                widgetConfig: new WidgetConfig(
//                    leadingSpacer: new CharFrame('', 0),
//                    trailingSpacer: new CharFrame(' ', 1),
//                    stylePattern: new BakedPattern(),
//                    charPattern: new BakedPattern(),
//                ),
//                rootWidgetConfig: new WidgetConfig(
//                    leadingSpacer: new CharFrame('', 0),
//                    trailingSpacer: new CharFrame(' ', 1),
//                    stylePattern: new BakedPattern(),
//                    charPattern: new BakedPattern(),
//                ),
//            );
            new Config(
                $this->auxConfigFactory->create(),
                $this->loopConfigFactory->create(),
                $this->outputConfigFactory->create(),
                $this->driverConfigFactory->create(),
                $this->widgetConfigFactory->create(),
                $this->rootWidgetConfigFactory->create(),
            );
    }
}
