<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\IntervalComparator;
use AlecRabbit\Spinner\Core\Revolver\A\ARevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;
use AlecRabbit\Spinner\Exception\LogicException;

final class WidgetRevolver extends ARevolver implements IWidgetRevolver
{
    public function __construct(
        private readonly IRevolver $style,
        private readonly IRevolver $character,
        ITolerance $tolerance,
        IIntervalComparator $intervalComparator = new IntervalComparator(
        ), // FIXME (2023-11-21 17:34) [Alec Rabbit]: pass it as param it or better pass IInterval
    )
    {
        parent::__construct(
            $intervalComparator->smallest(
                $style->getInterval(),
                $character->getInterval(),
            ),
            $tolerance,
        );
    }

    public function getFrame(?float $dt = null): IFrame
    {
        $style = $this->style->getFrame($dt);
        $char = $this->character->getFrame($dt);
        return $this->createFrame(
            sprintf($style->sequence(), $char->sequence()),
            $style->width() + $char->width()
        );
    }

    private function createFrame(string $sequence, int $width): ICharFrame
    {
        return new CharFrame($sequence, $width);
    }

    // @codeCoverageIgnoreStart
    protected function next(?float $dt = null): void
    {
        throw new LogicException(
            sprintf(
                'Method %s() should never be called.',
                __METHOD__
            )
        );
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
    // @codeCoverageIgnoreEnd
}
