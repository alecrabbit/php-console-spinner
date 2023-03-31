<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\IPattern;
use AlecRabbit\Spinner\Core\Factory\A\AFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IRevolverFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;

final class RevolverFactory extends AFactory implements IRevolverFactory
{
    public function create(IPattern $pattern): IRevolver
    {
        return $this->getFrameRevolverBuilder()->withPattern($pattern)->build();
    }

    protected function getFrameRevolverBuilder(): IFrameRevolverBuilder
    {
        return $this->container->get(IFrameRevolverBuilder::class);
    }
}
