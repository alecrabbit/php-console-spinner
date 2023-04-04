<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface IStyleFrameCollectionRenderer extends IFrameCollectionRenderer
{
    public function defaultCollection(): IFrameCollection;
}
