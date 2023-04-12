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
        protected IConsoleCursorBuilder $cursorBuilder
        // TODO (2023-04-10 20:07) [Alec Rabbit]: inject config [64045a0f-da0f-4bed-94fd-8f178bdf9282]
    )
    {
    }

    public function create(): IConsoleCursor
    {
        return
            $this->cursorBuilder
                ->withOutput(
                    $this->bufferedOutputFactory->getOutput()
                )
                ->withCursorOption(
                // TODO (2023-04-10 14:46) [Alec Rabbit]: Make it configurable [64045a0f-da0f-4bed-94fd-8f178bdf9282]
                    OptionCursor::VISIBLE,
                )
                ->build()
        ;
    }
}
