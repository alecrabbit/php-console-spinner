<?php

declare(strict_types=1);
// 18.02.23
namespace AlecRabbit\Spinner\Asynchronous\Loop\Adapter\A;

use AlecRabbit\Spinner\Contract\ILoop;
use AlecRabbit\Spinner\Contract\ILoopGetter;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Factory\A\ADefaultsAwareClass;
use AlecRabbit\Spinner\Exception\RuntimeException;
use AlecRabbit\Spinner\Helper\Asserter;
use Closure;

abstract class ALoopAdapter extends ADefaultsAwareClass implements ILoop, ILoopGetter
{
    protected static function error(): bool
    {
        // will be `null` if error handler set by `set_error_handler()` successfully handled the error
        $error = error_get_last(); // [889ad594-ca28-4770-bb38-fd5bd8cb1777]

        return
            (bool)(
                ($error['type'] ?? 0)
                &
                (E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR | E_RECOVERABLE_ERROR)
            );
    }

    public function setSignalHandlers(iterable $handlers): void
    {
        foreach ($handlers as $signal => $handler) {
            $this->onSignal($signal, $handler);
        }
    }

    abstract protected function onSignal(int $signal, Closure $closure): void;

    /** @inheritdoc */
    public function createSignalHandlers(ISpinner $spinner): iterable
    {
        $this->assertExtPcntl();
        return $this->doCreateHandlers($spinner);
    }

    /**
     * @throws RuntimeException
     */
    protected function assertExtPcntl(): void
    {
        Asserter::assertExtensionLoaded('pcntl', 'Signal handling requires the pcntl extension.');
    }

    protected function doCreateHandlers(ISpinner $spinner): iterable
    {
        yield from [
            SIGINT => function () use ($spinner): void {
                $spinner->interrupt();
                $this->stop();
            },
        ];
    }

    public function stop(): void
    {
        $this->getLoop()->stop();
    }

    abstract public function repeat(float $interval, Closure $closure): void;

    public function run(): void
    {
        $this->getLoop()->run();
    }
}
