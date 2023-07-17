<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Mode\CursorVisibilityMode;
use AlecRabbit\Spinner\Contract\Option\CursorVisibilityOption;
use AlecRabbit\Spinner\Core\Builder\Contract\IConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\IBufferedOutputSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IConsoleCursorFactory;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;

final class ConsoleCursorFactory implements IConsoleCursorFactory
{
    public function __construct(
        protected IBufferedOutputSingletonFactory $bufferedOutputFactory,
        protected IConsoleCursorBuilder $cursorBuilder,
        protected CursorVisibilityOption $cursorVisibilityOption,
    ) {
    }

    public function create(): IConsoleCursor
    {
        return $this->cursorBuilder
            ->withOutput(
                $this->bufferedOutputFactory->getOutput()
            )
            ->withCursorVisibilityMode(
                $this->convertOptionToMode(
                    $this->cursorVisibilityOption
                )
            )
            ->build()
        ;
    }

    private function convertOptionToMode(CursorVisibilityOption $cursorVisibilityOption): CursorVisibilityMode
    {
        return
            match ($cursorVisibilityOption) {
                CursorVisibilityOption::VISIBLE => CursorVisibilityMode::VISIBLE,
                default => CursorVisibilityMode::HIDDEN,
            };
    }
}
