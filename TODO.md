
- [ ] Minimize number of dependencies
    - [ ] `v1.0.0` goal is a minimum of indirect dependencies
    - [ ] move Symfony/Console adapter to separate package
    - [ ] move color constants to separate package, related to [alecrabbit/php-console-colour](https://github.com/alecrabbit/php-console-colour)
- [ ] Do terminal color support check explicitly by lib user(`v1.0.0` goal is remove autodetect) 
- [ ] Improve documentation
- [ ] Optimize performance
- [ ] Change color model, improves styles customization
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
- [x] Erase with `CSI<n>X`
