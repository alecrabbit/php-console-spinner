<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\TestCase\Stub;

use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Contract\Output\IWritableStream;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopSetup;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;

class WidgetFactoryTestStub implements IInvokable
{
    public function __construct(
        private readonly WidgetFactoryObjectWrapper $value,
    )
    {
    }

    public function __invoke(): IWidgetFactory
    {
        return $this->value->get();
    }
}
