<?php
declare(strict_types=1);
// 07.06.22
namespace AlecRabbit\Spinner\Core\Contract;

abstract class ARotor implements IRotor
{
    abstract public function next(float|int|null $interval = null): string;
}
