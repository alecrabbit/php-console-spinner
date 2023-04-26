<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\Revolver\A\ARevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;
use AlecRabbit\Spinner\Exception\LogicException;

final class WidgetRevolver extends ARevolver implements IWidgetRevolver
{
    public function __construct(
        protected IRevolver $style,
        protected IRevolver $character,
        int $deltaTolerance,
    ) {
        parent::__construct(
            $style->getInterval()
                ->smallest(
                    $character->getInterval()
                ),
            $deltaTolerance
        );
    }

    public function getFrame(?float $dt = null): IFrame
    {
        $style = $this->style->getFrame($dt);
        $char = $this->character->getFrame($dt);
        return new Frame(
            sprintf($style->sequence(), $char->sequence()),
            $style->width() + $char->width()
        );
    }

    protected function next(?float $dt = null): void
    {
        // do nothing
    }

    protected function current(): IFrame
    {
        throw new LogicException(
            sprintf(
                'Method %s() should never be called.',
                __METHOD__
            )
        );
    }
}
