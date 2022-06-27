<?php

declare(strict_types=1);
// 17.06.22
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ICycle;

final class Cycle implements ICycle
{
    private readonly int $num;
    private int $current = 0;

    public function __construct(int $total)
    {
        $this->num = self::refine($total);
    }

    private static function refine(int $total): int
    {
        --$total;
        if (0 > $total) {
            return 0;
        }
        return $total;
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
