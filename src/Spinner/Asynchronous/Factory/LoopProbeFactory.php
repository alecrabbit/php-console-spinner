<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Asynchronous\Factory;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Exception\DomainException;
use ArrayObject;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Traversable;

final class LoopProbeFactory implements ILoopProbeFactory
{
    /** @var Traversable<ILoopProbe> $loopProbes */
    protected Traversable $loopProbes;

    /**
     * @param Traversable<ILoopProbe> $loopProbes
     */
    public function __construct(
        Traversable $loopProbes,
    ) {
        $this->loopProbes = new ArrayObject([]);
        $this->registerProbes($loopProbes);
    }

    /**
     * @param Traversable<ILoopProbe> $loopProbes
     */
    protected function registerProbes(Traversable $loopProbes): void
    {
        /** @var class-string<ILoopProbe> $loopProbe */
        foreach ($loopProbes as $loopProbe) {
            if (self::isALoopProbeClass($loopProbe) && $loopProbe::isSupported()) {
                $this->loopProbes->append($loopProbe);
            }
        }
    }

    protected static function isALoopProbeClass(string $loopProbe): bool
    {
        return is_subclass_of($loopProbe, ILoopProbe::class);
    }

    public function getProbe(): ILoopProbe
    {
        /** @var class-string<ILoopProbe> $loopProbe */
        foreach ($this->loopProbes as $loopProbe) {
            if ($loopProbe::isSupported()) {
                return new $loopProbe();
            }
        }
        throw new DomainException(
            'No supported event loop found.' .
            ' Check you have installed one of the supported event loops.' .
            ' Check your probes list if you have modified it.'
        );
    }
}
