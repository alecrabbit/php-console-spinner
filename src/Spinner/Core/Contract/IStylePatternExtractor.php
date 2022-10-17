<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use JetBrains\PhpStorm\ArrayShape;

interface IStylePatternExtractor // TODO (2022-10-17 13:09) [Alec Rabbit]: type may be related to [e68824d4-3908-49e4-9daf-73777963d37b]
{
    /**
     * @throws InvalidArgumentException
     */
    #[ArrayShape([C::STYLES => "array"])]
    public function extract(array $stylePattern): array;
}
