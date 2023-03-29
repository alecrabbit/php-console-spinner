<?php

declare(strict_types=1);
// 16.03.23
namespace AlecRabbit\Spinner\Core\Factory\A;

use AlecRabbit\Spinner\Contract\IAnsiStyleConverter;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Factory\Contract\IAnsiColorConverterFactory;

abstract class AStaticAnsiColorConverterFactory extends ADefaultsAwareClass implements IAnsiColorConverterFactory
{
    private static ?IAnsiStyleConverter $colorConverter = null;

    public static function getGetAnsiColorConverter(?IDefaults $defaults = null): IAnsiStyleConverter
    {
        if (null === static::$colorConverter) {
            static::$colorConverter = self::createAnsiColorConverter($defaults);
        }
        return static::$colorConverter;
    }

    protected static function createAnsiColorConverter(?IDefaults $defaults): IAnsiStyleConverter
    {
        $defaults ??= static::getDefaults();

        $ansiStyleConverterClass = $defaults->getClasses()->getAnsiStyleConverterClass();

        $colorMode = $defaults->getTerminalSettings()->getStyleMode();

        return
            new $ansiStyleConverterClass($colorMode);
    }
}