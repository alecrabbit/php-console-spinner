<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Loop;

use AlecRabbit\Spinner\Contract\Probe\IStaticProbe;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopCreatorClassExtractor;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use Traversable;

final class LoopCreatorClassExtractor implements ILoopCreatorClassExtractor
{
    /** @inheritDoc */
    public function extract(Traversable $probes): ?string
    {
        /** @var IStaticProbe $probe */
        foreach ($probes as $probe) {
            self::assertProbe($probe);
            if ($probe::isSupported()) {
                return $probe::getCreatorClass();
            }
        }
        return null;
    }

    private static function assertProbe(mixed $probe): void
    {
        if (!is_a($probe, ILoopProbe::class, true)) {
            throw new InvalidArgument(
                sprintf(
                    'Probe must be an instance of "%s" interface.',
                    ILoopProbe::class
                )
            );
        }
    }
}
