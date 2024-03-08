<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\CursorOption;
use AlecRabbit\Spinner\Contract\Option\InitializationOption;
use AlecRabbit\Spinner\Contract\Option\StylingOption;
use AlecRabbit\Spinner\Core\Settings\Contract\IOutputSettings;

final readonly class OutputSettings implements IOutputSettings
{
    public function __construct(
        private StylingOption $stylingOption = StylingOption::AUTO,
        private CursorOption $cursorOption = CursorOption::AUTO,
        private InitializationOption $initializationOption = InitializationOption::AUTO,
        private mixed $stream = null,
    ) {
    }

    public function getStylingOption(): StylingOption
    {
        return $this->stylingOption;
    }

    public function getCursorOption(): CursorOption
    {
        return $this->cursorOption;
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
