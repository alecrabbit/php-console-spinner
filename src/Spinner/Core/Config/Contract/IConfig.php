<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface IConfig
{
    /**
     * @param IConfigElement ...$settingsElements
     * @throws InvalidArgumentException
     */
    public function set(IConfigElement ...$settingsElements): void;

    /**
     * @param class-string<IConfigElement> $id
     * @return IConfigElement|null
     * @throws InvalidArgumentException
     */
    public function get(string $id): ?IConfigElement;
}
