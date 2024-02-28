<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface IFrameTransformer
{
    public function transform(IFrame $frame): ISequenceFrame;
}
