<?php

declare(strict_types=1);
// 17.02.23
namespace AlecRabbit\Spinner\Core\Loop;

use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Loop\A\ALoopAdapter;
use React\EventLoop\LoopInterface;
use React\EventLoop\TimerInterface;

final class ReactLoopAdapter extends ALoopAdapter
{
    private ?TimerInterface $spinnerTimer = null;

    public function __construct(
        private readonly LoopInterface $loop,
    ) {
    }

    public function attach(ISpinner $spinner): void
    {
        $this->detachPrevious();
        $this->spinnerTimer = $this->loop->addPeriodicTimer(
            $spinner->getInterval()->toSeconds(),
            static fn() => $spinner->spin()
        );
    }

    private function detachPrevious(): void
    {
        if ($this->spinnerTimer instanceof TimerInterface) {
            $this->loop->cancelTimer($this->spinnerTimer);
        }
    }

    public function autoStart(): void
    {
        // ReactPHP event loop is started by library code.
    }

    protected function doCreateHandlers(ISpinner $spinner): iterable
    {
        yield from [
            SIGINT => function () use ($spinner): void {
                $spinner->interrupt();
                $this->loop->stop();
            },
        ];
    }

    protected function onSignal(int $signal, mixed $handler): void
    {
        $this->loop->addSignal($signal, $handler);
    }
}
