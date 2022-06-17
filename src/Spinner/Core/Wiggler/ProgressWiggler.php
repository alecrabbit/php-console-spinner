<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Wiggler;

use AlecRabbit\Spinner\Core\Contract\Base\C;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Core\Exception\RuntimeException;
use AlecRabbit\Spinner\Core\Rotor\Contract\IRotor;
use AlecRabbit\Spinner\Core\Rotor\Contract\IStyleRotor;
use AlecRabbit\Spinner\Core\Rotor\NoCharsRotor;
use AlecRabbit\Spinner\Core\Rotor\VariadicStringRotor;
use AlecRabbit\Spinner\Core\Wiggler\Contract\AWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IProgressWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IWiggler;

final class ProgressWiggler extends AWiggler implements IProgressWiggler
{
    /**
     * @throws RuntimeException
     * @deprecated
     */
    public function update(IWiggler|string|null $wiggler): IWiggler
    {
        self::assertWiggler($wiggler);
        return
            $wiggler instanceof IProgressWiggler
                ? $wiggler
                : self::create(
                $this->style,
                message: $wiggler ?? C::DEFAULT_MESSAGE,
            );
    }

    protected static function assertWiggler(IWiggler|string|null $wiggler): void
    {
        if (null === $wiggler || is_string($wiggler) || $wiggler instanceof IProgressWiggler) {
            return;
        }
        throw new RuntimeException(
            'Message variable must be a string, null or an instance of IProgressWiggler'
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
        return new VariadicStringRotor($message);
    }
}
