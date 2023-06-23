<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Builder;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Builder\A\AWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetCompositeBuilder;
use AlecRabbit\Spinner\Core\Widget\WidgetComposite;

final class WidgetCompositeBuilder extends AWidgetBuilder implements IWidgetCompositeBuilder
{
    public function build(): IWidgetComposite
    {
        $this->validate();

        return
            new WidgetComposite(
                $this->revolver,
                $this->leadingSpacer,
                $this->trailingSpacer,
            );
    }

    public function withWidgetRevolver(IRevolver $revolver): IWidgetCompositeBuilder
    {
        $this->revolver = $revolver;
        return $this;
    }

    public function withLeadingSpacer(IFrame $frame): IWidgetCompositeBuilder
    {
        $this->leadingSpacer = $frame;
        return $this;
    }

    public function withTrailingSpacer(IFrame $frame): IWidgetCompositeBuilder
    {
        $this->trailingSpacer = $frame;
        return $this;
    }
}
