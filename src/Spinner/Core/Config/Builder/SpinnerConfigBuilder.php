<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Core\Config\Builder\Contract\ISpinnerConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Config\SpinnerConfig;
use AlecRabbit\Spinner\Core\Contract\Base\C;
use AlecRabbit\Spinner\Core\Contract\Base\Defaults;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\IRenderer;
use AlecRabbit\Spinner\Core\Contract\IWigglerContainer;
use AlecRabbit\Spinner\Core\Contract\IWriter;
use AlecRabbit\Spinner\Core\Driver;
use AlecRabbit\Spinner\Core\Exception\DomainException;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Core\Exception\LogicException;
use AlecRabbit\Spinner\Core\Factory\LoopFactory;
use AlecRabbit\Spinner\Core\Output\StdErrOutput;
use AlecRabbit\Spinner\Core\Renderer;
use AlecRabbit\Spinner\Core\Rotor\NoCharsRotor;
use AlecRabbit\Spinner\Core\Rotor\NoStyleRotor;
use AlecRabbit\Spinner\Core\Rotor\RainbowStyleRotor;
use AlecRabbit\Spinner\Core\Rotor\SnakeCharsRotor;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IWiggler;
use AlecRabbit\Spinner\Core\Wiggler\MessageWiggler;
use AlecRabbit\Spinner\Core\Wiggler\ProgressWiggler;
use AlecRabbit\Spinner\Core\Wiggler\RevolveWiggler;
use AlecRabbit\Spinner\Core\WigglerContainer;
use AlecRabbit\Spinner\Core\Writer;

final class SpinnerConfigBuilder implements ISpinnerConfigBuilder
{
    private const MESSAGE_ON_EXIT = Defaults::MESSAGE_ON_EXIT;
    private const SHUTDOWN_DELAY = Defaults::SHUTDOWN_DELAY;

    private ILoop $loop;
    private IDriver $driver;
    private IWigglerContainer $wigglers;
    private bool $synchronousMode;
    private float $shutdownDelaySeconds;
    private string $exitMessage;

    /**
     * @throws DomainException
     * @throws InvalidArgumentException
     */
    public function __construct()
    {
        $this->synchronousMode = false;
        $this->loop = self::getLoop();
        $this->driver = self::createDriver();
        $this->wigglers = self::createWigglerContainer();
        $this->exitMessage = self::MESSAGE_ON_EXIT;
        $this->shutdownDelaySeconds = self::SHUTDOWN_DELAY;
    }

    /**
     * @throws DomainException
     */
    private static function getLoop(): ILoop
    {
        return LoopFactory::getLoop();
    }

    private static function createDriver(): IDriver
    {
        return
            new Driver(
                self::createWriter(),
                self::createRenderer(),
            );
    }

    private static function createWriter(): IWriter
    {
        return new Writer(new StdErrOutput());
    }

    private static function createRenderer(): IRenderer
    {
        return
            new Renderer();
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function createWigglerContainer(): IWigglerContainer
    {
        return
            new WigglerContainer(
                self::createRevolveWiggler(['⠏', '⠛', '⠹', '⢸', '⣰', '⣤', '⣆', '⡇',]),
                self::createProgressWiggler(),
                self::createRevolveWiggler(['🕐', '🕑', '🕒', '🕓', '🕔', '🕕', '🕖', '🕗', '🕘', '🕙', '🕚', '🕛',], 2, ' '),
                self::createMessageWiggler(),
                self::createRevolveWiggler(['🌘', '🌗', '🌖', '🌕', '🌔', '🌓', '🌒', '🌑',], 2, ' '),
            );
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function createRevolveWiggler(array $data, int $width = 1, string $leadingSpacer = C::EMPTY_STRING): IWiggler
    {
        return
            RevolveWiggler::create(
                new RainbowStyleRotor(),
                new SnakeCharsRotor(
                    data: $data,
                    width: $width,
                    leadingSpacer: $leadingSpacer,
                ),
            );
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function createProgressWiggler(): IWiggler
    {
        return
            ProgressWiggler::create(
                new NoStyleRotor(),
                new NoCharsRotor(),
            );
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function createMessageWiggler(): IWiggler
    {
        return
            MessageWiggler::create(
                new NoStyleRotor(),
            );
    }

    public function withExitMessage(string $exitMessage): self
    {
        $clone = clone $this;
        $clone->exitMessage = $exitMessage;
        return $clone;
    }

    public function withShutdownDelayMicroseconds(int $shutdownDelay): self
    {
        $clone = clone $this;
        $clone->shutdownDelaySeconds = round($shutdownDelay / 1000, 3);
        return $clone;
    }

    public function withLoop(ILoop $loop): self
    {
        $clone = clone $this;
        $clone->loop = $loop;
        return $clone;
    }

    public function withWigglers(IWigglerContainer $wigglers): self
    {
        $clone = clone $this;
        $clone->wigglers = $wigglers;
        return $clone;
    }

    public function inSynchronousMode(): self
    {
        $clone = clone $this;
        $clone->synchronousMode = true;
        return $clone;
    }

    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    public function build(): ISpinnerConfig
    {
        return
            new SpinnerConfig(
                driver: $this->driver,
                wigglers: $this->wigglers,
                shutdownDelay: $this->shutdownDelaySeconds,
                exitMessage: $this->exitMessage,
                loop: self::refineLoop($this->loop, $this->synchronousMode),
                synchronous: $this->synchronousMode,
            );
    }

    private static function refineLoop(ILoop $loop, bool $synchronousMode): ?ILoop
    {
        if (!$synchronousMode) {
            return $loop;
        }
        return null;
    }
}
