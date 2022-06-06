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

    public function render(IWigglerContainer $wigglers, null|float|int $interval = null): void;

    public function erase(): void;

    public function getWriter(): IWriter;

    public function getRenderer(): IRenderer;
}
