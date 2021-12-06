<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Coloring\Contracts;

use AlecRabbit\Spinner\Core\Circular;

interface StyleInterface
{
    /**
     * @return Circular
     */
    public function getStyle(): Circular;

    /**
     * @return string
     */
    public function getFormat(): string;

    /**
     * @return string
     */
    public function getSpacer(): string;
}
