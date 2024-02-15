<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\A\ARevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;

final class WidgetRevolver extends ARevolver implements IWidgetRevolver
{
    public function __construct(
        private readonly IRevolver $style,
        private readonly IRevolver $character,
        IIntervalComparator $intervalComparator,
    ) {
        parent::__construct(
            $intervalComparator->smallest(
                $style->getInterval(),
                $character->getInterval(),
            ),
        );
    }

    private function createFrame(string $sequence, int $width): ICharFrame
    {
        return new CharFrame($sequence, $width);
    }

    public function getFrame(?float $dt = null): IFrame
    {
        $style = $this->style->getFrame($dt);
        $char = $this->character->getFrame($dt);

        return $this->createFrame(
            sprintf($style->getSequence(), $char->getSequence()),
            $style->getWidth() + $char->getWidth()
        );
    }
}
