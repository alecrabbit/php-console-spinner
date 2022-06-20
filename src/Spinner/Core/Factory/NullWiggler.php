<?php

declare(strict_types=1);
// 17.06.22
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\Base\C;
use AlecRabbit\Spinner\Core\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Exception\MethodNotImplementedException;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Rotor\Contract\IRotor;
use AlecRabbit\Spinner\Core\Rotor\Contract\IStyleRotor;
use AlecRabbit\Spinner\Core\Wiggler\Contract\AWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IWiggler;

final class NullWiggler extends AWiggler
{
    private ICharFrame $frame;

    /** @noinspection MagicMethodsValidityInspection */
    protected function __construct()
    {
        $this->frame =
            new CharFrame(
                C::EMPTY_STRING,
                0,
            );
    }

    public static function create(IStyleRotor $style = null, IRotor $rotor = null): IWiggler
    {
        return new self();
    }

    protected static function assertWiggler(IWiggler|string|null $wiggler): void
    {
        // Intentionally left blank
    }

    public function render(): ICharFrame
    {
        return $this->frame;
    }

    public function update(IWiggler|string|null $wiggler): IWiggler
    {
        throw new MethodNotImplementedException(__METHOD__);
    }
}
