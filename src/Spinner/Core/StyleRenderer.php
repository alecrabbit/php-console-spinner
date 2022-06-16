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

    #[ArrayShape([C::STYLES => "array", C::INTERVAL => "mixed"])]
    public function render(array $extracted): array
    {
        $this->assert($extracted);
        return
            [
                C::STYLES => [
                    C::SEQUENCE =>
                        $extracted[C::STYLES][$this->extractor][C::SEQUENCE] ?? [],
                    C::FORMAT =>
                        $extracted[C::STYLES][$this->extractor][C::FORMAT] ?? null,
                ],
                C::INTERVAL =>
                    $extracted[C::INTERVAL],
            ];
    }

    private function assert(array $extracted): void
    {
        // TODO (2022-06-15 17:58) [Alec Rabbit]: Implement.
    }

}
