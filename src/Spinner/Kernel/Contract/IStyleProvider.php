<?php

declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Spinner\Kernel\Contract;

interface IStyleProvider
{
    public function provide(array $pattern): array;
}
