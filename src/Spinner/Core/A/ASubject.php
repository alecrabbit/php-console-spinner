<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

abstract class ASubject implements ISubject
{
    public function __construct(
        protected ?IObserver $observer = null,
    ) {
    }

    /** @inheritdoc */
    public function notify(): void
    {
        $this->observer?->update($this);
    }

    /** @inheritdoc */
    public function attach(IObserver $observer): void
    {
        if ($this->observer !== null) {
            throw new InvalidArgumentException('Observer is already attached.');
        }

        $this->assertNotSelf($observer);

        $this->observer = $observer;
    }

    protected function assertNotSelf(object $obj): void
    {
        if ($obj === $this) {
            throw new InvalidArgumentException('Object can not be self.');
        }
    }
    
    /** @inheritdoc */
    public function detach(IObserver $observer): void
    {
        if ($this->observer === $observer) {
            $this->observer = null;
        }
    }
}
