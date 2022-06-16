<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\Base\C;
use AlecRabbit\Spinner\Core\Contract\IStylePatternExtractor;
use AlecRabbit\Spinner\Core\Contract\IStyleRenderer;
use JetBrains\PhpStorm\ArrayShape;

final class StyleRenderer implements IStyleRenderer
{
    public function __construct(
        private readonly IStylePatternExtractor $extractor,
    ) {
    }

    #[ArrayShape([C::STYLES => "array", C::INTERVAL => "null|int|float"])]
    public function render(array $pattern): array
    {
        $extracted = $this->extract($pattern);
        $interval = $extracted[C::INTERVAL] ?? null;
        $styles = [];
        $format = $extracted[C::STYLES][C::FORMAT];
        foreach ($extracted[C::STYLES][C::SEQUENCE] as $style) {
            $styles[] = Sequencer::colorSequence(sprintf($format, $style) . C::STR_PLACEHOLDER);
        }
        return
            [
                C::STYLES => $styles,
                C::INTERVAL => $interval,
            ];
    }

    #[ArrayShape([C::STYLES => "array", C::INTERVAL => "null|int|float"])]
    private function extract(array $pattern): array
    {
        $extracted = $this->extractor->extract($pattern);
        $this->assert($extracted);
        return $extracted;
    }

    private function assert(array $extracted): void
    {
        // TODO (2022-06-15 17:58) [Alec Rabbit]: Implement.
    }

}
