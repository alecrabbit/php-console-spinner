<?php
declare(strict_types=1);
// 21.06.22
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IStylePatternExtractor;

final class StyleProvider implements Contract\IStyleProvider
{
    public function __construct(
        private readonly IStylePatternExtractor $extractor,
    ) {
    }

    public function provide(array $pattern): array
    {
        // TODO: Implement provide() method.
    }
}
