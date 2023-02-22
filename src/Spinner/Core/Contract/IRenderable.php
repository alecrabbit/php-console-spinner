<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface IRenderable
{
    public function render(float $dt = null): void;
}
