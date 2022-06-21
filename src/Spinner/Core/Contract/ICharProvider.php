<?php
declare(strict_types=1);
// 21.06.22
namespace AlecRabbit\Spinner\Core\Contract;

interface ICharProvider
{
    public function provide(array $charPattern = null): array;
}
