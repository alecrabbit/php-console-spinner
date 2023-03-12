<?php

declare(strict_types=1);
// 10.03.23
namespace AlecRabbit\Spinner\Core\Pattern\A;

abstract class AReversiblePattern extends APattern
{
    public function __construct(
        ?int $interval = null,
        protected bool $reversed = false
    ) {
        parent::__construct($interval);
    }

    public function getPattern(): iterable
    {
        return
            $this->reversed
                ? array_reverse(iterator_to_array($this->pattern()))
                : $this->pattern();
    }

    abstract protected function pattern(): iterable;
}