<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\Loop\ILoopCreator;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoopCreatorClassProvider;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoopProbe;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

final class LoopCreatorClassProvider implements ILoopCreatorClassProvider
{
    /** @var class-string<ILoopCreator>|null */
    protected ?string $creatorClass = null;

    public function __construct(\Traversable $probes)
    {
        $this->creatorClass = $this->extractClass($probes);
    }

    private function extractClass(\Traversable $probes): ?string
    {
        foreach ($probes as $probe) {
            self::assertProbe($probe);
            if ($probe::isSupported()) {
                return $probe::getCreatorClass();
            }
        }
        return null;
    }

    protected static function assertProbe($probe): void
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

    public function getCreatorClass(): ?string
    {
        return $this->creatorClass;
    }
}
