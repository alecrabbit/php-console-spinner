<?php

declare(strict_types=1);

// 10.04.23

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Option\OptionCursor;
use AlecRabbit\Spinner\Core\Contract\IConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\IBufferedOutputSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IConsoleCursorFactory;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;

final class ConsoleCursorFactory implements IConsoleCursorFactory
{
    public function __construct(
        protected IBufferedOutputSingletonFactory $bufferedOutputFactory,
        protected IConsoleCursorBuilder $cursorBuilder,
        protected OptionCursor $optionCursor,
    ) {
    }

    public function create(): IConsoleCursor
    {
        return $this->cursorBuilder
            ->withOutput(
                $this->bufferedOutputFactory->getOutput()
            )
            ->withOptionCursor($this->optionCursor)
            ->build()
        ;
    }
}
