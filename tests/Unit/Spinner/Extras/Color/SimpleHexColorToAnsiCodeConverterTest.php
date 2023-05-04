<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Unit\Spinner\Extras\Color;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Color\SimpleHexColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Extras\Contract\IHexColorToAnsiCodeConverter;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class SimpleHexColorToAnsiCodeConverterTest extends TestCaseWithPrebuiltMocksAndStubs
{
    public static function canConvertDataProvider(): iterable
    {
        foreach (self::simpleCanConvertDataFeeder() as $item) {
            yield [
                [
                    self::RESULT => $item[0],
                ],
                [
                    self::ARGUMENTS => [
                        self::COLOR => $item[1],
                        self::STYLE_MODE => $item[2],
                    ],
                ],
            ];
        }
    }

    protected static function simpleCanConvertDataFeeder(): iterable
    {
        $ansi4 = OptionStyleMode::ANSI4;
        $ansi8 = OptionStyleMode::ANSI8;
        $ansi24 = OptionStyleMode::ANSI24;

        yield from [
            // result, color, styleMode
            ['0', '#000000', $ansi4],
            ['1', '#800000', $ansi4],
            ['2', '#008000', $ansi4],
            ['3', '#808000', $ansi4],
            ['4', '#000080', $ansi4],
            ['5', '#800080', $ansi4],
            ['6', '#008080', $ansi4],
            ['7', '#c0c0c0', $ansi4],
            ['8;5;16', '#000000', $ansi8],
            ['8;5;17', '#00005f', $ansi8],
            ['8;5;18', '#000087', $ansi8],
            ['8;5;19', '#0000af', $ansi8],
            ['8;5;20', '#0000d7', $ansi8],
            ['8;5;21', '#0000ff', $ansi8],
            ['8;5;22', '#005f00', $ansi8],
            ['8;5;23', '#005f5f', $ansi8],
            ['8;5;24', '#005f87', $ansi8],
            ['8;5;25', '#005faf', $ansi8],
            ['8;5;26', '#005fd7', $ansi8],
            ['8;5;27', '#005fff', $ansi8],
            ['8;5;28', '#008700', $ansi8],
            ['8;5;29', '#00875f', $ansi8],
            ['8;5;30', '#008787', $ansi8],
            ['8;5;31', '#0087af', $ansi8],
            ['8;5;32', '#0087d7', $ansi8],
            ['8;5;33', '#0087ff', $ansi8],
            ['8;5;34', '#00af00', $ansi8],
            ['8;5;35', '#00af5f', $ansi8],
            ['8;5;36', '#00af87', $ansi8],
            ['8;5;37', '#00afaf', $ansi8],
            ['8;5;38', '#00afd7', $ansi8],
            ['8;5;39', '#00afff', $ansi8],
            ['8;5;40', '#00d700', $ansi8],
            ['8;5;41', '#00d75f', $ansi8],
            ['8;5;42', '#00d787', $ansi8],
            ['8;5;43', '#00d7af', $ansi8],
            ['8;5;44', '#00d7d7', $ansi8],
            ['8;5;45', '#00d7ff', $ansi8],
            ['8;5;46', '#00ff00', $ansi8],
            ['8;5;47', '#00ff5f', $ansi8],
            ['8;5;48', '#00ff87', $ansi8],
            ['8;5;49', '#00ffaf', $ansi8],
            ['8;5;50', '#00ffd7', $ansi8],
            ['8;5;51', '#00ffff', $ansi8],
            ['8;5;52', '#5f0000', $ansi8],
            ['8;5;53', '#5f005f', $ansi8],
            ['8;5;54', '#5f0087', $ansi8],
            ['8;5;55', '#5f00af', $ansi8],
            ['8;5;56', '#5f00d7', $ansi8],
            ['8;5;57', '#5f00ff', $ansi8],
            ['8;5;58', '#5f5f00', $ansi8],
            ['8;5;59', '#5f5f5f', $ansi8],
            ['8;5;60', '#5f5f87', $ansi8],
            ['8;5;61', '#5f5faf', $ansi8],
            ['8;5;62', '#5f5fd7', $ansi8],
            ['8;5;63', '#5f5fff', $ansi8],
            ['8;5;64', '#5f8700', $ansi8],
            ['8;5;65', '#5f875f', $ansi8],
            ['8;5;66', '#5f8787', $ansi8],
            ['8;5;67', '#5f87af', $ansi8],
            ['8;5;68', '#5f87d7', $ansi8],
            ['8;5;69', '#5f87ff', $ansi8],
            ['8;5;70', '#5faf00', $ansi8],
            ['8;5;71', '#5faf5f', $ansi8],
            ['8;5;72', '#5faf87', $ansi8],
            ['8;5;73', '#5fafaf', $ansi8],
            ['8;5;74', '#5fafd7', $ansi8],
            ['8;5;75', '#5fafff', $ansi8],
            ['8;5;76', '#5fd700', $ansi8],
            ['8;5;77', '#5fd75f', $ansi8],
            ['8;5;78', '#5fd787', $ansi8],
            ['8;5;79', '#5fd7af', $ansi8],
            ['8;5;80', '#5fd7d7', $ansi8],
            ['8;5;81', '#5fd7ff', $ansi8],
            ['8;5;82', '#5fff00', $ansi8],
            ['8;5;83', '#5fff5f', $ansi8],
            ['8;5;84', '#5fff87', $ansi8],
            ['8;5;85', '#5fffaf', $ansi8],
            ['8;5;86', '#5fffd7', $ansi8],
            ['8;5;87', '#5fffff', $ansi8],
            ['8;5;88', '#870000', $ansi8],
            ['8;5;89', '#87005f', $ansi8],
            ['8;5;90', '#870087', $ansi8],
            ['8;5;91', '#8700af', $ansi8],
            ['8;5;92', '#8700d7', $ansi8],
            ['8;5;93', '#8700ff', $ansi8],
            ['8;5;94', '#875f00', $ansi8],
            ['8;5;95', '#875f5f', $ansi8],
            ['8;5;96', '#875f87', $ansi8],
            ['8;5;97', '#875faf', $ansi8],
            ['8;5;98', '#875fd7', $ansi8],
            ['8;5;99', '#875fff', $ansi8],
            ['8;5;100', '#878700', $ansi8],
            ['8;5;101', '#87875f', $ansi8],
            ['8;5;102', '#878787', $ansi8],
            ['8;5;103', '#8787af', $ansi8],
            ['8;5;104', '#8787d7', $ansi8],
            ['8;5;105', '#8787ff', $ansi8],
            ['8;5;106', '#87af00', $ansi8],
            ['8;5;107', '#87af5f', $ansi8],
            ['8;5;108', '#87af87', $ansi8],
            ['8;5;109', '#87afaf', $ansi8],
            ['8;5;110', '#87afd7', $ansi8],
            ['8;5;111', '#87afff', $ansi8],
            ['8;5;112', '#87d700', $ansi8],
            ['8;5;113', '#87d75f', $ansi8],
            ['8;5;114', '#87d787', $ansi8],
            ['8;5;115', '#87d7af', $ansi8],
            ['8;5;116', '#87d7d7', $ansi8],
            ['8;5;117', '#87d7ff', $ansi8],
            ['8;5;118', '#87ff00', $ansi8],
            ['8;5;119', '#87ff5f', $ansi8],
            ['8;5;120', '#87ff87', $ansi8],
            ['8;5;121', '#87ffaf', $ansi8],
            ['8;5;122', '#87ffd7', $ansi8],
            ['8;5;123', '#87ffff', $ansi8],
            ['8;5;124', '#af0000', $ansi8],
            ['8;5;125', '#af005f', $ansi8],
            ['8;5;126', '#af0087', $ansi8],
            ['8;5;127', '#af00af', $ansi8],
            ['8;5;128', '#af00d7', $ansi8],
            ['8;5;129', '#af00ff', $ansi8],
            ['8;5;130', '#af5f00', $ansi8],
            ['8;5;131', '#af5f5f', $ansi8],
            ['8;5;132', '#af5f87', $ansi8],
            ['8;5;133', '#af5faf', $ansi8],
            ['8;5;134', '#af5fd7', $ansi8],
            ['8;5;135', '#af5fff', $ansi8],
            ['8;5;136', '#af8700', $ansi8],
            ['8;5;137', '#af875f', $ansi8],
            ['8;5;138', '#af8787', $ansi8],
            ['8;5;139', '#af87af', $ansi8],
            ['8;5;140', '#af87d7', $ansi8],
            ['8;5;141', '#af87ff', $ansi8],
            ['8;5;142', '#afaf00', $ansi8],
            ['8;5;143', '#afaf5f', $ansi8],
            ['8;5;144', '#afaf87', $ansi8],
            ['8;5;145', '#afafaf', $ansi8],
            ['8;5;146', '#afafd7', $ansi8],
            ['8;5;147', '#afafff', $ansi8],
            ['8;5;148', '#afd700', $ansi8],
            ['8;5;149', '#afd75f', $ansi8],
            ['8;5;150', '#afd787', $ansi8],
            ['8;5;151', '#afd7af', $ansi8],
            ['8;5;152', '#afd7d7', $ansi8],
            ['8;5;153', '#afd7ff', $ansi8],
            ['8;5;154', '#afff00', $ansi8],
            ['8;5;155', '#afff5f', $ansi8],
            ['8;5;156', '#afff87', $ansi8],
            ['8;5;157', '#afffaf', $ansi8],
            ['8;5;158', '#afffd7', $ansi8],
            ['8;5;159', '#afffff', $ansi8],
            ['8;5;160', '#d70000', $ansi8],
            ['8;5;161', '#d7005f', $ansi8],
            ['8;5;162', '#d70087', $ansi8],
            ['8;5;163', '#d700af', $ansi8],
            ['8;5;164', '#d700d7', $ansi8],
            ['8;5;165', '#d700ff', $ansi8],
            ['8;5;166', '#d75f00', $ansi8],
            ['8;5;167', '#d75f5f', $ansi8],
            ['8;5;168', '#d75f87', $ansi8],
            ['8;5;169', '#d75faf', $ansi8],
            ['8;5;170', '#d75fd7', $ansi8],
            ['8;5;171', '#d75fff', $ansi8],
            ['8;5;172', '#d78700', $ansi8],
            ['8;5;173', '#d7875f', $ansi8],
            ['8;5;174', '#d78787', $ansi8],
            ['8;5;175', '#d787af', $ansi8],
            ['8;5;176', '#d787d7', $ansi8],
            ['8;5;177', '#d787ff', $ansi8],
            ['8;5;178', '#d7af00', $ansi8],
            ['8;5;179', '#d7af5f', $ansi8],
            ['8;5;180', '#d7af87', $ansi8],
            ['8;5;181', '#d7afaf', $ansi8],
            ['8;5;182', '#d7afd7', $ansi8],
            ['8;5;183', '#d7afff', $ansi8],
            ['8;5;184', '#d7d700', $ansi8],
            ['8;5;185', '#d7d75f', $ansi8],
            ['8;5;186', '#d7d787', $ansi8],
            ['8;5;187', '#d7d7af', $ansi8],
            ['8;5;188', '#d7d7d7', $ansi8],
            ['8;5;189', '#d7d7ff', $ansi8],
            ['8;5;190', '#d7ff00', $ansi8],
            ['8;5;191', '#d7ff5f', $ansi8],
            ['8;5;192', '#d7ff87', $ansi8],
            ['8;5;193', '#d7ffaf', $ansi8],
            ['8;5;194', '#d7ffd7', $ansi8],
            ['8;5;195', '#d7ffff', $ansi8],
            ['8;5;196', '#ff0000', $ansi8],
            ['8;5;197', '#ff005f', $ansi8],
            ['8;5;198', '#ff0087', $ansi8],
            ['8;5;199', '#ff00af', $ansi8],
            ['8;5;200', '#ff00d7', $ansi8],
            ['8;5;201', '#ff00ff', $ansi8],
            ['8;5;202', '#ff5f00', $ansi8],
            ['8;5;203', '#ff5f5f', $ansi8],
            ['8;5;204', '#ff5f87', $ansi8],
            ['8;5;205', '#ff5faf', $ansi8],
            ['8;5;206', '#ff5fd7', $ansi8],
            ['8;5;207', '#ff5fff', $ansi8],
            ['8;5;208', '#ff8700', $ansi8],
            ['8;5;209', '#ff875f', $ansi8],
            ['8;5;210', '#ff8787', $ansi8],
            ['8;5;211', '#ff87af', $ansi8],
            ['8;5;212', '#ff87d7', $ansi8],
            ['8;5;213', '#ff87ff', $ansi8],
            ['8;5;214', '#ffaf00', $ansi8],
            ['8;5;215', '#ffaf5f', $ansi8],
            ['8;5;216', '#ffaf87', $ansi8],
            ['8;5;217', '#ffafaf', $ansi8],
            ['8;5;218', '#ffafd7', $ansi8],
            ['8;5;219', '#ffafff', $ansi8],
            ['8;5;220', '#ffd700', $ansi8],
            ['8;5;221', '#ffd75f', $ansi8],
            ['8;5;222', '#ffd787', $ansi8],
            ['8;5;223', '#ffd7af', $ansi8],
            ['8;5;224', '#ffd7d7', $ansi8],
            ['8;5;225', '#ffd7ff', $ansi8],
            ['8;5;226', '#ffff00', $ansi8],
            ['8;5;227', '#ffff5f', $ansi8],
            ['8;5;228', '#ffff87', $ansi8],
            ['8;5;229', '#ffffaf', $ansi8],
            ['8;5;230', '#ffffd7', $ansi8],
            ['8;5;231', '#ffffff', $ansi8],
            ['8;5;232', '#080808', $ansi8],
            ['8;5;233', '#121212', $ansi8],
            ['8;5;234', '#1c1c1c', $ansi8],
            ['8;5;235', '#262626', $ansi8],
            ['8;5;236', '#303030', $ansi8],
            ['8;5;237', '#3a3a3a', $ansi8],
            ['8;5;238', '#444444', $ansi8],
            ['8;5;239', '#4e4e4e', $ansi8],
            ['8;5;240', '#585858', $ansi8],
            ['8;5;241', '#626262', $ansi8],
            ['8;5;242', '#6c6c6c', $ansi8],
            ['8;5;243', '#767676', $ansi8],
            ['8;5;244', '#808080', $ansi8],
            ['8;5;245', '#8a8a8a', $ansi8],
            ['8;5;246', '#949494', $ansi8],
            ['8;5;247', '#9e9e9e', $ansi8],
            ['8;5;248', '#a8a8a8', $ansi8],
            ['8;5;249', '#b2b2b2', $ansi8],
            ['8;5;250', '#bcbcbc', $ansi8],
            ['8;5;251', '#c6c6c6', $ansi8],
            ['8;5;252', '#d0d0d0', $ansi8],
            ['8;5;253', '#dadada', $ansi8],
            ['8;5;254', '#e4e4e4', $ansi8],
            ['8;5;255', '#eeeeee', $ansi8],
            ['8;5;238', '#444', $ansi8],
            ['8;5;255', '#eee', $ansi8],
            ['8;5;231', '#fff', $ansi8],
            ['8;2;198;198;198', '#c6c6c6', $ansi24],
            ['8;2;255;135;135', '#ff8787', $ansi24],
            ['8;2;255;95;0', '#ff5f00', $ansi24],
            ['8;2;175;135;255', '#af87ff', $ansi24],
            ['8;2;68;68;68', '#444444', $ansi24],
            ['8;2;255;215;255', '#ffd7ff', $ansi24],
            ['8;2;215;135;95', '#d7875f', $ansi24],

        ];
    }

    public static function invalidInputDataProvider(): iterable
    {
        foreach (self::simpleInvalidInputDataFeeder() as $item) {
            yield [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => $item[0],
                        self::MESSAGE => $item[1],
                    ],
                ],
                [
                    self::ARGUMENTS => [
                        self::COLOR => $item[2],
                        self::STYLE_MODE => $item[3],
                    ],
                ],
            ];
        }
    }

    protected static function simpleInvalidInputDataFeeder(): iterable
    {
        $e = InvalidArgumentException::class;
        $none = OptionStyleMode::NONE;
        $ansi4 = OptionStyleMode::ANSI4;
        $ansi8 = OptionStyleMode::ANSI8;
        $ansi24 = OptionStyleMode::ANSI24;

        yield from [
            // exceptionClass, exceptionMessage, color, styleMode
            [$e, 'Unsupported style mode "NONE".', '#000000', $none],
            [$e, 'Invalid color: "#00000".', '#00000', $ansi4],
            [$e, 'Invalid color: "#00000".', '#00000', $ansi8],
            [$e, 'Invalid color: "#00000".', '#00000', $ansi24],
            [$e, 'Empty color string.', '', $ansi24],
        ];
    }

    #[Test]
    public function canBeCreated(): void
    {
        $converter = $this->getTesteeInstance();

        self::assertInstanceOf(SimpleHexColorToAnsiCodeConverter::class, $converter);
    }

    public function getTesteeInstance(
        ?OptionStyleMode $styleMode = null,
    ): IHexColorToAnsiCodeConverter {
        return new SimpleHexColorToAnsiCodeConverter(
            styleMode: $styleMode ?? OptionStyleMode::ANSI24,
        );
    }

    #[Test]
    #[DataProvider('canConvertDataProvider')]
    public function canConvert(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $args = $incoming[self::ARGUMENTS];

        $converter = $this->getTesteeInstance(
            styleMode: $args[self::STYLE_MODE],
        );

        $result = $converter->convert($args[self::COLOR]);

        if ($expectedException) {
            self::failTest($expectedException);
        }

        self::assertSame($expected[self::RESULT], $result);
    }

    #[Test]
    #[DataProvider('invalidInputDataProvider')]
    public function throwsOnInvalidInput(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $args = $incoming[self::ARGUMENTS];

        $converter = $this->getTesteeInstance(
            styleMode: $args[self::STYLE_MODE],
        );

        $result = $converter->convert($args[self::COLOR]);

        if ($expectedException) {
            self::failTest($expectedException);
        }

        self::assertSame($expected[self::RESULT], $result);
    }

    #[Test]
    public function throwsIfStyleModeIsNone(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage = 'Unsupported style mode "NONE".';

        $test = function (): void {
            $this->getTesteeInstance(styleMode: OptionStyleMode::NONE);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }
}
