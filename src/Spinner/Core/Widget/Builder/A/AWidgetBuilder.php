<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Builder\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use LogicException;

abstract class AWidgetBuilder
{
    protected ?IFrame $leadingSpacer = null;
    protected ?IRevolver $revolver = null;
    protected ?IFrame $trailingSpacer = null;


    protected function validate(): void
    {
        match (true) {
            null === $this->revolver => throw new LogicException('Revolver is not set.'),
            $this->leadingSpacer === null => throw new LogicException('Leading spacer is not set.'),
            $this->trailingSpacer === null => throw new LogicException('Trailing spacer is not set.'),
            default => null,
        };
    }
}
