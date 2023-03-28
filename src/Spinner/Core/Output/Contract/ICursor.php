<?php

declare(strict_types=1);
// 28.03.23
namespace AlecRabbit\Spinner\Core\Output\Contract;

interface ICursor
{
    public function show(?IOutputBuffer $buffer = null): ICursor;

    public function hide(?IOutputBuffer $buffer = null): ICursor;

    public function moveLeft(int $columns = 1, ?IOutputBuffer $buffer = null): ICursor;
}