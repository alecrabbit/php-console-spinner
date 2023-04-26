<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Asynchronous\Factory;

use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Exception\DomainException;
use ArrayObject;
use Traversable;

final class LoopProbeFactory implements ILoopProbeFactory
{
    /** @var Traversable<ILoopProbe> $loopProbes */
    private Traversable $loopProbes;

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
    private function registerProbes(Traversable $loopProbes): void
    {
        /** @var class-string<ILoopProbe> $loopProbe */
        foreach ($loopProbes as $loopProbe) {
            if (self::isALoopProbeClass($loopProbe) && $loopProbe::isAvailable()) {
                $this->loopProbes->append($loopProbe);
            }
        }
    }

    private static function isALoopProbeClass(string $loopProbe): bool
    {
        return is_subclass_of($loopProbe, ILoopProbe::class);
    }

    public function getProbe(): ILoopProbe
    {
        /** @var class-string<ILoopProbe> $loopProbe */
        foreach ($this->loopProbes as $loopProbe) {
            if ($loopProbe::isAvailable()) {
                return new $loopProbe();
            }
        }
        throw new DomainException(
            'No supported event loop found.'
            . ' Check that you have installed one of the supported event loops.'
            . ' Check your probes list if you have modified it.'
            . ' If yoy what to use library in synchronous mode, set option explicitly.'
        );
    }
}
