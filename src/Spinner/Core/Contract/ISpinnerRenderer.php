<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IInitializable;

interface ISpinnerRenderer extends IInitializable
{
    public function render(?ISpinner $spinner): void;
}
