<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Core\Config\Solver\A\ASolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ISignalHandlersContainerSolver;
use AlecRabbit\Spinner\Core\ISignalHandlersContainer;
use AlecRabbit\Spinner\Core\Settings\Contract\IHandlerCreator;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISignalHandlerCreator;
use AlecRabbit\Spinner\Core\Settings\Contract\ISignalHandlerSettings;
use AlecRabbit\Spinner\Core\SignalHandlersContainer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use ArrayObject;
use Traversable;

final readonly class SignalHandlersContainerSolver extends ASolver implements ISignalHandlersContainerSolver
{
    public function solve(): ISignalHandlersContainer
    {
        return
            $this->doSolve(
                $this->extractSignalHandlerCreators($this->settingsProvider->getUserSettings()),
                $this->extractSignalHandlerCreators($this->settingsProvider->getDetectedSettings()),
                $this->extractSignalHandlerCreators($this->settingsProvider->getDefaultSettings()),
            );
    }

    private function doSolve(
        ?Traversable $userCreators,
        ?Traversable $detectedCreators,
        ?Traversable $defaultCreators,
    ): ISignalHandlersContainer {
        return
            new SignalHandlersContainer(
                $this->mergeSignalHandlerCreators(
                    $userCreators,
                    $detectedCreators,
                    $defaultCreators
                )
            );
    }

    /**
     * @return Traversable<int, IHandlerCreator>
     *
     * @throws InvalidArgumentException
     */
    private function mergeSignalHandlerCreators(
        ?Traversable $userCreators,
        ?Traversable $detectedCreators,
        ?Traversable $defaultCreators
    ): Traversable {
        $merged =
            iterator_to_array($this->unwrap($userCreators ?? new ArrayObject([]))) +
            iterator_to_array($this->unwrap($detectedCreators ?? new ArrayObject([]))) +
            iterator_to_array($this->unwrap($defaultCreators ?? new ArrayObject([])));

        return
            new ArrayObject($merged);
    }

    /**
     * @return Traversable<int, IHandlerCreator>
     *
     * @throws InvalidArgumentException
     */
    private function unwrap(Traversable $creators): Traversable
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

    protected function extractSignalHandlerCreators(ISettings $settings): ?Traversable
    {
        return $this->extractSettingsElement($settings, ISignalHandlerSettings::class)?->getCreators();
    }
}
