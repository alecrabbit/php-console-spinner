<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contracts;

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
     * @return null|SpinnerOutputInterface
     */
    public function getOutput(): ?SpinnerOutputInterface;

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
     * @param string $message
     */
    public function message(string $message): void;

    /**
     * @param float $percent
     */
    public function progress(float $percent): void;

    /**
     * @return string
     */
    public function spin(): string;
}
