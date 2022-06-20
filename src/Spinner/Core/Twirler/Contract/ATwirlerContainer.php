<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Contract;

abstract class ATwirlerContainer implements ITwirlerContainer
{
    protected array $twirlers = [];
    protected \WeakMap $twirlersMap;
    protected int $twirlerIndex = 0;

    public function __construct()
    {
        $this->twirlersMap = new \WeakMap();
    }

    public function addTwirler(ITwirler $twirler): CanAddTwirler
    {
        $this->twirlers[] = $twirler;
        $this->twirlersMap[$this->twirlerIndex++] = $twirler;
        return $this;
    }
}
