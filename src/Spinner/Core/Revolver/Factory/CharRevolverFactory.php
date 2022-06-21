<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Revolver\Factory;

use AlecRabbit\Spinner\Core\Collection\Contract\ICharFrameCollection;
use AlecRabbit\Spinner\Core\Collection\Factory\Contract\ICharFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Revolver\CharRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\ICharRevolver;
use AlecRabbit\Spinner\Core\Revolver\Factory\Contract\ICharRevolverFactory;

final class CharRevolverFactory implements ICharRevolverFactory
{
    public function __construct(
        protected readonly ICharFrameCollectionFactory $charFrameCollectionFactory,
    ) {
    }

    public function create(?ICharFrameCollection $frameCollection = null): ICharRevolver
    {
        $frameCollection = $frameCollection ?? $this->charFrameCollectionFactory->create([], null);

        return
            new CharRevolver(
                $frameCollection
            );
    }
}
