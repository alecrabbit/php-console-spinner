<?php
// 19.03.23
namespace AlecRabbit\Spinner\Contract;

enum NormalizerMode
{
    case SMOOTH;
    case BALANCED;
    case PERFORMANCE;
    case SLOW;
    case STILL;

    public function getDivisor(): int
    {
        return match ($this) {
            self::SMOOTH => 20,
            self::BALANCED => 50,
            self::PERFORMANCE => 100,
            self::SLOW => 1000,
            self::STILL => 900000,
        };
    }
}