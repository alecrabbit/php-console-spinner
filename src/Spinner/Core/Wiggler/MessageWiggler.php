<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Wiggler;

use AlecRabbit\Spinner\Core\Contract\Base\C;
use AlecRabbit\Spinner\Core\Contract\ICharsRotor;
use AlecRabbit\Spinner\Core\Contract\IMessageWiggler;
use AlecRabbit\Spinner\Core\Contract\IStyleRotor;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Core\Exception\RuntimeException;
use AlecRabbit\Spinner\Core\NoCharsRotor;
use AlecRabbit\Spinner\Core\VariadicStringRotor;
use AlecRabbit\Spinner\Core\Wiggler\Contract\AWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IWiggler;

final class MessageWiggler extends AWiggler implements IMessageWiggler
{

    /**
     * @throws RuntimeException
     */
    public function update(IWiggler|string|null $message): IWiggler
    {
        self::assertMessage($message);
        return
            $message instanceof IMessageWiggler
                ? $message
                : self::create(
                $this->styleRotor,
                message: $message ?? C::DEFAULT_MESSAGE,
            );
    }

    private static function assertMessage(IWiggler|string|null $message): void
    {
        if (null === $message || is_string($message) || $message instanceof IMessageWiggler) {
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
        IStyleRotor $styleRotor,
        ICharsRotor $charRotor = null,
        string $message = C::DEFAULT_MESSAGE,
    ): self {
        $cr = self::createCharRotor($message);

//        if(self::DEFAULT_MESSAGE !== $message) {
//            $leadingSpacer = self::SPACE_CHAR;
//        }
//
        return
            new self(
                $styleRotor,
                $cr,
            );
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function createCharRotor(string $message): ICharsRotor
    {
        if (C::DEFAULT_MESSAGE === $message) {
            return new NoCharsRotor();
        }
        return new VariadicStringRotor($message);
    }
}
