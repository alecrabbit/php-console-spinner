<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel\Wiggler;

use AlecRabbit\Spinner\Kernel\Contract\Base\C;
use AlecRabbit\Spinner\Kernel\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Kernel\Exception\RuntimeException;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\IRotor;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\IStyleRotor;
use AlecRabbit\Spinner\Kernel\Rotor\NoCharsRotor;
use AlecRabbit\Spinner\Kernel\Rotor\StringRotor;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\AWiggler;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\IMessageWiggler;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\IWiggler;

final class MessageWiggler extends AWiggler implements IMessageWiggler
{

    /**
     * @throws RuntimeException
     * @deprecated
     */
    public function update(IWiggler|string|null $wiggler): IWiggler
    {
        self::assertWiggler($wiggler);
        return
            $wiggler instanceof IMessageWiggler
                ? $wiggler
                : self::create(
                $this->style,
                message: $wiggler ?? C::DEFAULT_MESSAGE,
            );
    }

    protected static function assertWiggler(IWiggler|string|null $wiggler): void
    {
        if (null === $wiggler || is_string($wiggler) || $wiggler instanceof IMessageWiggler) {
            return;
        }
        throw new RuntimeException(
            'Message variable must be a string, null or an instance of IMessageWiggler'
        );
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function create(
        IStyleRotor $style,
        IRotor $rotor = null,
        string $message = C::DEFAULT_MESSAGE,
    ): self {
        $cr = self::createCharRotor($message);

        return
            new self(
                $style,
                $cr,
            );
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function createCharRotor(string $message): IRotor
    {
        if (C::DEFAULT_MESSAGE === $message) {
            return new NoCharsRotor();
        }
        return new StringRotor($message);
    }
}
