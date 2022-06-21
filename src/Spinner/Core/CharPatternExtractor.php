<?php

declare(strict_types=1);
// 21.06.22
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\C;
use JetBrains\PhpStorm\ArrayShape;

final class CharPatternExtractor implements Contract\ICharPatternExtractor
{

    /**
     * @inheritDoc
     */
    #[ArrayShape([C::CHARS => "array"])]
    public function extract(array $charPattern): array
    {
        return [
            C::CHARS => [
                C::FRAMES => $frames,
                C::WIDTH => $width,
                C::INTERVAL => $interval,
            ]
        ];
    }
}
