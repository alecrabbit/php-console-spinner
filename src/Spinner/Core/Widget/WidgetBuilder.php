<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use LogicException;

final class WidgetBuilder implements IWidgetBuilder
{
    protected ?IFrame $leadingSpacer = null;
    protected ?IFrame $trailingSpacer = null;
    protected ?IRevolver $revolver = null;

    public function build(): IWidgetComposite
    {
        $this->validate();

        return
            new Widget(
                $this->revolver,
                $this->leadingSpacer,
                $this->trailingSpacer,
            );
    }

    protected function validate(): void
    {
        match (true) {
            null === $this->revolver => throw new LogicException('Revolver is not set.'),
            null === $this->leadingSpacer => throw new LogicException('Leading spacer is not set.'),
            null === $this->trailingSpacer => throw new LogicException('Trailing spacer is not set.'),
            default => null,
        };
    }

    public function withWidgetRevolver(IRevolver $revolver): IWidgetBuilder
    {
        $this->revolver = $revolver;
        return $this;
    }

    public function withLeadingSpacer(?IFrame $frame): IWidgetBuilder
    {
        $this->leadingSpacer = $frame;
        return $this;
    }

    public function withTrailingSpacer(?IFrame $frame): IWidgetBuilder
    {
        $this->trailingSpacer = $frame;
        return $this;
    }
}
