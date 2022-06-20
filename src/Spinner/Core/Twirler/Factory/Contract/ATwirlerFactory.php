<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Factory\Contract;

use AlecRabbit\Spinner\Core\Revolver\Contract\ICharRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IStyleRevolver;
use AlecRabbit\Spinner\Core\Revolver\Factory\Contract\ICharRevolverFactory;
use AlecRabbit\Spinner\Core\Revolver\Factory\Contract\IStyleRevolverFactory;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;
use AlecRabbit\Spinner\Core\Twirler\Twirler;

abstract class ATwirlerFactory implements ITwirlerFactory
{
    public function __construct(
        protected readonly IStyleRevolverFactory $styleRevolverFactory,
        protected readonly ICharRevolverFactory $charRevolverFactory,
    ) {
    }

    public function create(?IStyleRevolver $styleRevolver = null, ?ICharRevolver $charRevolver = null): ITwirler
    {
        $styleRevolver = $styleRevolver ?? $this->styleRevolverFactory->create();
        $charRevolver = $charRevolver ?? $this->charRevolverFactory->create();

        return
            new Twirler(
                styleRevolver: $styleRevolver,
                charRevolver: $charRevolver
            );
    }
}
