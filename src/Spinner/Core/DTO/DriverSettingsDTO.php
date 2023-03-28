<?php

declare(strict_types=1);
// 28.03.23
namespace AlecRabbit\Spinner\Core\DTO;

/**
 * @codeCoverageIgnore
 */
final readonly class DriverSettingsDTO
{
    public function __construct(
        public bool $hideCursor,
        public string $interruptMessage,
        public string $finalMessage,
    ) {
    }
}