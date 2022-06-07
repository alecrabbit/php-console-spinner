<?php
declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Wiggler\Contract;

use AlecRabbit\Spinner\Core\Contract\ACharRotor;
use AlecRabbit\Spinner\Core\Contract\AStyleRotor;
use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IWiggler;
use AlecRabbit\Spinner\Core\Frame;

abstract class AWiggler implements IWiggler
{
    public function __construct(
        protected readonly AStyleRotor $colorRotor,
        protected readonly ACharRotor $charRotor,
        protected readonly string $leadingSpacer = '',
        protected readonly string $trailingSpacer = '',
        protected readonly ?int $colorSupportLevel = null,
    ) {
    }

    abstract protected function getSequence(float|int|null $interval = null): string;

    public function getFrame(float|int|null $interval = null): IFrame
    {
        return
            new Frame(
                $this->getSequence($interval),
                $this->charRotor->getWidth(),
            );
    }
}
