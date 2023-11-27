<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface IRenderable
{
    /**
     * @param float|null $dt Delta time. If null, internal timer will be used do determine delta time.
     */
    public function render(?float $dt = null): void;
}
