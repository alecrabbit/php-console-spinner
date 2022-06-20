<?php
declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Contract;

interface ISpinnerFactory
{
    public static function create(): IBaseSpinner;
}
