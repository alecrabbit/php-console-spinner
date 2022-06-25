<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\C;
use AlecRabbit\Spinner\Core\Contract\IStylePatternExtractor;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use JetBrains\PhpStorm\ArrayShape;
use Throwable;

use const AlecRabbit\Cli\TERM_NOCOLOR;

final class StylePatternExtractor implements IStylePatternExtractor
{
    private const DEFAULT_COLOR_SUPPORT = TERM_NOCOLOR;

    public function __construct(
        private readonly int $terminalColorSupport = self::DEFAULT_COLOR_SUPPORT,
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    #[ArrayShape([C::STYLES => [C::SEQUENCE => "array", C::FORMAT => "null|string", C::INTERVAL => "null|int|float"]])]
    public function extract(array $stylePattern): array
    {
        self::assertStylePattern($stylePattern);

        $colorSupport = $this->extractStylePatternMaxColorSupport($stylePattern);

        $s = $stylePattern[C::STYLES];

        $sequence = $s[$colorSupport][C::SEQUENCE] ?? [];
        $format = $s[$colorSupport][C::FORMAT] ?? null;
        $interval = $s[$colorSupport][C::INTERVAL] ?? null;

        return
            [
                C::STYLES => [
                    C::SEQUENCE => $sequence,
                    C::FORMAT => $format,
                    C::INTERVAL => $interval,
                ],
            ];
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function assertStylePattern(array $stylePattern): void
    {
        // TODO (2022-06-20 13:54) [Alec Rabbit]: Add more checks.
        match (true) {
            !array_key_exists(C::STYLES, $stylePattern) =>
            throw new InvalidArgumentException(
                sprintf('Style pattern must contain "%s" key.', C::STYLES)
            ),
            default => null,
        };
    }

    private function extractStylePatternMaxColorSupport(array $pattern): int
    {
        try {
            $maxColorSupport = max(array_keys($pattern[C::STYLES]));
        } catch (Throwable $_) {
            return self::DEFAULT_COLOR_SUPPORT;
        }

        if ($this->terminalColorSupport > $maxColorSupport) {
            return $maxColorSupport;
        }

        return $this->terminalColorSupport;
    }
}
