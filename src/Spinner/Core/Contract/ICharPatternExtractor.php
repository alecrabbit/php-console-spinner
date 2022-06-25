<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use JetBrains\PhpStorm\ArrayShape;

interface ICharPatternExtractor
{
    /**
     * @throws InvalidArgumentException
     */
    #[ArrayShape([C::CHARS => "array"])]
    public function extract(array $charPattern): array;
}
