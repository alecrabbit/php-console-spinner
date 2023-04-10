<?php

declare(strict_types=1);
// 09.04.23
namespace AlecRabbit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Core\Output\Contract\ICursor;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;

final class DriverOutput implements IDriverOutput
{
    protected bool $initialized = false;

    public function __construct(
        protected readonly IBufferedOutput $output,
        protected readonly ICursor $cursor,
    ) {
    }

    public function finalize(?string $finalMessage = null): void
    {
        if ($this->initialized) {
            $this->cursor->show();
            $finalMessage && $this->output->write($finalMessage);
        }
    }

    public function initialize(): void
    {
        $this->initialized = true;
        $this->cursor->hide();
    }

    public function writeSequence(string $sequence, int $width, int $previousWidth): void
    {
        if ($this->initialized) {
            $this->output->bufferedWrite($sequence);

            $this->cursor
                ->erase(max($previousWidth - $width, 0))
                ->moveLeft($width)
            ;

            $this->output->flush();
        }
    }

    public function erase(int $width): void
    {
        if ($this->initialized) {
            $this->cursor->erase($width)->flush();
        }
    }
}
