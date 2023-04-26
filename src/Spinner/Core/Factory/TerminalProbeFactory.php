<?php

declare(strict_types=1);
// 18.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\IProbe;
use AlecRabbit\Spinner\Core\Factory\Contract\ITerminalProbeFactory;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalProbe;
use AlecRabbit\Spinner\Exception\DomainException;
use ArrayObject;
use Traversable;

final class TerminalProbeFactory implements ITerminalProbeFactory
{
    /** @var Traversable<ITerminalProbe> */
    protected Traversable $registeredProbes;

    public function __construct(
        Traversable $probeClasses,
    ) {
        $this->registeredProbes = new ArrayObject([]);
        $this->registerProbes($probeClasses);
    }

    protected function registerProbes(Traversable $probes): void
    {
        /** @var class-string $probe */
        foreach ($probes as $probe) {
            if ($this->isValidProbeClass($probe)) {
                $this->registeredProbes->append(new $probe());
            }
        }
    }

    private function isValidProbeClass(string $probeClass): bool
    {
        return is_subclass_of($probeClass, $this->getProbeClass());
    }

    /**
     * @return class-string
     */
    protected function getProbeClass(): string
    {
        return ITerminalProbe::class;
    }

    public function getProbe(): ITerminalProbe
    {
        /** @var IProbe $probe */
        foreach ($this->registeredProbes as $probe) {
            if ($probe->isAvailable()) {
                return $probe;
            }
        }
        throw new DomainException('No terminal probe found.');
    }
}
