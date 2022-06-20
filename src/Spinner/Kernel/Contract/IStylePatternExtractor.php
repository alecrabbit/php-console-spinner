<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Spinner\Kernel\Contract;

use AlecRabbit\Spinner\Core\Contract\C;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use JetBrains\PhpStorm\ArrayShape;

interface IStylePatternExtractor
{
    /**
     * @throws InvalidArgumentException
     */
    #[ArrayShape([C::STYLES => "array"])]
    public function extract(array $stylePattern): array;
}
