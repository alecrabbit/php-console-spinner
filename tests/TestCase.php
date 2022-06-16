<?php
declare(strict_types=1);
// 16.06.22
namespace AlecRabbit\Tests\Spinner;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

abstract class TestCase extends PHPUnitTestCase
{
    protected const CONTAINS = 'contains';
    protected const COUNT = 'count';
    protected const INTERVAL = 'interval';
    protected const SEQUENCE = 'sequence';
    protected const EXCEPTION = 'exception';
    protected const _CLASS = 'class';
    protected const MESSAGE = 'message';


}
