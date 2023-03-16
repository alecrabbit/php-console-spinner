<?php

declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Core\Defaults\Contract;

interface IDriverSettings extends IDefaultsChild
{
    public static function getInstance(IDefaults $parent): static;

    public function getFinalMessage(): string;

    public function getInterruptMessage(): string;

    public function setFinalMessage(string $finalMessage): static;

    public function setInterruptMessage(string $interruptMessage): static;
}