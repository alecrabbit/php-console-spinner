<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract\CharPattern;
use AlecRabbit\Spinner\Core\Contract\IMessage;
use AlecRabbit\Spinner\Core\Contract\IProgress;
use AlecRabbit\Spinner\Core\Contract\StylePattern;
use AlecRabbit\Spinner\Core\Twirler\Builder\Contract\ITwirlerBuilder;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\MethodNotImplementedException;

abstract class ATwirlerFactory implements ITwirlerFactory
{
    public function __construct(
        protected readonly ITwirlerBuilder $twirlerBuilder,
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

//    private static function assertValue(float $value): void
//    {
//        if ($value < 0 || $value > 1) {
//            throw new InvalidArgumentException(
//                'Progress value must be between 0 and 1, ' . $value . ' given.'
//            );
//        }
//    }

    public function spinner(): ITwirler
    {
        // FIXME (2022-10-12 13:50) [Alec Rabbit]: Implement this
        throw new MethodNotImplementedException(__METHOD__);

// // Code for reference
//        return
//            $this->twirlerBuilder
//                ->withStylePattern(StylePattern::rainbow())
//                ->withCharPattern(CharPattern::DIAMOND)
//                ->build()
//        ;
    }

    public function message(IMessage $message): ITwirler
    {
        // FIXME (2022-10-12 13:50) [Alec Rabbit]: Implement this
        throw new MethodNotImplementedException(__METHOD__);

// // Code for reference
//        return $this->twirlerBuilder->build();
    }

    public function progress(IProgress $progress): ITwirler
    {
        // FIXME (2022-10-12 13:50) [Alec Rabbit]: Implement this
        throw new MethodNotImplementedException(__METHOD__);

// // Code for reference
//        if (is_float($progress)) {
//            self::assertValue($progress);
//            $progress = sprintf(Defaults::getProgressFormat(), $progress * 100);
//        }
//
//        if ($progress === null) {
//            $progress = '';
//        }
//        $charFrame = CharFrame::create(
//            $progress,
//            WidthDefiner::define($progress)
//        );
//        return
//            $this->twirlerBuilder
//                ->withCharCollection(
//                    CharFrameCollection::create(
//                        [
//                            $charFrame,
//                        ],
//                        Interval::createDefault()
//                    )
//                )->build();
    }

}
