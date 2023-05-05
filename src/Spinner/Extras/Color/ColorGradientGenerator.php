<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Color;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Color\Contract\IColor;
use AlecRabbit\Spinner\Extras\Color\Contract\IColorGradientGenerator;
use AlecRabbit\Spinner\Extras\Color\Contract\IColorProcessor;
use Generator;
use Traversable;

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

    /**
     * @inheritDoc
     */
    public function gradients(Traversable $colors, int $num = 2, IColor|string|null $fromColor = null): Generator
    {
        foreach ($colors as $color) {
            if ($fromColor === null) {
                $fromColor = $color;
                continue;
            }
            yield from $this->gradient($fromColor, $color, $num);
            $fromColor = $color;
        }
    }

    /**
     * @inheritDoc
     */
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
