<?php
declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface IMessageWiggler extends IWiggler
{
    public function message(IMessageWiggler|string $message): IMessageWiggler;
}
