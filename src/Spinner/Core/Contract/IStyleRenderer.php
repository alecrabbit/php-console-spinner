<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Spinner\Core\Contract;

interface IStyleRenderer
{
    public function __construct(IStylePatternExtractor $extractor);

    public function render(array $pattern): array;
}
