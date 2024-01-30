<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Spinner\Exception\ObserverCanNotBeOverwritten;

use function sprintf;

/**
 * // TODO (2024-01-30 16:24) [Alec Rabbit]: consider extracting to separate package
 *     [799b9a43-72bd-4e89-aa3e-4cf35dec98e8]
 */
abstract class ASubject implements ISubject
{
    public function __construct(
        protected ?IObserver $observer = null,
    ) {
    }

    // todo [f1d3c183-1419-4a28-af89-4c7fe9a0948d]
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
