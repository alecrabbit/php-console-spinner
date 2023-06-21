<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetCompositeChildrenContainer;

final class WidgetCompositeChildrenContainer extends ASubject implements IWidgetCompositeChildrenContainer
{
    public function update(ISubject $subject): void
    {
        // TODO: Implement update() method.
        throw new \RuntimeException('Not implemented.');
    }
}
