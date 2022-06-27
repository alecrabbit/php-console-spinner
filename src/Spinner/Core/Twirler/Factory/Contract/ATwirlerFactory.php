<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract\CharPattern;
use AlecRabbit\Spinner\Core\Contract\StylePattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\ICharRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IStyleRevolver;
use AlecRabbit\Spinner\Core\Revolver\Factory\Contract\ICharRevolverFactory;
use AlecRabbit\Spinner\Core\Revolver\Factory\Contract\IStyleRevolverFactory;
use AlecRabbit\Spinner\Core\Twirler\Builder\Contract\ITwirlerBuilder;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;
use AlecRabbit\Spinner\Core\Twirler\Twirler;
use AlecRabbit\Spinner\Exception\MethodNotImplementedException;

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
            ->build();
    }

    public function message(): ITwirler
    {
        return $this->twirlerBuilder->build();
    }

    public function progress(): ITwirler
    {
        return $this->twirlerBuilder->build();
    }

}
