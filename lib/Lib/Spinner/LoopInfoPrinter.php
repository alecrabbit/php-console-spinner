<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner;

use AlecRabbit\Lib\Spinner\Contract\ILoopInfoFormatter;
use AlecRabbit\Lib\Spinner\Contract\ILoopInfoPrinter;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;

final readonly class LoopInfoPrinter implements ILoopInfoPrinter
{
    public function __construct(
        private IOutput $output,
        private ILoopInfoFormatter $formatter,
    ) {
    }

    public function print(?ILoop $loop): void
    {
        $this->output->writeln(
            $this->formatter->format($loop),
        );
    }
}
