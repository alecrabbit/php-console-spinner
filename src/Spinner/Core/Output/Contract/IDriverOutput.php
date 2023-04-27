<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Output\Contract;

use AlecRabbit\Spinner\Core\Contract\ISpinnerState;

interface IDriverOutput
{
    public function finalize(?string $finalMessage = null): void;

    public function initialize(): void;

    public function erase(ISpinnerState $spinnerState): void;

    public function write(ISpinnerState $spinnerState): void;
}
