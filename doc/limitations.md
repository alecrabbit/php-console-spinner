[⬅️ to README.md](../README.md)

[⬅️ to features.md](features.md)

> **Note** See [known_issues.md](known_issues.md)

### Limitations

In "Zero" dependencies "mode", the library has the following limitations:
- ❗ **Only synchronous mode is available.**
- Flexibility is limited.
- Terminal color support can not be detected thus it is set to 256 colors (ansi8) by default. Can be overridden manually.
- Terminal width can not be detected thus it is set to 100 by default. Can be overridden manually.
- Frame width can not be determined thus it is user responsibility to set it properly. 
- Signal handling is not supported.

### How to overcome limitations?
- For asynchronous mode install one of supported event loop libraries:
  - [Revolt](https://github.com/revoltphp/event-loop) 
  - [ReactPHP](https://github.com/reactphp/event-loop) 
- For flexibility install:
  - [alecrabbit/php-console-spinner-extras](https://github.com/alecrabbit/php-console-spinner-extras)
- For terminal features install one of supported libraries:
  - [symfony/console](https://github.com/symfony/console)
- For frame width auto-detection install:
  - [alecrabbit/php-wcwidth](https://github.com/alecrabbit/php-wcwidth)
- Install `ext-pcntl` extension for signal handling feature.

### Windows support
- To run spinner spiced applications on Windows you should have some *nix-like terminal emulator installed.
  - VT100 terminal, e.g. [minTTY](https://github.com/mintty/mintty).  
