<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Cycle;
use AlecRabbit\Spinner\Core\CycleVisitor;
use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;
use AlecRabbit\Spinner\Core\Mixin\CanAcceptCycleVisitor;
use AlecRabbit\Spinner\Core\Mixin\CanAcceptIntervalVisitor;
use AlecRabbit\Spinner\Core\Mixin\HasMethodGetInterval;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirlerContext;
use AlecRabbit\Spinner\Core\Twirler\TwirlerContext;
use RuntimeException;
use WeakMap;

abstract class AContainer implements IContainer
{
    use CanAcceptIntervalVisitor;
    use CanAcceptCycleVisitor;
    use HasMethodGetInterval;

    /** @var TwirlerContext[] */
    protected array $contexts = [];
    protected WeakMap $contextsMap;
    protected Cycle $cycle;
    protected int $index = 0;
    protected ?ITwirlerContext $spinnerContext = null;
    protected ?ITwirlerContext $progressContext = null;
    protected ?ITwirlerContext $messageContext = null;

    public function __construct(
        protected IInterval $interval,
        protected readonly IIntervalVisitor $intervalVisitor,
        protected readonly bool $wasCreatedEmpty = false,
    ) {
        $this->cycle = new Cycle(1);
        $this->contextsMap = new WeakMap();
    }

    public function remove(ITwirlerContext|ITwirler $element): void
    {
        if ($element instanceof ITwirlerContext) {
            $index = $this->contextsMap[$element];
            unset($this->contexts[$index]);
        }
        if ($element instanceof ITwirler) {
            foreach ($this->contexts as $index => $context) {
                if ($context->getTwirler() === $element) {
                    unset($this->contexts[$index]);
                    break;
                }
            }
        }
    }

    public function render(): iterable
    {
        foreach ($this->contexts as $context) {
            yield $context->getTwirler();
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

    public function getCycleVisitor(): ICycleVisitor
    {
        return new CycleVisitor($this->interval);
    }

    public function spinner(ITwirler $twirler): void
    {
        $this->assertIsNotMulti();
        if ($this->spinnerContext === null) {
            $this->spinnerContext = $this->add($twirler);
            return;
        }
        $this->spinnerContext->setTwirler($twirler);
    }

    private function assertIsNotMulti(): void
    {
        if ($this->wasCreatedEmpty()) {
            throw new RuntimeException(
                sprintf('%s is a multi-spinner container', static::class),
            );
        }
    }

    public function wasCreatedEmpty(): bool
    {
        return $this->wasCreatedEmpty;
    }

    public function add(ITwirler $twirler): ITwirlerContext
    {
        $context = new TwirlerContext($twirler);
        $this->contexts[$this->index] = $context;
        $this->contextsMap[$context] = $this->index;
        $this->index++;
        return $context;
    }

    public function progress(ITwirler $twirler): void
    {
        $this->assertIsNotMulti();
        if ($this->progressContext === null) {
            $this->progressContext = $this->add($twirler);
            return;
        }
        $this->progressContext->setTwirler($twirler);
    }

    public function message(ITwirler $twirler): void
    {
        $this->assertIsNotMulti();
        if ($this->messageContext === null) {
            $this->messageContext = $this->add($twirler);
            return;
        }
        $this->messageContext->setTwirler($twirler);
    }
}
