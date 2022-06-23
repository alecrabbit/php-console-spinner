<?php

declare(strict_types=1);
// 21.06.22
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\C;
use AlecRabbit\Spinner\Core\Contract\ICharPatternExtractor;
use JetBrains\PhpStorm\ArrayShape;

final class CharPatternExtractor implements ICharPatternExtractor
{
    /**
     * @inheritDoc
     */
    #[ArrayShape([C::CHARS => "array"])]
    public function extract(array $charPattern): array
    {
        self::assertCharPattern($charPattern);

        $frames = $charPattern[C::FRAMES] ?? [];
        $width = $charPattern[C::ELEMENT_WIDTH] ?? null;
        $interval = $charPattern[C::INTERVAL] ?? null;

        if (is_string($frames)) {
            $frames = StrSplitter::split($frames);
        }

        return [
            C::CHARS => [
                C::FRAMES => $frames,
                C::WIDTH => $width,
                C::INTERVAL => $interval,
            ]
        ];
    }

    private static function assertCharPattern(array $charPattern)
    {
        // TODO (2022-06-21 16:21) [Alec Rabbit]: Implement
    }
}
