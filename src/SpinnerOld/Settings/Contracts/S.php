<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Settings\Contracts;

interface S
{
    public const INTERVAL = 'interval';
    public const ERASING_SHIFT = 'erasingShift';
    public const MESSAGE = 'message';
    public const MESSAGE_ERASING_LENGTH = 'messageErasingLen';
    public const MESSAGE_SUFFIX = 'messageSuffix';
    public const INLINE_SPACER = 'inline_spacer';
    public const FRAMES = 'frames';
    public const STYLES = 'styles';
    public const SPACER = 'spacer';
    public const INITIAL_PERCENT = 'initial_percent';
    public const ENABLED = 'enabled';
    public const JUGGLERS_ORDER = 'jugglers_order';
    public const HIDE_CURSOR = 'hide_cursor';
}
