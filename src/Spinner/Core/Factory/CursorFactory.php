<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\IOutput;
use AlecRabbit\Spinner\Contract\OptionCursor;
use AlecRabbit\Spinner\Core\Config\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\ICursorFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IOutputFactory;
use AlecRabbit\Spinner\Core\Output\Contract\ICursor;
use AlecRabbit\Spinner\Core\Output\Cursor;

final class CursorFactory implements ICursorFactory
{

    public function __construct(
        protected IDefaultsProvider $defaultsProvider,
        protected IOutputFactory $outputFactory,
    ) {
    }

    public function createCursor(): ICursor
    {
        return
            new Cursor(
                $this->getOutput(),
                $this->getCursorOption()
            );
    }

    protected function getOutput(): IOutput
    {
        return $this->outputFactory->getOutput();
    }

    protected function getCursorOption(): OptionCursor
    {
        return $this->defaultsProvider->getAuxSettings()->getCursorOption();
    }
}