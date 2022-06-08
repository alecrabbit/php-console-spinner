<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Rotor\Contract;

abstract class AStyleRotor extends ARotor implements IStyleRotor
{
    public function __construct(
        ?array $data = null,
        protected readonly ?int $colorSupportLevel = null,
    ) {
        parent::__construct($data);
    }

    public function join(string $chars, float|int|null $interval = null): string
    {
        return $chars; // no styling
    }

}
