[⬅️ to README.md](../README.md)

[⬅️ to features.md](features.md)

### "Zero" dependencies

"Zero" dependencies mode means that the library does not require any additional dependencies to work. The only exception 
is `psr/container`. That's why zero is in quotes.
```json
    "require": {
        "php": ">=8.2",
        "psr/container": ">=2.0"
    },
```
### Limitations

In "Zero" dependencies "mode", the library has the following limitations:
- ❗ **Only synchronous mode is available.**
- Terminal color support can not be detected thus it is set to 256 colors by default. Can be overridden manually.
- Terminal width can not be detected thus it is set to 100 by default. Can be overridden manually.
- Frame width can not be determined thus it is user responsibility to set it properly.
- Signal handling is not supported.

### How to overcome limitations?

- For asynchronous mode install one of supported event loop libraries:
  - [ReactPHP](https://github.com/reactphp/event-loop)
  - [Revolt](https://github.com/revoltphp/event-loop)
- For terminal features install one of supported libraries:
  - [symfony/console](https://github.com/symfony/console)
- For frame width auto-detection install:
  - [alecrabbit/php-wcwidth](https://github.com/alecrabbit/php-wcwidth)
- Install `ext-pcntl` extension for signal handling feature.

### Windows support
- To run spinner spiced applications on Windows you should have some *nix-like terminal emulator installed.
  - VT100 terminal, e.g. [minTTY](https://github.com/mintty/mintty).  
