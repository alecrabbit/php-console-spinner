<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Revolver\Factory;

use AlecRabbit\Spinner\Core\Collection\Contract\IStyleFrameCollection;
use AlecRabbit\Spinner\Core\Collection\Factory\Contract\IStyleFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IStyleRevolver;
use AlecRabbit\Spinner\Core\Revolver\Factory\Contract\IStyleRevolverFactory;
use AlecRabbit\Spinner\Core\Revolver\StyleRevolver;

final class StyleRevolverFactory implements IStyleRevolverFactory
{
    public function __construct(
        protected readonly IStyleFrameCollectionFactory $styleFrameCollectionFactory,
    ) {
    }

    public function create(?IStyleFrameCollection $styleCollection = null): IStyleRevolver
    {
        $styleCollection = $styleCollection ?? $this->styleFrameCollectionFactory->create();

        return
            new StyleRevolver(
                $styleCollection
            );
    }
}
