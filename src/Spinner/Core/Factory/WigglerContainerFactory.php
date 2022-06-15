<?php

declare(strict_types=1);
// 09.06.22
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\Base\C;
use AlecRabbit\Spinner\Core\Contract\Base\Defaults;
use AlecRabbit\Spinner\Core\Contract\Base\StylePattern;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\IStyleCollection;
use AlecRabbit\Spinner\Core\Contract\IWigglerContainer;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Core\Factory\Contract\IWigglerContainerFactory;
use AlecRabbit\Spinner\Core\FrameCollection;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\Rotor\FrameRotor;
use AlecRabbit\Spinner\Core\Rotor\NoCharsRotor;
use AlecRabbit\Spinner\Core\Rotor\NoStyleRotor;
use AlecRabbit\Spinner\Core\Rotor\StyleRotor;
use AlecRabbit\Spinner\Core\StyleCollection;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IWiggler;
use AlecRabbit\Spinner\Core\Wiggler\MessageWiggler;
use AlecRabbit\Spinner\Core\Wiggler\ProgressWiggler;
use AlecRabbit\Spinner\Core\Wiggler\RevolveWiggler;
use AlecRabbit\Spinner\Core\WigglerContainer;
use JetBrains\PhpStorm\ArrayShape;

use const AlecRabbit\Cli\TERM_NOCOLOR;

final class WigglerContainerFactory implements IWigglerContainerFactory
{
    private const FRAME_SEQUENCE = Defaults::FRAME_SEQUENCE;

    private readonly IFrameCollection $frames;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        ?IFrameCollection $frames = null,
        private readonly int $terminalColorSupport = TERM_NOCOLOR,
        private readonly ?IInterval $interval = null,
    ) {
        $this->frames = $frames ?? self::defaultFrames();
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function defaultFrames(): IFrameCollection
    {
        return FrameCollection::create(...self::FRAME_SEQUENCE);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function createContainer(): IWigglerContainer
    {
        return
            new WigglerContainer(
                $this->interval ?? $this->frames->getInterval(),
                $this->createRevolveWiggler($this->frames),
                self::createMessageWiggler(),
                self::createProgressWiggler(),
            );
    }

    /**
     * @throws InvalidArgumentException
     */
    private function createRevolveWiggler(IFrameCollection $frames): IWiggler
    {
        return
            RevolveWiggler::create(
                new StyleRotor($this->defaultStyles()),
                new FrameRotor(
                    frames: $frames,
                ),
            );
    }

    private function defaultStyles(): IStyleCollection
    {
        return
            StyleCollection::create(
                ...$this->extract($this->terminalColorSupport, StylePattern::rainbow())
            );
    }

    #[ArrayShape([0 => "array", C::INTERVAL => "int"])]
    private function extract(int $terminalColorSupport, array $pattern): array
    {
        $this->assert($pattern);
        return
            [
                [
                    C::SEQUENCE =>
                        $pattern[C::STYLES][$terminalColorSupport][C::SEQUENCE] ?? [],
                    C::FORMAT =>
                        $pattern[C::STYLES][$terminalColorSupport][C::FORMAT] ?? null,
                ],
                C::INTERVAL =>
                    $pattern[C::INTERVAL],
            ];
    }

    private function assert(array $pattern): void
    {
        // TODO (2022-06-15 17:58) [Alec Rabbit]: Implement [0393ca28-1910-4562-a348-0677aa8b4d46].
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

}
