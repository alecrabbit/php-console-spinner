<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

interface IConfigElement
{
    /**
     * @return class-string<IConfigElement>
     */
    public function getIdentifier(): string;
}
