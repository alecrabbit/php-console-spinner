<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Wiggler;

use AlecRabbit\Spinner\Core\Contract\ICharsRotor;
use AlecRabbit\Spinner\Core\Contract\IMessageWiggler;
use AlecRabbit\Spinner\Core\Contract\IStyleRotor;
use AlecRabbit\Spinner\Core\Contract\IWiggler;
use AlecRabbit\Spinner\Core\Exception\RuntimeException;
use AlecRabbit\Spinner\Core\Wiggler\Contract\AWiggler;

final class MessageWiggler extends AWiggler implements IMessageWiggler
{
    protected const DEFAULT_MESSAGE = '';

    public function __construct(
        IStyleRotor $styleRotor,
        ICharsRotor $charRotor,
        string $leadingSpacer = '',
        string $trailingSpacer = '',
        protected readonly string $message = self::DEFAULT_MESSAGE,
    ) {
        parent::__construct($styleRotor, $charRotor, $leadingSpacer, $trailingSpacer);
    }

    private static function assertMessage(IWiggler|string|null $message): void
    {
        if(null === $message || is_string($message) || $message instanceof IMessageWiggler) {
            return;
        }
        throw new RuntimeException('Message must be a string, null or an instance of IMessageWiggler');
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
                : new self(
                $this->styleRotor,
                $this->charRotor,
                $this->leadingSpacer,
                $this->trailingSpacer,
                $message ?? self::DEFAULT_MESSAGE,
            );

    }

    protected function getSequence(float|int|null $interval = null): string
    {
        return $this->message;
    }

    private function updateMessageWiggler(IWiggler|string|null $message): IWiggler
    {
        return
            $message instanceof IMessageWiggler
                ? $message
                : new self(
                $this->styleRotor,
                $this->charRotor,
                $this->leadingSpacer,
                $this->trailingSpacer,
                $message ?? self::DEFAULT_MESSAGE,
            );
    }
}
