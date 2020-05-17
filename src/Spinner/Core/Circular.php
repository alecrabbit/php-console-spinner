<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

class Circular
{
    /** @var mixed */
    protected $data;

    /** @var bool */
    protected $oneElement = false;

    /** @var int */
    protected $idx = -1; // To pass tests written before

    /** @var int */
    protected $length = 0;

    /**
     * Circular constructor.
     * @param array<mixed> $data
     */
    public function __construct(array $data)
    {
        $this->data = $this->refineData($data);
    }

    /**
     * @param array<mixed> $data
     * @return mixed
     */
    protected function refineData(array $data)
    {
        $this->length = count($data);
        if (1 === $this->length) {
            $this->oneElement = true;
            return reset($data);
        }
        if (0 === $this->length) {
            $this->oneElement = true;
            return null;
        }
        return $data;
    }

    /**
     * @return mixed
     */
    public function __invoke()
    {
        return $this->value();
    }

    /**
     * @return mixed
     */
    public function value()
    {
        if ($this->oneElement) {
            return $this->data;
        }
        if (++$this->idx === $this->length) {
            $this->idx = 0;
        }
        return $this->data[$this->idx];
    }
}
