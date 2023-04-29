<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras;

use AlecRabbit\Spinner\Contract\Pattern\IProceduralPattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Extras\Revolver\ProceduralRevolver;

final class ProceduralFrameRevolverBuilder extends AFrameRevolverBuilder
{
    public function build(): IFrameRevolver
    {
        self::assertPattern($this->pattern);
        if ($this->pattern instanceof IProceduralPattern) {
            return new ProceduralRevolver(
                $this->pattern->getProcedure(),
                $this->pattern->getInterval()
            );
        }
        return parent::build();
    }
}