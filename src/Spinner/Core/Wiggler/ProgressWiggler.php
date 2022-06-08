<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Wiggler;

use AlecRabbit\Spinner\Core\Exception\RuntimeException;
use AlecRabbit\Spinner\Core\Wiggler\Contract\AWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IProgressWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IWiggler;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;

final class ProgressWiggler extends AWiggler implements IProgressWiggler
{
    /**
     * @throws RuntimeException
     */
    public function update(IWiggler|string|float|null $wiggler): IWiggler
    {
//        self::assertWiggler($wiggler);
//        return
//            $wiggler instanceof IProgressWiggler
//                ? $wiggler
//                : self::create(
//                $this->styleRotor,
//                message: $wiggler ?? C::DEFAULT_MESSAGE,
//            );
    }

    protected function createSequence(?IInterval $interval = null): string
    {
        return '';
    }

    protected static function assertWiggler(float|IWiggler|string|null $wiggler): void
    {
        if (null === $wiggler || is_float($wiggler) || $wiggler instanceof IProgressWiggler) {
            return;
        }
        throw new RuntimeException(
            'Message variable must be a float, null or an instance of IProgressWiggler'
        );
    }
}
