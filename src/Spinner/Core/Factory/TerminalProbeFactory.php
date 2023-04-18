<?php

declare(strict_types=1);
// 18.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Factory\Contract\ITerminalProbeFactory;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalProbe;
use AlecRabbit\Spinner\Exception\DomainException;
use Traversable;

final class TerminalProbeFactory implements ITerminalProbeFactory
{
    /** @var Traversable<ITerminalProbe> */
    protected Traversable $terminalProbes;

    public function __construct(
        Traversable $terminalProbes,
    ) {
        $this->terminalProbes = new \ArrayObject([]);
        $this->registerProbes($terminalProbes);
    }

    public function getProbe(): ITerminalProbe
    {
        /** @var ITerminalProbe $probe */
        foreach ($this->terminalProbes as $probe) {
            if ($probe->isAvailable()) {
                return $probe;
            }
        }
        throw new DomainException('No terminal probe found.');
    }

    protected function registerProbes(Traversable $probes): void
    {
        foreach ($probes as $probe) {
            if ($this->isTerminalProbeClass($probe)) {
                $this->terminalProbes->append(new $probe());
            }
        }
    }
    private function isTerminalProbeClass(string $loopProbe): bool
    {
        return is_subclass_of($loopProbe, ITerminalProbe::class);
    }
}
