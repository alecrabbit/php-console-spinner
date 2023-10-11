<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract\Loop;

use Traversable;

interface ILoopCreatorClassExtractor
{
    /**
     * @param Traversable<ILoopProbe> $probes
     * @return class-string<ILoopCreator>|null
     */
    public function extract(Traversable $probes): ?string;
}
