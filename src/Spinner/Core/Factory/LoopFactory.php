<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Adapter\React\ReactLoop;
use AlecRabbit\Spinner\Core\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Exception\DomainException;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;

final class LoopFactory implements ILoopFactory
{
    private iterable $supportedPackages = [];

    /** @var iterable<ILoopProbe> */
    private iterable $loopProbes = [
        ReactLoop::class,
    ];

    public function __construct(iterable $loopProbes = [])
    {
        foreach ($loopProbes as $loopProbe) {
            $this->addLoopProbe($loopProbe);
        }
    }

    private function addLoopProbe(mixed $loopProbe): void
    {
        if ($loopProbe instanceof ILoopProbe && !in_array($loopProbe, $this->loopProbes, true)) {
            $this->loopProbes[] = $loopProbe;
            $this->supportedPackages[] = $loopProbe::getPackageName();
        }
    }

    /**
     * @throws DomainException
     */
    public function getLoop(): ILoop
    {
        /** @var ILoopProbe $loopProbe */
        foreach ($this->loopProbes as $loopProbe) {
            if ($loopProbe::isSupported()) {
                return $loopProbe::getLoop();
            }
        }
        throw $this->getNoLoopException();
    }

    private function getNoLoopException(): DomainException
    {
        // TODO (2022-06-10 18:21) [Alec Rabbit]: clarify message [248e8c9c-ca5d-47bb-92d2-267b25165425]
        return new DomainException(
            sprintf(
                'Failed to retrieve event loop object. Please install: [%s].',
                implode(', ', $this->supported()),
            )

        );
    }

    public function supported(): array
    {
        return
            $this->supportedPackages;
    }
}
