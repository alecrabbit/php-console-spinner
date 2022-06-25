<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;
use AlecRabbit\Spinner\Core\Mixin\CanAcceptIntervalVisitor;
use AlecRabbit\Spinner\Core\Mixin\HasMethodGetInterval;
use AlecRabbit\Spinner\Core\Twirler\Context;
use AlecRabbit\Spinner\Core\Twirler\Contract\CanAddTwirler;
use AlecRabbit\Spinner\Core\Twirler\Contract\IContext;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;
use WeakMap;

abstract class AContainer implements IContainer
{
    use CanAcceptIntervalVisitor;
    use HasMethodGetInterval;

    /** @var ITwirler[] */
    protected array $twirlers = [];
    /** @var WeakMap<ITWirler,int> */
    protected WeakMap $twirlersMap;
    protected int $index = 0;

    /** @var Context[] */
    protected array $contexts = [];

    public function __construct(
        protected IInterval $interval,
        protected readonly IIntervalVisitor $intervalVisitor,
    ) {
        $this->twirlersMap = new WeakMap();
    }

    public function add(ITwirler $twirler): IContext
    {
        $context = new Context($twirler);
        $this->contexts[] = $context;
//        $this->addTwirler($twirler);
        return $context;
    }

    public function addTwirler(ITwirler $twirler): CanAddTwirler
    {
        $this->twirlers[$this->index] = $twirler;
        $this->twirlersMap[$twirler] = $this->index++;
        return $this;
    }

    public function render(): iterable
    {
        foreach ($this->contexts as $context) {
            yield $context->twirler;
        }
    }

    /**
     * @return IIntervalComponent[]
     */
    public function getIntervalComponents(): iterable
    {
        yield from $this->contexts;
    }

    public function getIntervalVisitor(): IIntervalVisitor
    {
        return $this->intervalVisitor;
    }
}
