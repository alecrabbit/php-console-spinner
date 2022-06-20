<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Spinner\Kernel;

use AlecRabbit\Spinner\Core\Contract\C;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Kernel\Contract\IStylePatternExtractor;
use JetBrains\PhpStorm\ArrayShape;
use Throwable;

use const AlecRabbit\Cli\TERM_NOCOLOR;

final class StylePatternExtractor implements IStylePatternExtractor
{
    private const COLOR_SUPPORT = TERM_NOCOLOR;

    public function __construct(
        private readonly int $terminalColorSupport = self::COLOR_SUPPORT,
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    #[ArrayShape([C::STYLES => "array"])]
    public function extract(array $stylePattern): array
    {
        self::assert($stylePattern);

        $colorSupport = $this->extractStylePatternMaxColorSupport($stylePattern);

        $sequence = $stylePattern[C::STYLES][$colorSupport][C::SEQUENCE] ?? [];
        $format = $stylePattern[C::STYLES][$colorSupport][C::FORMAT] ?? null;
        $interval = $stylePattern[C::STYLES][$colorSupport][C::INTERVAL] ?? null;

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
    private static function assert(array $pattern): void
    {
        if (!array_key_exists(C::STYLES, $pattern)) {
            throw new InvalidArgumentException(
                sprintf('Style pattern must contain "%s" key.', C::STYLES)
            );
        }
        // TODO (2022-06-20 13:54) [Alec Rabbit]: Add more checks.
    }

    private function extractStylePatternMaxColorSupport(array $pattern): int
    {
        try {
            $maxColorSupport = max(array_keys($pattern[C::STYLES]));
        } catch (Throwable $_) {
            return self::COLOR_SUPPORT;
        }

        if ($this->terminalColorSupport > $maxColorSupport) {
            return $maxColorSupport;
        }

        return $this->terminalColorSupport;
    }
}
