<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Config\Defaults\Contract;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface ISettableDefaults extends IDefaults
{
    /**
     * @param resource $stream
     * @throws InvalidArgumentException
     */
    public function setOutputStream($stream): ISettableDefaults;

    public function setHideCursor(bool $hideCursor): ISettableDefaults;

    /**
     * @throws InvalidArgumentException
     */
    public function setColorSupportLevels(array $colorSupportLevels): ISettableDefaults;

    public function setIntervalMilliseconds(int $defaultInterval): ISettableDefaults;

    public function setCreateInitialized(bool $createInitialized): ISettableDefaults;

    public function setPercentNumberFormat(string $percentNumberFormat): ISettableDefaults;

    public function setMainLeadingSpacer(IFrame $mainLeadingSpacer): ISettableDefaults;

    public function setMainTrailingSpacer(IFrame $mainTrailingSpacer): ISettableDefaults;

    public function setFinalMessage(string $finalMessage): ISettableDefaults;

//    public function setDefaultLeadingSpacer(IFrame $defaultLeadingSpacer): ISettableDefaults;
//
//    public function setDefaultTrailingSpacer(IFrame $defaultTrailingSpacer): ISettableDefaults;

    public function setShutdownDelay(float|int $shutdownDelay): ISettableDefaults;

//    public function setModeSynchronous(bool $modeSynchronous): ISettableDefaults;

//    public function setClasses(IClasses $classes): ISettableDefaults;

    public function setAutoStart(bool $autoStart): ISettableDefaults;

    public function setAttachSignalHandlers(bool $attachSignalHandlers): ISettableDefaults;

    /**
     * @throws InvalidArgumentException
     */
    public function setLoopProbes(iterable $loopProbes): ISettableDefaults;
}
