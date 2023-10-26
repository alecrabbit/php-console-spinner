<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Core\Config\Solver\A\ASolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ISignalHandlersContainerSolver;
use AlecRabbit\Spinner\Core\ISignalHandlersContainer;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISignalHandlerCreator;
use AlecRabbit\Spinner\Core\Settings\Contract\ISignalHandlerSettings;
use AlecRabbit\Spinner\Core\SignalHandlersContainer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

final readonly class SignalHandlersContainerSolver extends ASolver implements ISignalHandlersContainerSolver
{
    public function solve(): ISignalHandlersContainer
    {
        return
            $this->doSolve(
                $this->extractOption($this->settingsProvider->getUserSettings()),
                $this->extractOption($this->settingsProvider->getDetectedSettings()),
                $this->extractOption($this->settingsProvider->getDefaultSettings()),
            );
    }

    private function doSolve(
        ?\Traversable $userCreators,
        ?\Traversable $detectedCreators,
        ?\Traversable $defaultCreators,
    ): ISignalHandlersContainer {
        $signalHandlers =
            $this->mergeCreators($userCreators, $detectedCreators, $defaultCreators);

        return
            new SignalHandlersContainer($signalHandlers);
    }

    private function mergeCreators(
        ?\Traversable $userCreators,
        ?\Traversable $detectedCreators,
        ?\Traversable $defaultCreators
    ): \Traversable {
        $merged =
            iterator_to_array($this->extractCreators($userCreators ?? new \ArrayObject([]))) +
            iterator_to_array($this->extractCreators($detectedCreators ?? new \ArrayObject([]))) +
            iterator_to_array($this->extractCreators($defaultCreators ?? new \ArrayObject([])));

        return
            new \ArrayObject($merged);
    }

    private function extractCreators(\Traversable $creators): \Traversable
    {
        /** @var ISignalHandlerCreator $creator */
        foreach ($creators as $creator) {
            self::assertCreator($creator);
            yield $creator->getSignal() => $creator->getHandlerCreator();
        }
    }

    private static function assertCreator(mixed $creator): void
    {
        if (!($creator instanceof ISignalHandlerCreator)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Creator must be instance of "%s", "%s" given.',
                    ISignalHandlerCreator::class,
                    get_debug_type($creator)
                )
            );
        }
    }

    protected function extractOption(ISettings $settings): ?\Traversable
    {
        return $this->extractSettingsElement($settings, ISignalHandlerSettings::class)?->getCreators();
    }
}
