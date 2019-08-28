<?php declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Jugglers\Contracts;

interface JugglerInterface
{
    /**
     * @return string
     */
    public function getFrame(): string;

    /**
     * @return int
     */
    public function getFrameErasingLength(): int;
}
