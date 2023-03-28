<?php
declare(strict_types=1);
// 28.03.23
namespace AlecRabbit\Spinner\Core\Output\Contract;

interface IOutputBuffer
{
    public function write(string $message): IOutputBuffer;

    public function flush(): void;
}