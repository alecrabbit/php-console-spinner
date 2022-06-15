<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Rotor\Contract;

use AlecRabbit\Spinner\Core\Contract\Base\C;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Core\WidthDefiner;

abstract class AStringRotor extends ARotor implements IStringRotor
{
    protected const ELEMENT_WIDTH = 0;
    protected int $width;

    public function __construct(
        ?array $data = null,
        ?int $width = null,
        protected readonly string $leadingSpacer = C::EMPTY_STRING,
        protected readonly string $trailingSpacer = C::EMPTY_STRING,
    ) {
        parent::__construct($data);
        $this->width = static::refineWidth($width, $leadingSpacer, $trailingSpacer);
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function refineWidth(?int $width, string $leadingSpacer, string $trailingSpacer): int
    {
        static::assertWidth($width);
        return WidthDefiner::define($width ?? static::ELEMENT_WIDTH, $leadingSpacer, $trailingSpacer);
    }

    /**
     * @throws InvalidArgumentException
     */
    protected static function assertWidth(?int $width): void
    {
        if (null === $width) {
            return;
        }
        if (0 > $width) {
            throw new InvalidArgumentException('Width must be a positive integer.');
        }
        // TODO (2022-06-07 16:13) [Alec Rabbit]: check other conditions
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    protected function nextElement(?IInterval $interval = null): string
    {
        return
            $this->addSpacers(
                parent::nextElement($interval)
            );
    }

    protected function addSpacers(string $chars): string
    {
        return $this->leadingSpacer . $chars . $this->trailingSpacer;
    }

}
