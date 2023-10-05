<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Detector;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Contract\Probe\IColorSupportProbe;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\Probe\ILoopProbe;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\IColorSupportDetector;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use RuntimeException;

final readonly class ColorSupportDetector implements IColorSupportDetector
{
    public function __construct(
        protected \Traversable $probes = new \ArrayObject(),
    ) {
    }

    /** @inheritDoc */
    public function isSupported(): bool
    {
        foreach ($this->probes as $probe) {
            self::assertProbe($probe);
            if ($probe::isSupported()) {
                return true;
            }
        }

        return false;
    }

    protected static function assertProbe($probe): void
    {
        if (!is_a($probe, IColorSupportProbe::class, true)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Probe must be an instance of "%s" interface.',
                    IColorSupportProbe::class
                )
            );
        }
    }

    public function getStylingMethodOption(): StylingMethodOption
    {
        // TODO: Implement getStylingMethodOption() method.
        throw new \RuntimeException('Not implemented.');
    }
}
