<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Tools;

use AlecRabbit\Spinner\Settings\Property;
use PHPUnit\Framework\TestCase;

class PropertyTest extends TestCase
{
    protected const VALUE = 'Processing';

    /** @test */
    public function instance(): void
    {
        $new_value = 'new_value';
        $property = new Property(self::VALUE);
        $this->assertEquals(self::VALUE, $property->getValue());
        $this->assertTrue($property->isDefault());
        $this->assertFalse($property->isNotDefault());
        $property->setValue($new_value);
        $this->assertEquals($new_value, $property->getValue());
        $this->assertFalse($property->isDefault());
        $this->assertTrue($property->isNotDefault());
    }

    /** @test */
    public function instanceWithoutValue(): void
    {
        $new_value = 'new_value';
        $property = new Property();
        $this->assertEquals(null, $property->getValue());
        $this->assertTrue($property->isDefault());
        $this->assertFalse($property->isNotDefault());
        $property->setValue($new_value);
        $this->assertEquals($new_value, $property->getValue());
        $this->assertFalse($property->isDefault());
        $this->assertTrue($property->isNotDefault());
    }

    /**
     * @test
     * @dataProvider valueDataProvider
     * @param mixed $first_value
     * @param mixed $seconds_value
     */
    public function values($first_value, $seconds_value): void
    {
        $property = new Property($first_value);
        $this->assertSame($first_value, $property->getValue());
        $this->assertTrue($property->isDefault());
        $this->assertFalse($property->isNotDefault());
        $property->setValue($seconds_value);
        $this->assertSame($seconds_value, $property->getValue());
        $this->assertFalse($property->isDefault());
        $this->assertTrue($property->isNotDefault());
    }

    public function valueDataProvider(): array
    {
        return [
            [1, 2],
            [null, 2],
            [null, '2'],
            [null, true],
            [null, false],
            [true, false],
            [true, null],
            [false, true],
            [false, null],
            [[], [null]],
            [[null], []],
            [null, [0 => 1]],
            [null, new Property(1)],
            ['null', 'new Property(1)'],
        ];
    }
}
