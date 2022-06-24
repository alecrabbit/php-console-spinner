<?php

declare(strict_types=1);
// 22.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Builder\Contract;

use AlecRabbit\Spinner\Core\Collection\Contract\ICharFrameCollection;
use AlecRabbit\Spinner\Core\Collection\Contract\IStyleFrameCollection;
use AlecRabbit\Spinner\Core\Collection\Factory\Contract\ICharFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Collection\Factory\Contract\IStyleFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Contract\C;
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
    protected const FRAME_COLLECTION = C::FRAME . C::SPACE_CHAR . C::COLLECTION;
    protected const FRAME_COLLECTION_FACTORY = self::FRAME_COLLECTION . C::SPACE_CHAR . C::FACTORY;
    protected const PATTERN = C::PATTERN;
    protected const REVOLVER = C::REVOLVER;
    protected const STYLE = C::STYLE;
    protected const CHAR = C::CHAR;

    protected const ERROR_MESSAGE_FORMAT = '[%s::%s()]: %s %s is already set.';

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
        self::assertForStylePattern($this, __FUNCTION__);
        $clone = clone $this;
        $clone->stylePattern = $stylePattern;
        return $clone;
    }

    protected static function assertForStylePattern(ATwirlerBuilder $builder, string $methodName): void
    {
        $kind = 'Style';
        $type = self::PATTERN;
        match (true) {
            null !== $builder->stylePattern =>
            throw self::getInvalidArgumentException($methodName, self::STYLE, self::PATTERN),
            null !== $builder->styleRevolver =>
            throw self::getInvalidArgumentException($methodName, self::STYLE, self::REVOLVER),
            null !== $builder->styleFrameCollection =>
            throw self::getInvalidArgumentException($methodName, self::STYLE, self::FRAME_COLLECTION),
            default => null,
        };
    }

    protected static function getInvalidArgumentException(
        string $methodName,
        string $kind,
        string $type
    ): InvalidArgumentException {
        return new InvalidArgumentException(
            sprintf(
                self::ERROR_MESSAGE_FORMAT,
                static::class,
                $methodName,
                \ucfirst($kind),
                $type
            )
        );
    }

    public function withCharPattern(array $charPattern): ITwirlerBuilder
    {
        self::assertForCharPattern($this, __FUNCTION__);
        $clone = clone $this;
        $clone->charPattern = $charPattern;
        return $clone;
    }

    protected static function assertForCharPattern(ATwirlerBuilder $builder, string $methodName): void
    {
        match (true) {
            null !== $builder->charPattern =>
            throw self::getInvalidArgumentException($methodName, self::CHAR, self::PATTERN),
            null !== $builder->charRevolver =>
            throw self::getInvalidArgumentException($methodName, self::CHAR, self::REVOLVER),
            null !== $builder->charFrameCollection =>
            throw self::getInvalidArgumentException($methodName, self::CHAR, self::FRAME_COLLECTION),
            default => null,
        };
    }

    public function withStyleFrameCollectionFactory(
        IStyleFrameCollectionFactory $styleFrameCollectionFactory
    ): ITwirlerBuilder {
        self::assertForStyleFrameCollectionFactory($this, __FUNCTION__);
        $clone = clone $this;
        $clone->styleFrameCollectionFactory = $styleFrameCollectionFactory;
        return $clone;
    }

    protected static function assertForStyleFrameCollectionFactory(ATwirlerBuilder $builder, string $methodName): void
    {
        match (true) {
            null !== $builder->styleFrameCollectionFactory =>
            throw self::getInvalidArgumentException($methodName, self::STYLE, self::FRAME_COLLECTION_FACTORY),
            null !== $builder->styleFrameCollection =>
            throw self::getInvalidArgumentException($methodName, self::STYLE, self::FRAME_COLLECTION),
            default => null,
        };
    }

    public function withCharFrameCollectionFactory(
        ICharFrameCollectionFactory $charFrameCollectionFactory
    ): ITwirlerBuilder {
        self::assertForCharFrameCollectionFactory($this, __FUNCTION__);
        $clone = clone $this;
        $clone->charFrameCollectionFactory = $charFrameCollectionFactory;
        return $clone;
    }

    protected static function assertForCharFrameCollectionFactory(ATwirlerBuilder $builder, string $methodName): void
    {
        match (true) {
//            null !== $builder->charFrameCollectionFactory =>
//            throw new InvalidArgumentException('Char frame collection factory is already set.'),
            null !== $builder->charFrameCollection =>
            throw self::getInvalidArgumentException($methodName, self::CHAR, self::FRAME_COLLECTION),
            default => null,
        };
    }

    public function withStyleCollection(IStyleFrameCollection $styleCollection): ITwirlerBuilder
    {
        self::assertForStyleCollection($this, __FUNCTION__);
        $clone = clone $this;
        $clone->styleFrameCollection = $styleCollection;
        return $clone;
    }

    protected static function assertForStyleCollection(ATwirlerBuilder $builder, string $methodName): void
    {
        match (true) {
            null !== $builder->styleFrameCollection =>
            throw self::getInvalidArgumentException($methodName, self::STYLE, self::FRAME_COLLECTION),
//            null !== $builder->styleFrameCollectionFactory =>
//            throw new InvalidArgumentException('Style frame collection factory is already set.'),
            default => null,
        };
    }

    public function withCharCollection(ICharFrameCollection $charCollection): ITwirlerBuilder
    {
        self::assertForCharCollection($this, __FUNCTION__);
        $clone = clone $this;
        $clone->charFrameCollection = $charCollection;
        return $clone;
    }

    protected static function assertForCharCollection(ATwirlerBuilder $builder, string $methodName): void
    {
        match (true) {
            null !== $builder->charFrameCollection =>
            throw self::getInvalidArgumentException($methodName, self::CHAR, self::FRAME_COLLECTION),
//            null !== $builder->charFrameCollectionFactory =>
//            throw new InvalidArgumentException('Char frame collection factory is already set.'),
            default => null,
        };
    }

    public function withStyleRevolver(IStyleRevolver $styleRevolver): ITwirlerBuilder
    {
        self::assertForStyleRevolver($this, __FUNCTION__);
        $clone = clone $this;
        $clone->styleRevolver = $styleRevolver;
        return $clone;
    }

    protected static function assertForStyleRevolver(ATwirlerBuilder $builder, string $methodName): void
    {
        match (true) {
            null !== $builder->styleRevolver =>
            throw self::getInvalidArgumentException($methodName, self::STYLE, self::REVOLVER),
            null !== $builder->styleFrameCollection =>
            throw self::getInvalidArgumentException($methodName, self::STYLE, self::FRAME_COLLECTION),
            default => null,
        };
    }

    public function withCharRevolver(ICharRevolver $charRevolver): ITwirlerBuilder
    {
        self::assertForCharRevolver($this, __FUNCTION__);
        $clone = clone $this;
        $clone->charRevolver = $charRevolver;
        return $clone;
    }

    protected static function assertForCharRevolver(ATwirlerBuilder $builder, string $methodName): void
    {
        match (true) {
            null !== $builder->charRevolver =>
            throw self::getInvalidArgumentException($methodName, self::CHAR, self::REVOLVER),
            null !== $builder->charFrameCollection =>
            throw self::getInvalidArgumentException($methodName, self::CHAR, self::FRAME_COLLECTION),
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
