<?php

declare(strict_types=1);
// 07.06.22
namespace AlecRabbit\Spinner\Core\Contract;

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
    ) {
        $data = static::refineData($data);
        $this->data = $data;
        $this->dataLength = count($this->data);
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function refineData(?array $data): array
    {
        static::assertData($data);
        return $data ?? static::DATA;
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function assertData(?array $data): void
    {
        if(null === $data) {
            return;
        }
        if(!array_is_list($data)) {
            throw new InvalidArgumentException('Data must be a list array');
        }
    }

    public function next(float|int|null $interval = null): string
    {
        if (0 === $this->dataLength) {
            return '';
        }
        if (++$this->currentIndex === $this->dataLength) {
            $this->currentIndex = 0;
        }
        return $this->nextElement($interval);
    }

    protected function nextElement(float|int|null $interval = null): string
    {
        return (string)static::DATA[$this->currentIndex];
    }
}
