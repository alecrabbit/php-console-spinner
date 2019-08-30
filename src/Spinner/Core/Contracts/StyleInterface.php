<?php declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Contracts;

use AlecRabbit\Accessories\Circular;

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
