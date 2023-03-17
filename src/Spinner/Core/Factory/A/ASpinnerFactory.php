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
use AlecRabbit\Spinner\Facade;

abstract class ASpinnerFactory extends ADefaultsAwareClass implements
    ISpinnerFactory,
    IConfigBuilderGetter
{
    protected static IConfig $config;

    /**
     * @throws DomainException
     */
    public static function createSpinner(IConfig $config = null): ISpinner
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
                $config->getRootWidget(),
            ) extends ASpinner {
            };
    }

    protected static function addWidgets(ISpinner $spinner): void
    {
        foreach (self::$config->getWidgets() as $widget) {
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
        $loopHelper = Facade::getLoopHelper();

        if (self::$config->getLoopConfig()->isAsynchronous()) {
            $loopHelper::attach($spinner);

            if (self::$config->getLoopConfig()->areSignalHandlersEnabled()) {
                $loopHelper::setSignalHandlers($spinner, self::$config->getLoopConfig()->getSignalHandlers());
            }

            if (self::$config->getLoopConfig()->isAutoStart()) {
                $loopHelper::autoStart();
            }
        }

        if (self::$config->createInitialized() || self::$config->getLoopConfig()->isAsynchronous()) {
            $spinner->initialize();
        }
        return $spinner;
    }
}
