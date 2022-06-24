<?php

declare(strict_types=1);
// 22.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Builder\Contract;

use AlecRabbit\Spinner\Core\Collection\Contract\ICharFrameCollection;
use AlecRabbit\Spinner\Core\Collection\Contract\IStyleFrameCollection;
use AlecRabbit\Spinner\Core\Collection\Factory\Contract\ICharFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Collection\Factory\Contract\IStyleFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Defaults;
use AlecRabbit\Spinner\Core\Revolver\CharRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\ICharRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IStyleRevolver;
use AlecRabbit\Spinner\Core\Revolver\StyleRevolver;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;
use AlecRabbit\Spinner\Core\Twirler\Twirler;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

abstract class ATwirlerBuilder
{
    protected ?array $stylePattern = null;
    protected ?array $charPattern = null;
    protected ?IStyleFrameCollectionFactory $styleFrameCollectionFactory = null;
    protected ?ICharFrameCollectionFactory $charFrameCollectionFactory = null;
    protected ?IStyleFrameCollection $styleFrameCollection = null;
    protected ?ICharFrameCollection $charFrameCollection = null;
    protected ?IStyleRevolver $styleRevolver = null;
    protected ?ICharRevolver $charRevolver = null;

    public function __construct(
        ?IStyleFrameCollectionFactory $styleFrameCollectionFactory = null,
        ?ICharFrameCollectionFactory $charFrameCollectionFactory = null,
    ) {
        $this->styleFrameCollectionFactory = $styleFrameCollectionFactory;
        $this->charFrameCollectionFactory = $charFrameCollectionFactory;
    }

    public function withStylePattern(array $stylePattern): ITwirlerBuilder
    {
        self::assertForStylePattern($this);
        $clone = clone $this;
        $clone->stylePattern = $stylePattern;
        return $clone;
    }

    private static function assertForStylePattern(ATwirlerBuilder $builder): void
    {
        match (true) {
            null !== $builder->stylePattern =>
            throw new InvalidArgumentException('Style pattern is already set.'),
            null !== $builder->styleRevolver =>
            throw new InvalidArgumentException('Style revolver is already set.'),
            null !== $builder->styleFrameCollection =>
            throw new InvalidArgumentException('Style frame collection is already set.'),
            default => null,
        };
    }

    public function withCharPattern(array $charPattern): ITwirlerBuilder
    {
        self::assertForCharPattern($this);
        $clone = clone $this;
        $clone->charPattern = $charPattern;
        return $clone;
    }

    private static function assertForCharPattern(ATwirlerBuilder $builder): void
    {
        match (true) {
            null !== $builder->charPattern =>
            throw new InvalidArgumentException('Char pattern is already set.'),
            null !== $builder->charFrameCollection =>
            throw new InvalidArgumentException('Char frame collection is already set.'),
            default => null,
        };
    }

    public function withStyleFrameCollectionFactory(
        IStyleFrameCollectionFactory $styleFrameCollectionFactory
    ): ITwirlerBuilder {
        self::assertForStyleFrameCollectionFactory($this);
        $clone = clone $this;
        $clone->styleFrameCollectionFactory = $styleFrameCollectionFactory;
        return $clone;
    }

    private static function assertForStyleFrameCollectionFactory(ATwirlerBuilder $builder): void
    {
        match (true) {
//            null !== $builder->styleFrameCollectionFactory =>
//            throw new InvalidArgumentException('Style frame collection factory is already set.'),
            null !== $builder->styleFrameCollection =>
            throw new InvalidArgumentException('Style frame collection is already set.'),
            default => null,
        };
    }

    public function withCharFrameCollectionFactory(
        ICharFrameCollectionFactory $charFrameCollectionFactory
    ): ITwirlerBuilder {
        self::assertForCharFrameCollectionFactory($this);
        $clone = clone $this;
        $clone->charFrameCollectionFactory = $charFrameCollectionFactory;
        return $clone;
    }

    private static function assertForCharFrameCollectionFactory(ATwirlerBuilder $builder): void
    {
        match (true) {
//            null !== $builder->charFrameCollectionFactory =>
//            throw new InvalidArgumentException('Char frame collection factory is already set.'),
            null !== $builder->charFrameCollection =>
            throw new InvalidArgumentException('Char frame collection is already set.'),
            default => null,
        };
    }

    public function withStyleCollection(IStyleFrameCollection $styleCollection): ITwirlerBuilder
    {
        self::assertForStyleCollection($this);
        $clone = clone $this;
        $clone->styleFrameCollection = $styleCollection;
        return $clone;
    }

    private static function assertForStyleCollection(ATwirlerBuilder $builder): void
    {
        match (true) {
            null !== $builder->styleFrameCollection =>
            throw new InvalidArgumentException('Style frame collection is already set.'),
//            null !== $builder->styleFrameCollectionFactory =>
//            throw new InvalidArgumentException('Style frame collection factory is already set.'),
            default => null,
        };
    }

    public function withCharCollection(ICharFrameCollection $charCollection): ITwirlerBuilder
    {
        self::assertForCharCollection($this);
        $clone = clone $this;
        $clone->charFrameCollection = $charCollection;
        return $clone;
    }

    private static function assertForCharCollection(ATwirlerBuilder $builder): void
    {
        match (true) {
            null !== $builder->charFrameCollection =>
            throw new InvalidArgumentException('Char frame collection is already set.'),
//            null !== $builder->charFrameCollectionFactory =>
//            throw new InvalidArgumentException('Char frame collection factory is already set.'),
            default => null,
        };
    }

    public function withStyleRevolver(IStyleRevolver $styleRevolver): ITwirlerBuilder
    {
        self::assertForStyleRevolver($this);
        $clone = clone $this;
        $clone->styleRevolver = $styleRevolver;
        return $clone;
    }

    private static function assertForStyleRevolver(ATwirlerBuilder $builder): void
    {
        match (true) {
            null !== $builder->styleRevolver =>
            throw new InvalidArgumentException('Style revolver is already set.'),
            null !== $builder->styleFrameCollection =>
            throw new InvalidArgumentException('Style frame collection is already set.'),
            default => null,
        };
    }

    public function withCharRevolver(ICharRevolver $charRevolver): ITwirlerBuilder
    {
        self::assertForCharRevolver($this);
        $clone = clone $this;
        $clone->charRevolver = $charRevolver;
        return $clone;
    }

    private static function assertForCharRevolver(ATwirlerBuilder $builder): void
    {
        match (true) {
            null !== $builder->charRevolver =>
            throw new InvalidArgumentException('Char revolver is already set.'),
            null !== $builder->charFrameCollection =>
            throw new InvalidArgumentException('Char frame collection is already set.'),
            default => null,
        };
    }

    public function build(): ITwirler
    {
        $this->processDefaults();

        return
            new Twirler(
                $this->styleRevolver,
                $this->charRevolver
            );
    }

    private function processDefaults(): void
    {
        if (null === $this->stylePattern) {
            $this->stylePattern = Defaults::getDefaultStylePattern();
        }

        if (null === $this->charPattern) {
            $this->charPattern = Defaults::getDefaultCharPattern();
        }

//        if (null === $this->styleFrameCollectionFactory) {
//            $this->styleFrameCollectionFactory =
//                $this->config->getStyleFrameCollectionFactory();
//        }
//
//        if (null === $this->charFrameCollectionFactory) {
//            $this->charFrameCollectionFactory =
//                $this->config->getCharFrameCollectionFactory();
//        }
//
        if (null === $this->styleFrameCollection) {
            $this->styleFrameCollection = $this->styleFrameCollectionFactory->create($this->stylePattern);
        }
        if (null === $this->charFrameCollection) {
            $this->charFrameCollection = $this->charFrameCollectionFactory->create($this->charPattern);
        }

        if (null === $this->styleRevolver) {
            $this->styleRevolver = new StyleRevolver($this->styleFrameCollection);
        }

        if (null === $this->charRevolver) {
            $this->charRevolver = new CharRevolver($this->charFrameCollection);
        }
    }
}
