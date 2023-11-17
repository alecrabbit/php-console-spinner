<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Detector;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Contract\Probe\IStylingMethodOptionCreator;
use AlecRabbit\Spinner\Contract\Probe\IStylingMethodProbe;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\IStylingMethodDetector;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use ArrayObject;
use Traversable;

final readonly class StylingMethodDetector implements IStylingMethodDetector
{
    public function __construct(
        protected Traversable $probes = new ArrayObject(),
    ) {
    }

    public function getSupportValue(): StylingMethodOption
    {
        /** @var class-string<IStylingMethodProbe> $probe */
        foreach ($this->probes as $probe) {
            self::assertProbe($probe);
            if ($probe::isSupported()) {
                /** @var class-string<IStylingMethodOptionCreator> $class */
                $class = $probe::getCreatorClass();
                return (new $class())->create();
            }
        }

        return StylingMethodOption::NONE;
    }

    private static function assertProbe(mixed $probe): void
    {
        if (!is_a($probe, IStylingMethodProbe::class, true)) {
            throw new InvalidArgument(
                sprintf(
                    'Probe must be an instance of "%s" interface.',
                    IStylingMethodProbe::class
                )
            );
        }
    }
}
