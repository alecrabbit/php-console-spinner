<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Tools;

use AlecRabbit\Spinner\Core\Coloring;
use AlecRabbit\Spinner\Core\Contracts\StylesInterface;
use PHPUnit\Framework\TestCase;

class ColoringTest extends TestCase
{
    /**
     * @test
     * @dataProvider stylesDataProvider
     * @param array $styles
     * @param string $exceptionMessage
     */
    public function instance(array $styles, string $exceptionMessage): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage($exceptionMessage);
        $coloring = new Coloring($styles);
    }

    public function stylesDataProvider(): array
    {
        return [
            [[], 'Styles array does not have [' . StylesInterface::SPINNER_STYLES . '] key.'],
        ];
    }
}
