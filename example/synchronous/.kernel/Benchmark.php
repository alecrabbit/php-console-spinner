<?php

declare(strict_types=1);

namespace Example\Kernel;

use DateTimeImmutable;

final class Benchmark
{
    protected const DATE_FORMAT = 'Y-m-d H:i:s.u';
    protected const HEADER = '(Stats)';
    protected array $values = [];

    public function __construct(
        protected string $header = self::HEADER,
    ) {
    }

    public function add(int $value): void
    {
        $this->values[] = $value;
    }

    public function report(): string
    {
        $this->cleanse();
        return
            sprintf(
                '%s▕ %s▕ %s▕ %s▕',
                $this->header,
                $this->timestamp(),
                $this->timeReport(),
                $this->memoryReport(),
            );
    }

    protected function cleanse(): void
    {
        if (count($this->values) > 400) { // remove oldest
            $this->values = array_slice($this->values, 300);
        }
    }

    private function timestamp(): string
    {
        return (new DateTimeImmutable())->format(self::DATE_FORMAT);
    }

    private function timeReport(): string
    {
        return sprintf(
            'Time Avg: %sμs',
            number_format((array_sum($this->values) / count($this->values)) / 1000, 3),
        );
    }

    private function memoryReport(): string
    {
        return sprintf(
            'Memory Real: %sK Peak: %sK',
            number_format(memory_get_usage(true) / 1024),
            number_format(memory_get_peak_usage(true) / 1024),
        );
    }
}
