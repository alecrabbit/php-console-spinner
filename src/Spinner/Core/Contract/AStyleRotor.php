<?php
declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

abstract class AStyleRotor extends ARotor
{
    public function __construct(
        protected readonly ?int $colorSupportLevel = null,
        protected readonly string $leadingSpacer = '',
        protected readonly string $trailingSpacer = '',
    ) {
        parent::__construct();
    }
}
