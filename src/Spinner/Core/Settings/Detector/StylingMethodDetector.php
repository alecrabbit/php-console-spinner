<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Detector;

use AlecRabbit\Spinner\Contract\Option\StylingOption;
use AlecRabbit\Spinner\Contract\Probe\IStylingOptionCreator;
use AlecRabbit\Spinner\Contract\Probe\IStylingOptionProbe;
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

    public function getSupportValue(): StylingOption
    {
        /** @var class-string<IStylingOptionProbe> $probe */
        foreach ($this->probes as $probe) {
            self::assertProbe($probe);
            if ($probe::isSupported()) {
                /** @var class-string<IStylingOptionCreator> $class */
                $class = $probe::getCreatorClass();
                return (new $class())->create();
            }
        }

        return StylingOption::NONE;
    }

    private static function assertProbe(mixed $probe): void
    {
        if (!is_a($probe, IStylingOptionProbe::class, true)) {
            throw new InvalidArgument(
                sprintf(
                    'Probe must be an instance of "%s" interface.',
                    IStylingOptionProbe::class
                )
            );
        }
    }
}
