<?php
declare(strict_types=1);
// 28.03.23
namespace AlecRabbit\Spinner\Core\Output\Contract;

use AlecRabbit\Spinner\Core\Output\Cursor;

interface ICursor
{
    public function show(): ICursor;

    public function hide(): ICursor;
}