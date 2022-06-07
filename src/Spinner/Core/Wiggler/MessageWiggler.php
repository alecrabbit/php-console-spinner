<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Wiggler;

use AlecRabbit\Spinner\Core\Contract\ICharsRotor;
use AlecRabbit\Spinner\Core\Contract\IMessageWiggler;
use AlecRabbit\Spinner\Core\Contract\IStyleRotor;
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

    public function message(IMessageWiggler|string|null $message): IMessageWiggler
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

    protected function getSequence(float|int|null $interval = null): string
    {
        return $this->message;
    }
}
