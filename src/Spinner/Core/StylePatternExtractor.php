<?php
declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\Base\C;
use AlecRabbit\Spinner\Core\Contract\IStylePatternExtractor;

use JetBrains\PhpStorm\ArrayShape;

use const AlecRabbit\Cli\TERM_NOCOLOR;

final class StylePatternExtractor implements IStylePatternExtractor
{
    public function __construct(
        private readonly int $terminalColorSupport = TERM_NOCOLOR,
    ) {
    }

    #[ArrayShape([C::STYLES => "array", C::INTERVAL => "mixed"])]
    public function extract(array $pattern): array
    {
        $this->assert($pattern);
        return
            [
                C::STYLES => [
                    C::SEQUENCE =>
                        $pattern[C::STYLES][$this->terminalColorSupport][C::SEQUENCE] ?? [],
                    C::FORMAT =>
                        $pattern[C::STYLES][$this->terminalColorSupport][C::FORMAT] ?? null,
                ],
                C::INTERVAL =>
                    $pattern[C::INTERVAL],
            ];
    }

    private function assert(array $pattern): void
    {
        // TODO (2022-06-15 17:58) [Alec Rabbit]: Implement [0393ca28-1910-4562-a348-0677aa8b4d46].
    }

}
