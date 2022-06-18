<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Spinner\Core\Contract;

interface IStyleProvider
{
    public function __construct(IStylePatternExtractor $extractor);

    public function provide(array $pattern): array;
}
