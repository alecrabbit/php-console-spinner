<?php
declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;

abstract class ACharsRotor extends ARotor implements ICharsRotor
{
    protected const ELEMENT_WIDTH = 0;
    protected int $width;

    public function __construct(
        ?array $data = null,
        ?int $width = null,
    ) {
        parent::__construct($data);
        $this->width = static::refineWidth($width);
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function refineWidth(?int $width): int
    {
        static::assertWidth($width);
        return $width ?? static::ELEMENT_WIDTH;
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

}
