<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Wiggler;

use AlecRabbit\Spinner\Core\Contract\ICharsRotor;
use AlecRabbit\Spinner\Core\Contract\IMessageWiggler;
use AlecRabbit\Spinner\Core\Contract\IStyleRotor;
use AlecRabbit\Spinner\Core\Contract\IWiggler;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Core\Exception\RuntimeException;
use AlecRabbit\Spinner\Core\NoCharsRotor;
use AlecRabbit\Spinner\Core\VariadicStringRotor;
use AlecRabbit\Spinner\Core\Wiggler\Contract\AWiggler;

final class MessageWiggler extends AWiggler implements IMessageWiggler
{
    protected const DEFAULT_MESSAGE = '';

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        IStyleRotor $styleRotor,
        string $leadingSpacer = '',
        string $trailingSpacer = '',
        string $message = self::DEFAULT_MESSAGE,
    ) {
        $charRotor = self::createCharRotor($message);
        parent::__construct($styleRotor, $charRotor, $leadingSpacer, $trailingSpacer);
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function createCharRotor(string $message): ICharsRotor
    {
        if ('' === $message) {
            return new NoCharsRotor();
        }
        return new VariadicStringRotor($message);
    }

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
                $this->leadingSpacer,
                $this->trailingSpacer,
                $message ?? self::DEFAULT_MESSAGE,
            );
    }

    private static function assertMessage(IWiggler|string|null $message): void
    {
        if (null === $message || is_string($message) || $message instanceof IMessageWiggler) {
            return;
        }
        throw new RuntimeException('Message must be a string, null or an instance of IMessageWiggler');
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function create(
        IStyleRotor $styleRotor,
        string $leadingSpacer = '',
        string $trailingSpacer = '',
        string $message = self::DEFAULT_MESSAGE,
    ): self {
        return
            new self(
                $styleRotor,
                $leadingSpacer,
                $trailingSpacer,
                $message,
            );
    }
}
