<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Loop\Contract;

use AlecRabbit\Spinner\Contract\ICreator;
use AlecRabbit\Spinner\Contract\Probe\IStaticProbe;
use Traversable;

interface ILoopCreatorClassExtractor
{
    /**
     * @psalm-param Traversable<class-string<IStaticProbe>> $probes
     *
     * @psalm-return class-string<ICreator>|null
     */
    public function extract(Traversable $probes): ?string;
}
