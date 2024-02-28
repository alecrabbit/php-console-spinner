<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface IStyleFrameTransformer extends IFrameTransformer
{
    public function transform(IFrame $frame): IStyleSequenceFrame;
}
