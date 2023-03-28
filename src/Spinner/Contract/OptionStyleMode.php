<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

enum OptionStyleMode: int
{
    case NONE = 0;
    case ANSI4 = 16;
    case ANSI8 = 256;
    case ANSI24 = 65535;

    public function lowest(?self $other): self
    {
        if (null === $other) {
            return $this;
        }

        if ($this->value <= $other->value) {
            return $this;
        }
        return $other;
    }

    public function highest(?self $other): self
    {
        if (null === $other) {
            return $this;
        }

        if ($this->value >= $other->value) {
            return $this;
        }
        return $other;
    }

    public function isStylingEnabled(): bool
    {
        return $this->value > 0;
    }
}
