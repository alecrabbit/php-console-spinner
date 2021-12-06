<?php

declare(strict_types=1);

namespace AlecRabbit\SpinnerOld\Core\Jugglers\Contracts;

interface JugglerInterface
{
    /**
     * @return string
     */
    public function getStyledFrame(): string;

    /**
     * @return int
     */
    public function getFrameErasingWidth(): int;
}
