<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Core\Settings\Contract\ISignalHandlerCreator;
use AlecRabbit\Spinner\Core\Settings\Contract\ISignalHandlerSettings;
use ArrayObject;
use Traversable;

final readonly class SignalHandlerSettings implements ISignalHandlerSettings
{
    protected Traversable $creators;

    public function __construct(ISignalHandlerCreator ...$creators)
    {
        $this->creators = new ArrayObject($creators);
    }

    /**
     * @return class-string<ISignalHandlerSettings>
     */
    public function getIdentifier(): string
    {
        return ISignalHandlerSettings::class;
    }

    public function getCreators(): Traversable
    {
        return $this->creators;
    }
}
