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

    public function showFrame(IFrame $frame): void;

    public function eraseFrame(): void;

    public function getWriter(): IWriter;

    public function getRenderer(): IRenderer;
}
