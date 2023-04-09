<?php

declare(strict_types=1);
// 09.04.23
namespace AlecRabbit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Core\Output\Contract\ICursor;

final class DriverOutput implements Contract\IDriverOutput
{
    protected bool $initialized = false;

    public function __construct(
        protected readonly IBufferedOutput $output,
        protected readonly ICursor $cursor,
    ) {
    }

    public function finalize(?string $finalMessage = null): void
    {
        $this->cursor->show();
        $finalMessage && $this->output->write($finalMessage);
    }

    public function initialize(): void
    {
        $this->cursor->hide();
    }

    public function writeSequence(string $sequence, int $width, int $previousWidth): void
    {
        $this->output->bufferedWrite($sequence);

        $this->cursor
            ->erase(max($previousWidth - $width, 0))
            ->moveLeft($width)
        ;

        $this->output->flush();
    }

    public function erase(int $width): void
    {
        $this->cursor->erase($width)->flush();
    }
}
