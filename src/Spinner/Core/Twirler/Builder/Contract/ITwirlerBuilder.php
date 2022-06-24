<?php

declare(strict_types=1);
// 22.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Builder\Contract;

use AlecRabbit\Spinner\Core\Collection\Contract\ICharFrameCollection;
use AlecRabbit\Spinner\Core\Collection\Contract\IStyleFrameCollection;
use AlecRabbit\Spinner\Core\Collection\Factory\Contract\ICharFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Collection\Factory\Contract\IStyleFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\ICharRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IStyleRevolver;

interface ITwirlerBuilder
{
    public function withStyleRevolver(IStyleRevolver $styleRevolver): ITwirlerBuilder;

    public function withCharRevolver(ICharRevolver $charRevolver): ITwirlerBuilder;

    public function withStyleCollection(IStyleFrameCollection $styleCollection): ITwirlerBuilder;

    public function withCharCollection(ICharFrameCollection $charCollection): ITwirlerBuilder;

    public function withStylePattern(array $stylePattern): ITwirlerBuilder;

    public function withCharPattern(array $charPattern): ITwirlerBuilder;

    public function withStyleFrameCollectionFactory(
        IStyleFrameCollectionFactory $styleFrameCollectionFactory
    ): ITwirlerBuilder;

    public function withCharFrameCollectionFactory(
        ICharFrameCollectionFactory $charFrameCollectionFactory
    ): ITwirlerBuilder;
}
