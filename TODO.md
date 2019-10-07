
- [ ] Optimize performance
- [ ] Change color model
```php 
$colors = [
    C256_PURPLE_RED => [
        LEVEL => COLOR256_TERMINAL,
        ANSI_STYLES => [
            [56,],
            [92,],
            [128,],
            [164,],
            [163,],
            [162,],
            [161,],
            [162,],
            [163,],
            [164,],
            [128,],
            [92,],
        ],
        HANDLER =>
            static function (array $a): array {
                $r = [];
                foreach ($a as $cs) {
                    $r[] = sprintf("\e[38;5;%sm%s\e[0m", $cs[0], '%s');
                }
                return $r;
            },
    ],
];
```
---

- [x] Use `php-wcwidth`
- [x] implement `doNotHideCursor()`
- [x] New Api   
    - [x] methods `$s->spin()`, `$s->message('message')`, `$s->percent(0.2) // 20%`  
- [x] Strip escape codes in message string (styles overriding - strlen)
    - python [link](https://stackoverflow.com/questions/14693701/how-can-i-remove-the-ansi-escape-sequences-from-a-string-in-python) 
    - js [link](https://github.com/chalk/ansi-regex/blob/master/index.js) 
    - php [link](https://stackoverflow.com/questions/40731273/php-remove-terminal-codes-from-string) 

