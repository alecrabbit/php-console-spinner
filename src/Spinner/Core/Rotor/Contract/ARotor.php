<?php

declare(strict_types=1);
// 07.06.22
namespace AlecRabbit\Spinner\Core\Rotor\Contract;

use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;

abstract class ARotor implements IRotor
{
    protected const DATA = [];
    protected int $currentIndex = 0;
    protected array $data;
    protected readonly int $dataLength;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        ?array $data = null,
        protected ?IInterval $interval = null,
    ) {
        $this->data = static::refineData($data);
        $this->dataLength = count($this->data);
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function refineData(?array $data): array
    {
        $data = $data ?? static::DATA;
        static::assertData($data);
        return $data;
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function assertData(array $data): void
    {
        if (!array_is_list($data)) {
            throw new InvalidArgumentException('Given data array is not a list');
        }
    }

    public function next(?IInterval $interval = null): string
    {
        if (0 === $this->dataLength) {
            return '';
        }
        if (++$this->currentIndex === $this->dataLength) {
            $this->currentIndex = 0;
        }
        return $this->nextElement($interval);
    }

    protected function nextElement(?IInterval $interval = null): string
    {
        return (string)$this->data[$this->currentIndex];
    }
}
