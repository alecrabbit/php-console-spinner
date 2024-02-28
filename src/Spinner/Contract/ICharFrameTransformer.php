<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface ICharFrameTransformer extends IFrameTransformer
{
    public function transform(IFrame $frame): ICharSequenceFrame;
}
