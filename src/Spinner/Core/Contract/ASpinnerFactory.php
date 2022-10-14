<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Config\Builder\ConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Frame\CharFrame;
use AlecRabbit\Spinner\MultiSpinner;
use AlecRabbit\Spinner\SimpleSpinner;

abstract class ASpinnerFactory implements ISpinnerFactory
{
    abstract public static function create(?IConfig $config = null): ISimpleSpinner|IMultiSpinner;

    protected static function createSpinner(IConfig $config): ISimpleSpinner
    {
        $spinner = new SimpleSpinner($config);
        self::fillSpinner($spinner, $config);
        self::initializeSpinner($spinner, $config);
        return $spinner;
    }

    protected static function initializeSpinner(ISpinner $spinner, IConfig $config): void
    {
        if ($config->createInitialized() || $config->isAsynchronous()) {
            $spinner->initialize();
        }
        if ($config->isAsynchronous()) {
            // TODO (2022-10-13 12:52) [Alec Rabbit]: attach spinner to the event loop
        }
        // TODO (2022-10-13 13:02) [Alec Rabbit]: attach signal handlers
    }

    protected static function createMultiSpinner(IConfig $config): IMultiSpinner
    {
        $spinner = new MultiSpinner($config);
        self::initializeSpinner($spinner, $config);
        return $spinner;
    }

    protected static function refineConfig(?IConfig $config): IConfig
    {
        return $config ?? (new ConfigBuilder())->build();
    }

    private static function fillSpinner(SimpleSpinner $spinner, IConfig $config): void
    {
        $twirlerBuilder = $config->getTwirlerBuilder();
        $spinner->spinner(
            $twirlerBuilder
                ->withStylePattern($config->getSpinnerStylePattern())
                ->withCharPattern($config->getSpinnerCharPattern())
                ->withTrailingSpacer($config->getSpinnerTrailingSpacer())
//                ->withStylePattern(StylePattern::rainbow())
//                ->withCharPattern(CharPattern::SNAKE_VARIANT_0)
//                ->withTrailingSpacer(CharFrame::createSpace())
                ->build()
        );
    }
}
