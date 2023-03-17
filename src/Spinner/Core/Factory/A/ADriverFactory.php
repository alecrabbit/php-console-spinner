<?php
declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core\Factory\A;

use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;

abstract class ADriverFactory extends ADefaultsAwareClass implements IDriverFactory
{
    protected static ?IDriverBuilder $driverBuilder = null;

    public static function getDriverBuilder(?IDefaults $defaults = null): IDriverBuilder
    {
        if (null === static::$driverBuilder) {
            static::$driverBuilder = static::createDriverBuilder($defaults);
        }
        return static::$driverBuilder;
    }

//
//    protected static function createWidgetBuilder(?IDefaults $defaults): IWidgetBuilder
//    {
//        $defaults ??= static::getDefaults();
//
//        $widgetBuilderClass = $defaults->getClasses()->getWidgetBuilderClass();
//
//        return
//            new $widgetBuilderClass(
//                static::getDefaults(),
//                static::getWidgetRevolverBuilder($defaults),
//            );
//    }
    protected static function createDriverBuilder(?IDefaults $defaults): IDriverBuilder
    {
        $defaults ??= static::getDefaults();

        $driverBuilderClass = $defaults->getClasses()->getDriverBuilderClass();

        return
            new $driverBuilderClass(
                static::getDefaults(),
            );
    }
}