<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Core\Contract\ISequenceState;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;
use AlecRabbit\Spinner\Core\Output\Contract\ISequenceStateWriter;

final class SequenceStateWriter implements ISequenceStateWriter
{
    private bool $initialized = false;

    public function __construct(
        protected readonly IBufferedOutput $output,
        protected readonly IConsoleCursor $cursor,
    ) {
    }

    public function finalize(?string $finalMessage = null): void
    {
        if ($this->initialized) {
            $this->initialized = false;

            $finalMessage && $this->output->append($finalMessage);

            $this->cursor->show();

            $this->output->flush();
        }
    }

    public function write(ISequenceState $state): void
    {
        if ($this->initialized) {
            $this->output->append($state->getSequence());

            $width = $state->getWidth();
            $eraseWidth =
                max($state->getPreviousWidth() - $width, 0);

            $this->cursor
                ->erase($eraseWidth)
                ->moveLeft($width)
            ;

            $this->output->flush();
        }
    }

    public function erase(ISequenceState $state): void
    {
        if ($this->initialized) {
            $this->cursor->erase(
                $state->getPreviousWidth()
            );

            $this->output->flush();
        }
    }

    public function initialize(): void
    {
        $this->cursor->hide();

        $this->output->flush();

        $this->initialized = true;
    }
}
