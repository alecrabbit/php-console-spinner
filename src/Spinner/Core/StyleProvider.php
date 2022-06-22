<?php

declare(strict_types=1);
// 21.06.22
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\C;
use AlecRabbit\Spinner\Core\Contract\IStylePatternExtractor;
use AlecRabbit\Spinner\Core\Frame\Factory\Contract\IStyleFrameFactory;
use AlecRabbit\Spinner\Core\Interval\Interval;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use JetBrains\PhpStorm\ArrayShape;

final class StyleProvider implements Contract\IStyleProvider
{
    public function __construct(
        protected readonly IStyleFrameFactory $frameFactory,
        protected readonly IStylePatternExtractor $extractor,
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    #[ArrayShape([C::FRAMES => "array", C::INTERVAL => Interval::class])]
    public function provide(?array $stylePattern = null): array
    {
        $stylePattern = $stylePattern ?? $this->getDefaultStylePattern();

        $extracted = $this->extractor->extract($stylePattern);
        $styles = $extracted[C::STYLES];
        $interval = $styles[C::INTERVAL] ?? null;
        $format = $styles[C::FORMAT];
        $sequence = $styles[C::SEQUENCE];

        $frames = [];
        foreach ($sequence as $item) {
            $frames[] = $this->frameFactory->create($item, $format);
        }
        return
            [
                C::FRAMES => $frames,
                C::INTERVAL => new Interval($interval),
            ];
    }

    private function getDefaultStylePattern(): array
    {
        return Defaults::getDefaultStylePattern();
    }
}
