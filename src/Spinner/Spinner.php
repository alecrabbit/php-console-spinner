<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Contract\ABaseSpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;

final class Spinner extends ABaseSpinner implements ISpinner
{
    public function spinner(ITwirler|string|null $twirler): void
    {
        // TODO: Implement spinner() method.
    }

    public function progress(float|ITwirler|string|null $twirler): void
    {
        // TODO: Implement progress() method.
    }

    public function message(ITwirler|string|null $twirler): void
    {
        // TODO: Implement message() method.
    }
}
