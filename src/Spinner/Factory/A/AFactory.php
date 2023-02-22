<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Factory\A;

use AlecRabbit\Spinner\Config\ConfigBuilder;
use AlecRabbit\Spinner\Config\Contract\IConfig;
use AlecRabbit\Spinner\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Loop\Loop;
use AlecRabbit\Spinner\Factory\Contract\IFactory;
use AlecRabbit\Spinner\Spinner;

abstract class AFactory extends ADefaultsAwareClass implements IFactory
{
    protected static IConfig $config;

    public static function createSpinner(IConfig $config = null): ISpinner
    {
        $config = self::refineConfig($config);

        $spinner =
            new Spinner(
                $config->getDriver(),
                $config->getTimer(),
                $config->getMainWidget(),
            );

        self::addWidgets($spinner);

        return
            self::initializeSpinner($spinner);
    }

    protected static function refineConfig(?IConfig $config): IConfig
    {
        self::$config = $config ?? self::getConfigBuilder()->build();

        return
            self::$config;
    }

    public static function getConfigBuilder(): IConfigBuilder
    {
        return
            new ConfigBuilder(self::getDefaults());
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

            if (self::$config->shouldSetSignalHandlers()) {
                Loop::setSignalHandlers($spinner);
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
}
