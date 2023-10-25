<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\CursorVisibilityOption;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Settings\Contract\IOutputSettings;

final class OutputSettings implements IOutputSettings
{
    public function __construct(
        protected StylingMethodOption $stylingMethodOption = StylingMethodOption::AUTO,
        protected CursorVisibilityOption $cursorVisibilityOption = CursorVisibilityOption::AUTO,
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

    public function getIdentifier(): string
    {
        return IOutputSettings::class;
    }
}
