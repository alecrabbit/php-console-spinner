<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Builder;


use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Widget\Builder\A\AWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;
use AlecRabbit\Spinner\Core\Widget\Widget;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class WidgetBuilder extends AWidgetBuilder implements IWidgetBuilder
{
    public function build(): IWidget
    {
        $this->validate();

        return
            new Widget(
                $this->revolver,
                $this->leadingSpacer,
                $this->trailingSpacer,
            );
    }

    public function withWidgetRevolver(IWidgetRevolver $revolver): IWidgetBuilder
    {
        $this->revolver = $revolver;
        return $this;
    }

    public function withLeadingSpacer(IFrame $frame): IWidgetBuilder
    {
        $this->leadingSpacer = $frame;
        return $this;
    }

    public function withTrailingSpacer(IFrame $frame): IWidgetBuilder
    {
        $this->trailingSpacer = $frame;
        return $this;
    }
}
