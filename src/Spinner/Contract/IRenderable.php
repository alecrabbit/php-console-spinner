<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface IRenderable
{
    public function render(float $dt = null): void;
}
