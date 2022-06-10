<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Rotor\Contract;

abstract class AWIPStyleRotor extends ARotor implements IWIPStyleRotor
{
    public function __construct(
        ?array $data = null,
        protected readonly ?int $colorSupportLevel = null,
    ) {
        parent::__construct($data);
    }

    public function join(string $chars, ?IInterval $interval = null): string
    {
        return $chars; // no styling
    }

}
