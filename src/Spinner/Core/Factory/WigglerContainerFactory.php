<?php

declare(strict_types=1);
// 09.06.22
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\Base\C;
use AlecRabbit\Spinner\Core\Contract\IWigglerContainer;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Core\Factory\Contract\IWigglerContainerFactory;
use AlecRabbit\Spinner\Core\Rotor\NoCharsRotor;
use AlecRabbit\Spinner\Core\Rotor\NoStyleRotor;
use AlecRabbit\Spinner\Core\Rotor\RainbowStyleRotor;
use AlecRabbit\Spinner\Core\Rotor\SnakeCharsRotor;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IWiggler;
use AlecRabbit\Spinner\Core\Wiggler\MessageWiggler;
use AlecRabbit\Spinner\Core\Wiggler\ProgressWiggler;
use AlecRabbit\Spinner\Core\Wiggler\RevolveWiggler;
use AlecRabbit\Spinner\Core\WigglerContainer;

final class WigglerContainerFactory implements IWigglerContainerFactory
{
    /**
     * @throws InvalidArgumentException
     */
    public static function create(array $frames): IWigglerContainer
    {
        return
            new WigglerContainer(
                self::createRevolveWiggler($frames),
                self::createMessageWiggler(),
                self::createProgressWiggler(),
            );
    }
//    /**
//     * @throws InvalidArgumentException
//     */
//    public static function create(array $frames): IWigglerContainer
//    {
//        return
//            new WigglerContainer(
//                self::createRevolveWiggler($frames),
//                self::createProgressWiggler(),
//                self::createRevolveWiggler(['🕐', '🕑', '🕒', '🕓', '🕔', '🕕', '🕖', '🕗', '🕘', '🕙', '🕚', '🕛',],
//                    2,
//                    ' '),
//                self::createMessageWiggler(),
//                self::createRevolveWiggler(['🌘', '🌗', '🌖', '🌕', '🌔', '🌓', '🌒', '🌑',], 2, ' '),
//            );
//    }

    /**
     * @throws InvalidArgumentException
     */
    private static function createRevolveWiggler(
        array $data,
        int $width = 1,
        string $leadingSpacer = C::EMPTY_STRING
    ): IWiggler {
        return
            RevolveWiggler::create(
                new RainbowStyleRotor(),
                new SnakeCharsRotor(
                    data: $data,
                    width: $width,
                    leadingSpacer: $leadingSpacer,
                ),
            );
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function createProgressWiggler(): IWiggler
    {
        return
            ProgressWiggler::create(
                new NoStyleRotor(),
                new NoCharsRotor(),
            );
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function createMessageWiggler(): IWiggler
    {
        return
            MessageWiggler::create(
                new NoStyleRotor(),
            );
    }

}
