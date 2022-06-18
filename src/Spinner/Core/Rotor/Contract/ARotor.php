<?php

declare(strict_types=1);
// 07.06.22
namespace AlecRabbit\Spinner\Core\Rotor\Contract;

use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Core\Wiggler\Contract\ICycle;
use AlecRabbit\Spinner\Core\Wiggler\Cycle;
use AlecRabbit\Spinner\Core\Wiggler\CycleCalculator;

abstract class ARotor implements IRotor
{
    protected const DATA = [];
    protected ICycle $cycle;
    protected int $currentIndex = 0;
    protected array $data;
    protected readonly int $dataLength;
    protected string $currentFrame;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        ?array $data = null,
        protected ?IInterval $interval = null,
    ) {
        $this->data = static::refineData($data);
        $this->dataLength = count($this->data);
        $this->cycle = new Cycle(1);
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
            throw new InvalidArgumentException('Given data array is not a list.');
        }
    }

    public function next(): string
    {
        if (0 === $this->dataLength) {
            return '';
        }
        if (1 === $this->dataLength) {
            return $this->render();
        }
        if (++$this->currentIndex === $this->dataLength) {
            $this->currentIndex = 0;
        }
        return $this->render();
    }

    protected function render(): string
    {
        if ($this->cycle->completed()) {
            return
                $this->currentFrame =
                    (string)$this->data[$this->currentIndex];
        }
        return
            $this->currentFrame;
    }

    public function getInterval(?IInterval $preferredInterval = null): ?IInterval
    {
        dump(__METHOD__);
        if ($preferredInterval instanceof IInterval) {
            $this->setCycles($preferredInterval);
        }
        return $this->interval;
    }

    private function setCycles(IInterval $preferredInterval): void
    {
        $this->cycle = new Cycle(CycleCalculator::calculate($preferredInterval, $this->interval));
    }
}
