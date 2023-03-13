<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\A;

use AlecRabbit\Spinner\Core\A\ASpinner;
use AlecRabbit\Spinner\Core\Config\ConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigBuilderGetter;
use AlecRabbit\Spinner\Core\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\ILoopHelper;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopGetter;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Helper\Asserter;

abstract class ASpinnerFactory extends ADefaultsAwareClass implements ISpinnerFactory,
                                                                      IConfigBuilderGetter,
                                                                      ILoopGetter
{
    protected static IConfig $config;

    protected static ?string $loopClassName = null;

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
            new class(
                $config->getDriver(),
                $config->getTimer(),
                $config->getMainWidget(),
            ) extends ASpinner {
            };
    }

    protected static function addWidgets(ISpinner $spinner): void
    {
        foreach (self::$config->getWidgets() as $widget) {
            $spinner->add($widget);
        }
    }

    /**
     * @throws DomainException
     */
    protected static function initializeSpinner(ISpinner $spinner): ISpinner
    {
        /** @var ILoopHelper $loopClass */
        $loopClass = self::getLoopClass();

        if (self::$config->isAsynchronous()) {
            $loopClass::attach($spinner);

            if (self::$config->areSignalHandlersEnabled()) {
                $loopClass::setSignalHandlers($spinner, self::$config->getSignalHandlers());
            }

            if (self::$config->isAutoStart()) {
                $loopClass::autoStart();
            }
        }

        if (self::$config->createInitialized() || self::$config->isAsynchronous()) {
            $spinner->initialize();
        }
        return $spinner;
    }

    /**
     * @throws DomainException
     */
    protected static function getLoopClass(): string
    {
        if (null === self::$loopClassName) {
            throw new DomainException('Loop class is not registered');
        }
        return self::$loopClassName;
    }

    /**
     * @throws DomainException
     */
    public static function getLoop(): ILoop
    {
        return
            self::getLoopClass()::get();
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function registerLoopClass(string $class): void
    {
        Asserter::classExists($class);
        Asserter::isSubClass($class, ILoopHelper::class);
        self::$loopClassName = $class;
    }
}
