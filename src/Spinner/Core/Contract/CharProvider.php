<?php

declare(strict_types=1);
// 21.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Frame\Factory\Contract\ICharFrameFactory;

final class CharProvider implements ICharProvider
{
    public function __construct(
        protected readonly ICharFrameFactory $frameFactory,
        protected readonly ICharPatternExtractor $extractor,
    ) {
    }

    public function provide(array $charPattern = null): array
    {
        // TODO: Implement provide() method.
    }
}
