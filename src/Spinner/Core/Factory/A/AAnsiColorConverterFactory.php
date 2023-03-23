<?php

declare(strict_types=1);
// 16.03.23
namespace AlecRabbit\Spinner\Core\Factory\A;

use AlecRabbit\Spinner\Contract\IAnsiColorConverter;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Factory\Contract\IAnsiColorConverterFactory;

abstract class AAnsiColorConverterFactory extends ADefaultsAwareClass implements IAnsiColorConverterFactory
{
    private static ?IAnsiColorConverter $colorConverter = null;

    public static function getGetAnsiColorConverter(?IDefaults $defaults = null): IAnsiColorConverter
    {
        if (null === static::$colorConverter) {
            static::$colorConverter = self::createAnsiColorConverter($defaults);
        }
        return static::$colorConverter;
    }

    protected static function createAnsiColorConverter(?IDefaults $defaults): IAnsiColorConverter
    {
        $defaults ??= static::getDefaults();

        $ansiColorConverterClass = $defaults->getClasses()->getAnsiColorConverterClass();

        return
            new $ansiColorConverterClass();
    }
}