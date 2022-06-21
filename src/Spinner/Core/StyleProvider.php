<?php
declare(strict_types=1);
// 21.06.22
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IStylePatternExtractor;
use AlecRabbit\Spinner\Core\Frame\Factory\Contract\IStyleFrameFactory;

final class StyleProvider implements Contract\IStyleProvider
{
    public function __construct(
        protected readonly IStyleFrameFactory $frameFactory,
        protected readonly IStylePatternExtractor $extractor,
    ) {
    }

    public function provide(array $pattern): array
    {
        // TODO: Implement provide() method.
    }
}
