<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\A;

use AlecRabbit\Spinner\Core\A\ASpinner;
use AlecRabbit\Spinner\Core\Config\ConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigBuilderGetter;
use AlecRabbit\Spinner\Core\Contract\ILoopHelper;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Spinner\StaticFacade;

abstract class AStaticSpinnerFactory extends ADefaultsAwareClass implements
    ISpinnerFactory,
    IConfigBuilderGetter
{
    protected static IConfig $config;

    /**
     * @throws DomainException
     */
    public function createSpinner(IConfig $config = null): ISpinner
    {
        self::$config = self::refineConfig($config);

        $spinner = self::doCreateSpinner(self::$config);

        self::addWidgets($spinner);

        return
            self::initializeSpinner($spinner);
    }

    protected static function refineConfig(?IConfig $config): IConfig
    {
        return
            $config ?? self::getConfigBuilder()->build();
    }

    public static function getConfigBuilder(): IConfigBuilder
    {
        return
            new ConfigBuilder(self::getDefaults());
    }

    private static function doCreateSpinner(IConfig $config): ISpinner
    {
        return
            new class (
                $config->getDriver(),
                $config->getSpinnerConfig()->getRootWidget(),
            ) extends ASpinner {
            };
    }

    protected static function addWidgets(ISpinner $spinner): void
    {
        /** @var IWidgetComposite $widget */
        foreach (self::$config->getSpinnerConfig()->getWidgets() as $widget) {
            if ($widget instanceof IWidgetComposite) {
                $spinner->add($widget);
            }
        }
    }

    /**
     * @throws DomainException
     */
    protected static function initializeSpinner(ISpinner $spinner): ISpinner
    {
        /** @var ILoopHelper $loopHelper */
        $loopHelper = StaticFacade::getLoopHelper();

        if (self::$config->getLoopConfig()->isAsynchronous()) {
            $loopHelper::attach($spinner);

            if (self::$config->getLoopConfig()->areEnabledSignalHandlers()) {
                $loopHelper::setSignalHandlers($spinner, self::$config->getLoopConfig()->getSignalHandlers());
            }

            if (self::$config->getLoopConfig()->isEnabledAutoStart()) {
                $loopHelper::autoStart();
            }
        }

        if (self::$config->getSpinnerConfig()->isEnabledInitialization()
            || self::$config->getLoopConfig()->isAsynchronous()) {
            $spinner->initialize();
        }
        return $spinner;
    }
}
