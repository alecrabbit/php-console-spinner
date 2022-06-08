<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;


/**
 * @internal
 */
interface IDriver
{
    public function hideCursor(): void;

    public function showCursor(): void;

    public function render(IWigglerContainer $wigglers, ?IInterval $interval = null): IFrame;

    public function prepareFrame(IWigglerContainer $wigglers, ?IInterval $interval): IFrame;

    public function erase(): void;

    public function getWriter(): IWriter;

    public function getRenderer(): IRenderer;
}
