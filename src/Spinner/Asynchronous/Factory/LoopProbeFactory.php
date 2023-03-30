<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Asynchronous\Factory;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Core\Factory\A\AFactory;
use AlecRabbit\Spinner\Exception\DomainException;
use ArrayObject;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Traversable;

final class LoopProbeFactory extends AFactory implements ILoopProbeFactory
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

    protected function registerProbes(Traversable $loopProbes): void
    {
        /** @var class-string<ILoopProbe> $loopProbe */
        foreach ($loopProbes as $loopProbe) {
            if (self::isSubclassOfLoopProbe($loopProbe) && $loopProbe::isSupported()) {
                $this->loopProbes->append($loopProbe);
                $this->container->add($loopProbe, $loopProbe);
            }
        }
    }

    protected static function isSubclassOfLoopProbe($loopProbe): bool
    {
        return is_subclass_of($loopProbe, ILoopProbe::class);
    }

    public function getProbe(): ILoopProbe
    {
        /** @var class-string<ILoopProbe> $loopProbe */
        foreach ($this->loopProbes as $loopProbe) {
            if ($loopProbe::isSupported()) {
                return $this->getLoopProbe($loopProbe);
            }
        }
        throw new DomainException(
            'No supported event loop found.' .
            ' Check you have installed one of the supported event loops.' .
            ' Check your probes list if you have modified it.'
        );
    }

    /**
     * @param class-string<ILoopProbe> $loopProbe
     * @return ILoopProbe
     *
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    protected function getLoopProbe(string $loopProbe): ILoopProbe
    {
        return $this->container->get($loopProbe);
    }
}
