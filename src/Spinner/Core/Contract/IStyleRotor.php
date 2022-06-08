<?php
declare(strict_types=1);
// 07.06.22
namespace AlecRabbit\Spinner\Core\Contract;

interface IStyleRotor
{
    public function join(string $chars, float|int|null $interval = null): string;

//    public function setLeadingSpacer(string $leadingSpacer): static;
}
