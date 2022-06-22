<?php

declare(strict_types=1);
// 22.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Contract;

use AlecRabbit\Spinner\Core\Collection\CharFrameCollection;
use AlecRabbit\Spinner\Core\Collection\Contract\ICharFrameCollection;
use AlecRabbit\Spinner\Core\Collection\Contract\IStyleFrameCollection;
use AlecRabbit\Spinner\Core\Collection\Factory\Contract\ICharFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Collection\Factory\Contract\IStyleFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Defaults;
use AlecRabbit\Spinner\Core\Frame\CharFrame;
use AlecRabbit\Spinner\Core\Interval\Interval;
use AlecRabbit\Spinner\Core\Revolver\CharRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\ICharRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IStyleRevolver;
use AlecRabbit\Spinner\Core\Revolver\StyleRevolver;
use AlecRabbit\Spinner\Core\Twirler\Twirler;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

abstract class ATwirlerBuilder
{
    private ?IStyleRevolver $styleRevolver = null;
    private ?ICharRevolver $charRevolver = null;
    private ?IStyleFrameCollection $styleFrameCollection = null;
    private ?ICharFrameCollection $charFrameCollection = null;
    private ?array $stylePattern = null;
    private ?array $charPattern = null;

    public function __construct(
        private readonly IStyleFrameCollectionFactory $styleFrameCollectionFactory,
        private readonly ICharFrameCollectionFactory $charFrameCollectionFactory,
    ) {
    }

    public function withStyleRevolver(IStyleRevolver $styleRevolver): ITwirlerBuilder
    {
        $clone = clone $this;
        $clone->styleRevolver = $styleRevolver;
        return $clone;
    }

    public function withCharRevolver(ICharRevolver $charRevolver): ITwirlerBuilder
    {
        $clone = clone $this;
        $clone->charRevolver = $charRevolver;
        return $clone;
    }

    public function withStyleCollection(IStyleFrameCollection $styleCollection): ITwirlerBuilder
    {
        $clone = clone $this;
        $clone->styleFrameCollection = $styleCollection;
        return $clone;
    }

    public function withCharCollection(ICharFrameCollection $charCollection): ITwirlerBuilder
    {
        $clone = clone $this;
        $clone->charFrameCollection = $charCollection;
        return $clone;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function build(): ITwirler
    {
        $this->processDefaults();

        return
            new Twirler(
                $this->styleRevolver,
                $this->charRevolver
            );
    }

    /**
     * @throws InvalidArgumentException
     */
    private function processDefaults(): void
    {
        if (null === $this->stylePattern) {
            $this->stylePattern = Defaults::getDefaultStylePattern();
        }

        if (null === $this->charPattern) {
            $this->charPattern = Defaults::getDefaultCharPattern();
        }

        if (null === $this->styleFrameCollection) {
            $this->styleFrameCollection = $this->styleFrameCollectionFactory->create($this->stylePattern);
        }
        if (null === $this->charFrameCollection) {
            $this->charFrameCollection = $this->charFrameCollectionFactory->create($this->charPattern);
//                CharFrameCollection::create(
//                    [CharFrame::createEmpty()],
//                    Interval::createDefault()
//                );
        }

        if (null === $this->styleRevolver) {
            $this->styleRevolver = new StyleRevolver($this->styleFrameCollection);
        }

        if (null === $this->charRevolver) {
            $this->charRevolver = new CharRevolver($this->charFrameCollection);
        }
    }
}
