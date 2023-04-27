<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Color;

use AlecRabbit\Spinner\Contract\Color\IColor;
use AlecRabbit\Spinner\Core\Color\RGBColor;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Color\Contract\IColorGradientGenerator;
use AlecRabbit\Spinner\Extras\Color\Contract\IColorProcessor;
use Generator;

final class ColorGradientGenerator implements IColorGradientGenerator
{
    protected const MAX_STEPS = 1000;
    protected const MIN_STEPS = 2;
    protected int $floatPrecision;

    public function __construct(
        protected IColorProcessor $colorProcessor,
        protected int $maxSteps = self::MAX_STEPS,
    ) {
        $this->floatPrecision = $colorProcessor->getFloatPrecision();
    }

    public function gradient(IColor|string $from, IColor|string $to, int $steps = 100): Generator
    {
        $this->assertSteps($steps);

        $steps--;

        $from = $this->colorProcessor->toRGB($from);
        $to = $this->colorProcessor->toRGB($to);

        $rStep = ($to->red - $from->red) / $steps;
        $gStep = ($to->green - $from->green) / $steps;
        $bStep = ($to->blue - $from->blue) / $steps;
        $aStep = ($to->alpha - $from->alpha) / $steps;

        for ($i = 0; $i < $steps; $i++) {
            yield new RGBColor(
                (int)round($from->red + $rStep * $i),
                (int)round($from->green + $gStep * $i),
                (int)round($from->blue + $bStep * $i),
                round($from->alpha + $aStep * $i, $this->floatPrecision),
            );
        }

        yield $to;
    }

    private function assertSteps(int $steps): void
    {
        match (true) {
            $steps < self::MIN_STEPS => throw new InvalidArgumentException(
                sprintf('Steps must be greater than %s.', self::MIN_STEPS)
            ),
            $steps > $this->maxSteps => throw new InvalidArgumentException(
                sprintf('Steps must be less than %s.', $this->maxSteps)
            ),
            default => null,
        };
    }
}
