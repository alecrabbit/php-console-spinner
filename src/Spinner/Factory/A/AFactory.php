<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Factory\A;

use AlecRabbit\Spinner\Asynchronous\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Asynchronous\Loop\Loop;
use AlecRabbit\Spinner\Core\Config\ConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Factory\Contract\IFactory;
use AlecRabbit\Spinner\Spinner;

abstract class AFactory extends ADefaultsAwareClass implements IFactory
{
    protected static IConfig $config;

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

    private static function doCreateSpinner(IConfig $config): Spinner
    {
        return
            new Spinner(
                $config->getDriver(),
                $config->getTimer(),
                $config->getMainWidget(),
            );
    }

    protected static function addWidgets(Spinner $spinner): void
    {
        foreach (self::$config->getWidgets() as $widget) {
            $spinner->add($widget);
        }
    }

    protected static function initializeSpinner(ISpinner $spinner): ISpinner
    {
        if (self::$config->isAsynchronous()) {
            Loop::attach($spinner);

            if (self::$config->areSignalHandlersEnabled()) {
                Loop::setSignalHandlers($spinner, self::$config->getSignalHandlers());
            }

            if (self::$config->isAutoStart()) {
                Loop::autoStart();
            }
        }

        if (self::$config->createInitialized() || self::$config->isAsynchronous()) {
            $spinner->initialize();
        }
        return $spinner;
    }


    public static function getLoop(): ILoop
    {
        return
            Loop::get();
    }
}
