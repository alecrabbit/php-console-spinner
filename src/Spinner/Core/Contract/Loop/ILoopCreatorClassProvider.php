<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract\Loop;

interface ILoopCreatorClassProvider
{
    /** @return class-string<ILoopCreator>|null */
    public function getCreatorClass(): ?string;
}
