<?php declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Jugglers\Contracts;

interface JugglerInterface
{
    public function getFrame(): string;

    public function getFrameErasingLength(): int;
}
