<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contracts;

use AlecRabbit\Spinner\Core\Spinner;

interface SpinnerInterface
{
    /**
     * Returns or prints out first spinner frame string (hides cursor)
     *
     * @param null|float $percent
     * @return string
     */
    public function begin(?float $percent = null): string;

    /**
     * Erases spinner with space symbols or returns erase sequence string
     *
     * @return string
     */
    public function erase(): string;

    /**
     * Erases spinner and shows cursor or returns sequence string
     *
     * @param null|string $finalMessage
     * @return string
     */
    public function end(?string $finalMessage = null): string;

    /**
     * Returns output
     *
     * @return null|OutputInterface
     */
    public function getOutput(): ?OutputInterface;

    /**
     * Enables inline mode
     *
     * @param bool $inline
     * @return SpinnerInterface
     */
    public function inline(bool $inline): self;

    /**
     * Returns spinner recommended refresh interval
     *
     * @return float
     */
    public function interval(): float;

    /**
     * Sets current message for spinner
     *
     * @param null|string $message
     * @return Spinner
     */
    public function message(?string $message): Spinner;

    /**
     * Sets current progress value for spinner 0..1
     *
     * @param null|float $percent
     * @return Spinner
     */
    public function progress(?float $percent): Spinner;

    /**
     * Disables spinner
     *
     * @return self
     */
    public function disable(): self;

    /**
     * Enables spinner
     *
     * @return self
     */
    public function enable(): self;

    /**
     * Returns or prints out current spinner string
     *
     * @return string
     */
    public function spin(): string;

    /**
     * Returns or prints out last spinner string
     *
     * @return string
     */
    public function last(): string;

    /**
     * @return bool
     */
    public function isActive(): bool;
}
