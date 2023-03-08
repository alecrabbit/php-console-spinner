# Changelog
All notable changes to this project will be documented in this file.

---

<a name="unreleased"></a>
## [Unreleased]


<a name="1.0.0-ALPHA.1+BUILD.1"></a>
## [1.0.0-ALPHA.1+BUILD.1] - 2023-03-03

<a name="0.55.0"></a>
## 0.55.0 - 2021-11-18
### Add
- async example

### Added
- `Dot8BitSpinner::class`
- tree frames set
- new toggle frames set
- monkey frames set
- runner frames set
- extended weather set
- new `Settings::class` method `doNotHideCursor()`
- `php 7.2` build
- `StdErrOutputAdapter::class`
- new method `$spinner->isActive()`
- new frame sets
- Weather frames set  `🌤 🌥 🌧 🌨 🌧 🌨 🌧 🌨 🌨 🌧 🌨 🌥 🌤`
- `Defaults::ELLIPSIS` const
- `Colors::class`
- Usage of `Terminal::class` to define color support and terminal window sizes
- `prefix` and `suffix` to all three jugglers`
- `EarthSpinner::class`
- tool to check color sets
- new 256 color style `C256_BG_RAINBOW`
- new 256 color style `C256_BG_YELLOW_WHITE`
- `TimeSpinner::class`
- `BlockSpinner` class
- `advanced_plus.php` example
- color finding tool as example
- `quickstart.php` example
- `simple.php` example

### Changed
- bumped dependency version
- erasing now done by `\e[<n>X` ANSI code
- internal API
- method `getHideCursor` to `isHideCursor`
- method `setDoNotHideCursor(false)` to `setHideCursor(true)`
- wheather set
- `php-console-colour` version
- Reintroduced `Style::class`
- `Spinner::class` API
- Settings api
- `Symbols` a renamed to `Frames`
- default frames set for `BlockSpinner`

### Enhanced
- `Strip::controlCodes` test

### Feature
- pipe and redirect
- final message `$spinner->end('final message')`
- jugglers order can be changed
- 256Color styles now accept bg color
- multibyte fixed message
- changeable message

### Fixed
- `ProgressSpinner` test
- examples
- mb example
- tests

### Removed
- unused parameter
- deprecated internal constant
- `EchoOutputAdapter`
- travis `php 7.2` build
- `Style::class`, functionality moved to `Coloring::class`
- `ZodiacSpinner`

### Rename
- `lastSpinnerString` ➙ `lastOutput`

### Renamed
- `PaddingStr` ➙ `Spacer`
- `Length` ➙ `Width`
- `StylesInterface` to `Styles`
- `SpinnerSumbols` to `Symbols`

### Todo
- fix tests

### Update
- `advanced.php` example

### Updated
- `alecrabbit/php-console-colour` dependency
- demos
- color sets
- `usage_experiment.php` example
- todo.md
- tests
- README.md
- `demo.php.gif`
- documentation
- `advanced.php` example
- dependencies versions


[Unreleased]: https://github.com/alecrabbit/php-wcwidth/compare/1.0.0-ALPHA.1+BUILD.1...HEAD
[1.0.0-ALPHA.1+BUILD.1]: https://github.com/alecrabbit/php-wcwidth/compare/0.55.0...1.0.0-ALPHA.1+BUILD.1
- the format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/)
- this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html)
