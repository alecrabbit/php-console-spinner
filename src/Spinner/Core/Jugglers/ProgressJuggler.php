<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Jugglers;

class ProgressJuggler
{
    /** @var array */
    protected $progress;

    public function __construct(float $percent)
    {
        $this->progress = $percent;
    }

    public function setProgress(float $percent): void
    {
        $this->progress = $percent;
    }

}