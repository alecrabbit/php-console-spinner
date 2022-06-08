<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

abstract class AStyleRotor extends ARotor implements IStyleRotor
{
    public function __construct(
        ?array $data = null,
        protected readonly ?int $colorSupportLevel = null,
        protected readonly string $leadingSpacer = Base\C::EMPTY_STRING,
        protected readonly string $trailingSpacer = Base\C::EMPTY_STRING,
    ) {
        parent::__construct($data);
    }

    public function join(string $chars, float|int|null $interval = null): string
    {
        return $this->addSpacers($chars); // no styling
    }

    protected function addSpacers(string $chars): string
    {
        return $this->leadingSpacer . $chars . $this->trailingSpacer;
    }
}
