<?php
declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core\Config\Contract;

interface IDriverConfig
{
    public function getInterruptMessage(): string;

    public function getFinalMessage(): string;
}