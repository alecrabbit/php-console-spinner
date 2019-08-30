<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contracts;

use AlecRabbit\Spinner\Core\Spinner;

interface SpinnerInterface
{
    /**
     * @param null|float $percent
     * @return string
     */
    public function begin(?float $percent = null): string;

    /**
     * @return string
     */
    public function erase(): string;

    /**
     * @return string
     */
    public function end(): string;

    /**
     * @return null|OutputInterface
     */
    public function getOutput(): ?OutputInterface;

    /**
     * @param bool $inline
     * @return SpinnerInterface
     */
    public function inline(bool $inline): self;

    /**
     * @return float
     */
    public function interval(): float;

    /**
     * @param null|string $message
     * @param null|int $erasingLength
     * @return Spinner
     */
    public function message(?string $message = null, ?int $erasingLength = null): Spinner;

    /**
     * @param null|float $percent
     * @return Spinner
     */
    public function progress(?float $percent): Spinner;

    /**
     * @return string
     */
    public function spin(): string;
}
