<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Builder\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;
use AlecRabbit\Spinner\Exception\LogicException;

abstract class AWidgetBuilder
{
    protected ?IFrame $leadingSpacer = null;
    protected ?IFrame $trailingSpacer = null;
    protected ?IWidgetRevolver $revolver = null;

    protected function validate(): void
    {
        match (true) {
            $this->revolver === null => throw new LogicException('Revolver is not set.'),
            $this->leadingSpacer === null => throw new LogicException('Leading spacer is not set.'),
            $this->trailingSpacer === null => throw new LogicException('Trailing spacer is not set.'),
            default => null,
        };
    }
}
