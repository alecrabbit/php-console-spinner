<?php declare(strict_types=1);

function __check_for_extension(string $extension, string $message, string $file) {
    if(!extension_loaded($extension)) {
        echo $file . ': ' . $message;
        exit(1);
    }

}