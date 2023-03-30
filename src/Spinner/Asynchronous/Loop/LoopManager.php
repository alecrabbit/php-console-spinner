<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Asynchronous\Loop;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\A\AManager;
use AlecRabbit\Spinner\Core\Contract\ILoopAdapter;
use AlecRabbit\Spinner\Core\Contract\ILoopManager;
use AlecRabbit\Spinner\Core\Contract\ILoopProbe;
use AlecRabbit\Spinner\Exception\DomainException;
use ArrayObject;
use Traversable;

final class LoopManager extends AManager implements ILoopManager
{
    /** @var Traversable<ILoopProbe> $loopProbes */
    protected Traversable $loopProbes;

    public function __construct(
        IContainer $container,
        Traversable $loopProbes,
    ) {
        parent::__construct($container);
        $this->loopProbes = new ArrayObject([]);
        $this->registerProbes($loopProbes);
    }

    private function registerProbes(Traversable $loopProbes): void
    {
        foreach ($loopProbes as $loopProbe) {
            if (self::isSubclassOfLoopProbe($loopProbe)) {
                $this->loopProbes->append($loopProbe);
            }
        }
    }

    protected static function isSubclassOfLoopProbe($loopProbe): bool
    {
        return is_subclass_of($loopProbe, ILoopProbe::class);
    }

    public function createLoop(): ILoopAdapter
    {
        /** @var ILoopProbe $loopProbe */
        foreach ($this->loopProbes as $loopProbe) {
            if ($loopProbe::isSupported()) {
                return $loopProbe::createLoop();
            }
        }
        throw new DomainException(
            'No supported event loop found.' .
            ' Check you have installed one of the supported event loops.' .
            ' Check your probes list if you have modified it.'
        );
    }
}
