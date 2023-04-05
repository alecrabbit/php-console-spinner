<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ISpinnerSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\Pattern\CharPattern\Snake;
use AlecRabbit\Spinner\Core\Pattern\StylePattern\Rainbow;

final class DefaultsProvider implements IDefaultsProvider
{
    protected const DEFAULT_INTERVAL = 1000;

    protected IWidgetSettings $rootWidgetSettings;
    protected IWidgetSettings $widgetSettings;

    public function __construct(
        protected IAuxSettings $auxSettings,
        protected ILoopSettings $loopSettings,
        protected ISpinnerSettings $spinnerSettings,
        protected IDriverSettings $driverSettings,
        ?IWidgetSettings $rootWidgetSettings = null,
        ?IWidgetSettings $widgetSettings = null,
    ) {
        $this->widgetSettings = $widgetSettings ?? $this->createDefaultWidgetSettings();
        $this->rootWidgetSettings = $rootWidgetSettings ?? $this->createRootWidgetSettings($this->widgetSettings);
    }

    private function createDefaultWidgetSettings(): WidgetSettings
    {
        return
            new WidgetSettings(
                leadingSpacer: FrameFactory::createEmpty(),
                trailingSpacer: FrameFactory::createSpace(),
            );
    }

    protected function createRootWidgetSettings(IWidgetSettings $widgetSettings): IWidgetSettings
    {
        return
            new WidgetSettings(
                $widgetSettings->getLeadingSpacer(),
                $widgetSettings->getTrailingSpacer(),
                stylePattern: new Rainbow(),
                charPattern: new Snake(),
            );
    }

    public function getRootWidgetSettings(): IWidgetSettings
    {
        return $this->rootWidgetSettings;
    }

    public function getWidgetSettings(): IWidgetSettings
    {
        return $this->widgetSettings;
    }

    public function getDriverSettings(): IDriverSettings
    {
        return $this->driverSettings;
    }

    public function getSpinnerSettings(): ISpinnerSettings
    {
        return $this->spinnerSettings;
    }

    public function getLoopSettings(): ILoopSettings
    {
        return $this->loopSettings;
    }

    public function getAuxSettings(): IAuxSettings
    {
        return $this->auxSettings;
    }

    protected function createAuxSettings(): IAuxSettings
    {
        return
            new AuxSettings(
                new Interval(self::DEFAULT_INTERVAL),
            );
    }
}
