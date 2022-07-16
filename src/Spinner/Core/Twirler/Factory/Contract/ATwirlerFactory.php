<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Factory\Contract;

use AlecRabbit\Spinner\Core\Collection\CharFrameCollection;
use AlecRabbit\Spinner\Core\Contract\CharPattern;
use AlecRabbit\Spinner\Core\Contract\StylePattern;
use AlecRabbit\Spinner\Core\Frame\CharFrame;
use AlecRabbit\Spinner\Core\Interval\Interval;
use AlecRabbit\Spinner\Core\Twirler\Builder\Contract\ITwirlerBuilder;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;
use AlecRabbit\Spinner\Core\WidthDefiner;

abstract class ATwirlerFactory implements ITwirlerFactory
{
    public function __construct(
        private readonly ITwirlerBuilder $twirlerBuilder,
    ) {
    }

//    public function createTwirler(?IStyleRevolver $styleRevolver = null, ?ICharRevolver $charRevolver = null): ITwirler
//    {
//        throw new MethodNotImplementedException(__METHOD__);
//        $styleRevolver = $styleRevolver ?? $this->styleRevolverFactory->create();
//        $charRevolver = $charRevolver ?? $this->charRevolverFactory->create();
//
//        return
//            new Twirler(
//                styleRevolver: $styleRevolver,
//                charRevolver: $charRevolver
//            );
//    }
//
    public function spinner(): ITwirler
    {
        return
            $this->twirlerBuilder
                ->withStylePattern(StylePattern::rainbow())
                ->withCharPattern(CharPattern::DIAMOND)
                ->build()
        ;
    }

    public function message(string|null $value): ITwirler
    {
        return $this->twirlerBuilder->build();
    }

    public function progress(string|float|null $value): ITwirler
    {
        if (is_float($value)) {
            $value = sprintf('%0.2f%%', $value);
        }

        if($value === null) {
            $value = '';
        }
        $charFrame = CharFrame::create(
            $value,
            WidthDefiner::define($value)
        );
        return
            $this->twirlerBuilder
                ->withCharCollection(
                    CharFrameCollection::create(
                        [
                            $charFrame,
                        ],
                        Interval::createDefault()
                    )
                )->build();
    }

}
