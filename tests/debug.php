<?php
// snippet
if (!defined('APP_DEBUG')) {
    define('APP_DEBUG', true);
}

// snippet
if (defined('APP_DEBUG') && APP_DEBUG) {
    if (!defined('DEBUG_DUMP_EXCEPTION')) {
        define('DEBUG_DUMP_EXCEPTION', true); // change to 'true' to dump exception message and trace
    }
    if (!defined('DEBUG_DUMP_EXCEPTION_OBJECT')) {
        define('DEBUG_DUMP_EXCEPTION_OBJECT', true); // change to 'true' to dump exception class
    }
}
