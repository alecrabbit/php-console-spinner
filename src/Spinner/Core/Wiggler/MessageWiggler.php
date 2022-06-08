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
    public function update(IWiggler|string|null $wiggler): IWiggler
    {
        self::assertWiggler($wiggler);
        return
            $wiggler instanceof IMessageWiggler
                ? $wiggler
                : self::create(
                $this->styleRotor,
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
        IStyleRotor $styleRotor,
        ICharsRotor $charRotor = null,
        string $message = C::DEFAULT_MESSAGE,
    ): self {
        $cr = self::createCharRotor($message);

        // TODO (2022-06-08 14:11) [Alec Rabbit]: refactor
//        if (C::DEFAULT_MESSAGE !== $message) {
//            $styleRotor = $styleRotor->setLeadingSpacer(C::SPACE_CHAR);
//        }
//        if (C::DEFAULT_MESSAGE === $message) {
//            $styleRotor = $styleRotor->setLeadingSpacer(C::EMPTY_STRING);
//        }

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
