<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\A;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\Revolver\A\ARevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Factory\FrameFactory;

abstract class AWidgetRevolver extends ARevolver
{
    public function __construct(
        protected IRevolver $style,
        protected IRevolver $character,
    ) {
        $interval =
            $style->getInterval()->smallest(
                $character->getInterval()
            );
        parent::__construct($interval);
    }

    public function update(float $dt = null): IFrame
    {
        $style = $this->style->update($dt);
        $char = $this->character->update($dt);
        return
            new Frame(
                sprintf($style->sequence(), $char->sequence()),
                $style->width() + $char->width()
            );
    }

    protected function next(float $dt = null): void
    {
        // do nothing
    }

    protected function current(): IFrame
    {
        return FrameFactory::createEmpty(); // should never be called
    }

}
