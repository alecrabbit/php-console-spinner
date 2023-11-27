<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\CursorVisibilityOption;
use AlecRabbit\Spinner\Contract\Option\InitializationOption;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Settings\Contract\IOutputSettings;

final readonly class OutputSettings implements IOutputSettings
{
    public function __construct(
        private StylingMethodOption $stylingMethodOption = StylingMethodOption::AUTO,
        private CursorVisibilityOption $cursorVisibilityOption = CursorVisibilityOption::AUTO,
        private InitializationOption $initializationOption = InitializationOption::AUTO,
        private mixed $stream = null,
    ) {
    }

    public function getStylingMethodOption(): StylingMethodOption
    {
        return $this->stylingMethodOption;
    }

    public function getCursorVisibilityOption(): CursorVisibilityOption
    {
        return $this->cursorVisibilityOption;
    }

    public function getInitializationOption(): InitializationOption
    {
        return $this->initializationOption;
    }

    public function getStream(): mixed
    {
        return $this->stream;
    }

    public function getIdentifier(): string
    {
        return IOutputSettings::class;
    }
}
