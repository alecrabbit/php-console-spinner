<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Loop;

use AlecRabbit\Spinner\Core\Contract\Loop\ILoopCreatorClassExtractor;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoopProbe;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use Traversable;

final class LoopCreatorClassExtractor implements ILoopCreatorClassExtractor
{
    /** @inheritDoc */
    public function extract(Traversable $probes): ?string
    {
        foreach ($probes as $probe) {
            self::assertProbe($probe);
            if ($probe::isSupported()) {
                return $probe::getCreatorClass();
            }
        }
        return null;
    }

    protected static function assertProbe(mixed $probe): void
    {
        if (!is_a($probe, ILoopProbe::class, true)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Probe must be an instance of "%s" interface.',
                    ILoopProbe::class
                )
            );
        }
    }
}
