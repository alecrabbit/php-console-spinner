<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Spinner\Exception\ObserverCanNotBeOverwritten;

use function sprintf;

abstract class ASubject implements ISubject
{
    public function __construct(
        protected ?IObserver $observer = null,
    ) {
    }

    public function notify(): void
    {
        $this->observer?->update($this);
    }

    public function attach(IObserver $observer): void
    {
        $this->assertNotSelf($observer);

        $this->assertObserverIsNotAttached();

        $this->observer = $observer;
    }

    /**
     * @throws InvalidArgument
     */
    protected function assertNotSelf(object $obj): void
    {
        if ($obj === $this) {
            throw new InvalidArgument(
                sprintf(
                    'Object can not be self. %s #%s.',
                    get_debug_type($obj),
                    spl_object_id($obj),
                )
            );
        }
    }

    /**
     * @throws LogicException
     */
    protected function assertObserverIsNotAttached(): void
    {
        if ($this->observer instanceof IObserver) {
            throw new ObserverCanNotBeOverwritten('Observer is already attached.');
        }
    }

    public function detach(IObserver $observer): void
    {
        if ($this->observer === $observer) {
            $this->observer = null;
        }
    }
}
