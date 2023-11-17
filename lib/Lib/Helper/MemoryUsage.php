<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Helper;

use AlecRabbit\Lib\Helper\Contract\IBytesFormatter;

/**
 * @codeCoverageIgnore
 */
final class MemoryUsage
{
    private IBytesFormatter $formatter;

    public function __construct(
        protected string $format = 'Memory usage: %s Peak: %s',
        ?IBytesFormatter $formatter = null,
    ) {
        $this->formatter = $formatter ?? new BytesFormatter();
    }

    public function report(?int $peakBytes = null, ?int $bytes = null): string
    {
        return sprintf(
            $this->format,
            $this->formatter->format($peakBytes ?? memory_get_peak_usage(true)),
            $this->formatter->format($bytes ?? memory_get_usage(true)),
        );
    }
}
