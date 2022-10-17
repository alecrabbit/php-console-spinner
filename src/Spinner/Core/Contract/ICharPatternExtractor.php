<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use JetBrains\PhpStorm\ArrayShape;

interface ICharPatternExtractor // TODO (2022-10-17 13:09) [Alec Rabbit]: type may be related to [f96f5d87-f9f9-46dc-a45b-8eecc2aba711]
{
    /**
     * @throws InvalidArgumentException
     */
    #[ArrayShape([C::CHARS => "array"])]
    public function extract(array $charPattern): array;
}
