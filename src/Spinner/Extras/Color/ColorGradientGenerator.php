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
    protected const MAX = 1000;
    protected const MIN = 2;
    protected int $floatPrecision;

    public function __construct(
        protected IColorProcessor $colorProcessor,
        protected int $maxColors = self::MAX,
    ) {
        $this->floatPrecision = $colorProcessor->getFloatPrecision();
    }

    public function gradient(IColor|string $from, IColor|string $to, int $count = 2): Generator
    {
        $this->assertCount($count);

        $count--;

        $from = $this->colorProcessor->toRGB($from);
        $to = $this->colorProcessor->toRGB($to);

        $rStep = ($to->red - $from->red) / $count;
        $gStep = ($to->green - $from->green) / $count;
        $bStep = ($to->blue - $from->blue) / $count;
        $aStep = ($to->alpha - $from->alpha) / $count;

        for ($i = 0; $i < $count; $i++) {
            yield new RGBColor(
                (int)round($from->red + $rStep * $i),
                (int)round($from->green + $gStep * $i),
                (int)round($from->blue + $bStep * $i),
                round($from->alpha + $aStep * $i, $this->floatPrecision),
            );
        }

        yield $to;
    }

    private function assertCount(int $count): void
    {
        dump($count);
        match (true) {
            $count < self::MIN => throw new InvalidArgumentException(
                sprintf('Number of colors must be greater than %s.', self::MIN)
            ),
            $count > $this->maxColors => throw new InvalidArgumentException(
                sprintf('Number of colors must be less than %s.', $this->maxColors)
            ),
            default => null,
        };
    }
}
