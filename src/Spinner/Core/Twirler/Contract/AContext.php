<?php

declare(strict_types=1);
// 25.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Contract;

abstract class AContext implements IContext
{
    protected readonly ITwirler $twirler;

    public function __construct(
        ITwirler $twirler,
    ) {
        $this->setTwirler($twirler);
    }

    public function setTwirler(ITwirler $twirler): void
    {
        $this->twirler = $twirler;
        $this->twirler->setContext($this);
    }

    public function render(): ITwirlerFrame
    {
        return $this->twirler->render();
    }
}
