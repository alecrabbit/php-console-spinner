<?php

declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Core\Defaults\Contract;

interface IDriverSettings
{
    public static function getInstance(): static;

    public function getFinalMessage(): string;

    public function getInterruptMessage(): string;
}