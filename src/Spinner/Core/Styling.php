<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Accessories\Circular;

/**
 * Class Styling
 */
class Styling
{
    /** @var string */
    private $message;
    /** @var Circular */
    private $symbols;

    public function __construct(Circular $symbols, string $message)
    {
        $this->symbols = $symbols;
        $this->message = $message;
    }

    public function spinner(): string
    {
        return (string)$this->symbols->value();
    }

    public function message(): string
    {
        return $this->message;
    }

    protected function circular(): Circular
    {
        $a = [
            '203',
            '209',
            '215',
            '221',
            '227',
            '191',
            '155',
            '119',
            '83',
            '84',
            '85',
            '86',
            '87',
            '81',
            '75',
            '69',
            '63',
            '99',
            '135',
            '171',
            '207',
            '206',
            '205',
            '204',
        ];
        return
            new Circular(
                array_map(
                    static function ($value) {
                        return '38;5;' . $value;
                    },
                    $a
                )
            );
    }

}