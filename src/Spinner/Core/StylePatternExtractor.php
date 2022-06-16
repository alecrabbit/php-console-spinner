<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\Base\C;
use AlecRabbit\Spinner\Core\Contract\IStylePatternExtractor;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use JetBrains\PhpStorm\ArrayShape;

use const AlecRabbit\Cli\TERM_NOCOLOR;

final class StylePatternExtractor implements IStylePatternExtractor
{
    public function __construct(
        private readonly int $terminalColorSupport = TERM_NOCOLOR,
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    #[ArrayShape([C::STYLES => "array"])]
    public function extract(array $pattern): array
    {
        $this->assert($pattern);
        $i = $this->patternMaxColorSupport($pattern, $this->terminalColorSupport);

        $sequence = $pattern[C::STYLES][$i][C::SEQUENCE] ?? [];
        $format = $pattern[C::STYLES][$i][C::FORMAT] ?? null;
        $interval = $pattern[C::STYLES][$i][C::INTERVAL] ?? null;

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
    private function assert(array $pattern): void
    {
        // TODO (2022-06-15 17:58) [Alec Rabbit]: Implement [0393ca28-1910-4562-a348-0677aa8b4d46].
    }

    private function patternMaxColorSupport(array $pattern, int $terminalColorSupport): int
    {
        try {
            $maxPatternColorSupport = max(array_keys($pattern[C::STYLES]));
        } catch (\Throwable $_) {
            return TERM_NOCOLOR;
        }

        if ($terminalColorSupport > $maxPatternColorSupport) {
            return $maxPatternColorSupport;
        }

        return $terminalColorSupport;
    }
}
