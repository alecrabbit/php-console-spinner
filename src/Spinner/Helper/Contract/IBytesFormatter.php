<?php
declare(strict_types=1);
// 17.04.23
namespace AlecRabbit\Spinner\Helper\Contract;

interface IBytesFormatter
{
    public function format(int $bytes): string;
}
