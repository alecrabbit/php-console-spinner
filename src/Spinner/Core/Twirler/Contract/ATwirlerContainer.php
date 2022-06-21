<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Contract;

use WeakMap;

abstract class ATwirlerContainer implements ITwirlerContainer
{
    /** @var ITwirler[] */
    protected array $twirlers = [];
    /** @var WeakMap<int,ITWirler> */
    protected WeakMap $twirlersMap;
    protected int $index = 0;

    public function __construct()
    {
        $this->twirlersMap = new WeakMap();
    }

    public function addTwirler(ITwirler $twirler): CanAddTwirler
    {
        $this->twirlers[$this->index] = $twirler;
        $this->twirlersMap[$twirler] = $this->index++;
        return $this;
    }

    public function render(): iterable
    {
        yield from $this->twirlers;
    }
}
