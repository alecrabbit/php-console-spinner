<?php

declare(strict_types=1);
// 07.06.22
namespace AlecRabbit\Spinner\Kernel\Rotor\Contract;

use AlecRabbit\Spinner\Kernel\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\ICycle;
use AlecRabbit\Spinner\Kernel\Wiggler\Cycle;
use AlecRabbit\Spinner\Kernel\Wiggler\CycleCalculator;

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
        protected ?WIInterval $interval = null,
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

    public function getInterval(?WIInterval $preferredInterval = null): ?WIInterval
    {
        dump(__METHOD__);
        if ($preferredInterval instanceof WIInterval) {
            $this->setCycles($preferredInterval);
        }
        return $this->interval;
    }

    private function setCycles(WIInterval $preferredInterval): void
    {
        $this->cycle = new Cycle(CycleCalculator::calculate($preferredInterval, $this->interval));
    }
}
