<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;


/**
 * @internal
 */
interface IDriver
{
    public function hideCursor(): void;

    public function showCursor(): void;

    public function render(IWigglerContainer $wigglers, null|float|int $interval = null): IFrame;

    public function prepareFrame(IWigglerContainer $wigglers, float|int|null $interval): IFrame;

    public function erase(): void;

    public function getWriter(): IWriter;

    public function getRenderer(): IRenderer;
}
