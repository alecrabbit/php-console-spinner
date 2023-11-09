<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Detector;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Contract\Probe\IColorSupportProbe;
use AlecRabbit\Spinner\Contract\Probe\IStylingMethodOptionCreator;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\IColorSupportDetector;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use ArrayObject;
use Traversable;

final readonly class ColorSupportDetector implements IColorSupportDetector
{
    public function __construct(
        protected Traversable $probes = new ArrayObject(),
    ) {
    }

    public function getSupportValue(): StylingMethodOption
    {
        /** @var class-string<IColorSupportProbe> $probe */
        foreach ($this->probes as $probe) {
            self::assertProbe($probe);
            if ($probe::isSupported()) {
                /** @var class-string<IStylingMethodOptionCreator> $class */
                $class = $probe::getCreatorClass();
                return (new $class)->create();
            }
        }

        return StylingMethodOption::NONE;
    }

    protected static function assertProbe(mixed $probe): void
    {
        if (!is_a($probe, IColorSupportProbe::class, true)) {
            throw new InvalidArgument(
                sprintf(
                    'Probe must be an instance of "%s" interface.',
                    IColorSupportProbe::class
                )
            );
        }
    }
}
