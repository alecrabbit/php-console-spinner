<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Loop\Contract;

use Traversable;

interface ILoopCreatorClassExtractor
{
    /**
     * @psalm-param Traversable<ILoopProbe> $probes
     *
     * @psalm-return class-string<ILoopCreator>|null
     */
    public function extract(Traversable $probes): ?string;
}
