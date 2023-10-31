<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Core\Contract\ISpinnerState;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;

final class DriverOutput implements IDriverOutput
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
            $this->cursor->show();
            $finalMessage && $this->output->append($finalMessage);

            $this->output->flush();
            $this->initialized = false;
        }
    }

    public function write(ISpinnerState $spinnerState): void
    {
        if ($this->initialized) {
            $this->output->append($spinnerState->getSequence());

            $width = $spinnerState->getWidth();
            $eraseWidth =
                max($spinnerState->getPreviousWidth() - $width, 0);

            $this->cursor
                ->erase($eraseWidth)
                ->moveLeft($width)
            ;

            $this->output->flush();
        }
    }

    public function erase(ISpinnerState $spinnerState): void
    {
        if ($this->initialized) {
            $this->cursor->erase(
                $spinnerState->getPreviousWidth()
            );

            $this->output->flush();
        }
    }

    public function initialize(): void
    {
        $this->initialized = true;

        $this->cursor->hide();

        $this->output->flush();
    }
}
