<?php

declare(strict_types=1);
// 17.06.22
namespace AlecRabbit\Spinner\Core\Wiggler;

use AlecRabbit\Spinner\Core\Wiggler\Contract\ICycle;

final class Cycle implements ICycle
{
    private readonly int $num;
    private int $current = 0;

    public function __construct(int $total)
    {
        $this->num = $total - 1;
    }

    public function completed(): bool
    {
        if (0 === $this->current) {
            $this->current = $this->num;
            return true;
        }
        $this->current--;
        return false;
    }

}
