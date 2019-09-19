<a name="unreleased"></a>
## [Unreleased]

### Changed
- internal API

### Enhanced
- `Strip::controlCodes` test

### Removed
- deprecated internal constant


<a name="0.42.0-BETA.0"></a>
## [0.42.0-BETA.0] - 2019-09-18
### Changed
- method `getHideCursor` to `isHideCursor`
- method `setDoNotHideCursor(false)` to `setHideCursor(true)`


<a name="0.41.1-BETA.1"></a>
## [0.41.1-BETA.1] - 2019-09-18

<a name="0.41.0-BETA.1"></a>
## [0.41.0-BETA.1] - 2019-09-18

<a name="0.40.3-BETA.2"></a>
## [0.40.3-BETA.2] - 2019-09-18
### Added
- tree frames set
- new toggle frames set
- monkey frames set
- runner frames set


<a name="0.40.2-BETA.2"></a>
## [0.40.2-BETA.2] - 2019-09-18
### Changed
- wheather set


<a name="0.40.2-BETA.1"></a>
## [0.40.2-BETA.1] - 2019-09-18
### Added
- extended weather set


<a name="0.40.1-BETA.1"></a>
## [0.40.1-BETA.1] - 2019-09-18
### Added
- new `Settings::class` method `doNotHideCursor()`


<a name="0.40.0-ALPHA.4"></a>
## [0.40.0-ALPHA.4] - 2019-09-15
### Removed
- `EchoOutputAdapter`


<a name="0.40.0-ALPHA.3"></a>
## [0.40.0-ALPHA.3] - 2019-09-13
### Added
- `php 7.2` build
- `StdErrOutputAdapter::class`

### Changed
- `php-console-colour` version

### Removed
- travis `php 7.2` build


<a name="0.40.0-ALPHA.2"></a>
## [0.40.0-ALPHA.2] - 2019-09-13

<a name="0.40.0-ALPHA.1"></a>
## [0.40.0-ALPHA.1] - 2019-09-11

<a name="0.36.1-BETA.2"></a>
## [0.36.1-BETA.2] - 2019-09-11

<a name="0.36.1-BETA.1"></a>
## [0.36.1-BETA.1] - 2019-09-11
### Added
- new method `$spinner->isActive()`


<a name="0.36.0-BETA.0"></a>
## [0.36.0-BETA.0] - 2019-09-11
### Feature
- pipe and redirect
- final message `$spinner->end('final message')`


<a name="0.35.0-BETA.0"></a>
## [0.35.0-BETA.0] - 2019-09-09
### Feature
- jugglers order can be changed


<a name="0.34.0-BETA.4"></a>
## [0.34.0-BETA.4] - 2019-09-05
### Added
- new frame sets
- Weather frames set  `🌤 🌥 🌧 🌨 🌧 🌨 🌧 🌨 🌨 🌧 🌨 🌥 🌤`

### Fixed
- examples

### Updated
- demos


<a name="0.34.0-BETA.3"></a>
## [0.34.0-BETA.3] - 2019-09-02

<a name="0.34.0-BETA.2"></a>
## [0.34.0-BETA.2] - 2019-09-02

<a name="0.34.0-BETA.1"></a>
## [0.34.0-BETA.1] - 2019-09-02
### Added
- `Defaults::ELLIPSIS` const


<a name="0.33.0-ALPHA.1"></a>
## [0.33.0-ALPHA.1] - 2019-09-01

<a name="0.32.0-ALPHA1"></a>
## [0.32.0-ALPHA1] - 2019-08-31
### Added
- `Colors::class`

### Changed
- Reintroduced `Style::class`


<a name="0.31.0-ALPHA1"></a>
## [0.31.0-ALPHA1] - 2019-08-31
### Added
- Usage of `Terminal::class` to define color support and terminal window sizes
- `prefix` and `suffix` to all three jugglers`
- `EarthSpinner::class`

### Renamed
- `StylesInterface` to `Styles`


<a name="0.30.0-ALPHA2"></a>
## [0.30.0-ALPHA2] - 2019-08-29
### Changed
- `Spinner::class` API

### Removed
- `Style::class`, functionality moved to `Coloring::class`


<a name="0.17.1"></a>
## [0.17.1] - 2019-08-22
### Changed
- Settings api

### Fixed
- mb example


<a name="0.17.0"></a>
## [0.17.0] - 2019-08-22

<a name="0.16.5"></a>
## [0.16.5] - 2019-08-21
### Added
- tool to check color sets

### Updated
- color sets


<a name="0.16.4"></a>
## [0.16.4] - 2019-08-20

<a name="0.16.3"></a>
## [0.16.3] - 2019-08-19

<a name="0.16.2"></a>
## [0.16.2] - 2019-08-16

<a name="0.16.1-ALPHA.4"></a>
## [0.16.1-ALPHA.4] - 2019-08-16

<a name="0.16.1-ALPHA.3"></a>
## [0.16.1-ALPHA.3] - 2019-08-16
### Added
- new 256 color style `C256_BG_RAINBOW`
- new 256 color style `C256_BG_YELLOW_WHITE`

### Feature
- 256Color styles now accept bg color

### Fixed
- tests


<a name="0.16.0-ALPHA.2"></a>
## [0.16.0-ALPHA.2] - 2019-08-15

<a name="0.16.0-ALPHA.1"></a>
## [0.16.0-ALPHA.1] - 2019-08-15
### Add
- async example

### Added
- `TimeSpinner::class`

### Changed
- `Symbols` a renamed to `Frames`
- default frames set for `BlockSpinner`

### Removed
- `ZodiacSpinner`


<a name="0.15.2-ALPHA.3"></a>
## [0.15.2-ALPHA.3] - 2019-08-14
### Added
- `BlockSpinner` class


<a name="0.15.1-ALPHA.3"></a>
## [0.15.1-ALPHA.3] - 2019-08-14
### Added
- `advanced_plus.php` example
- color finding tool as example
- `quickstart.php` example
- `simple.php` example

### Feature
- multibyte fixed message
- changeable message

### Renamed
- `SpinnerSumbols` to `Symbols`

### Updated
- `usage_experiment.php` example
- todo.md
- tests
- README.md
- `demo.php.gif`
- documentation
- `advanced.php` example


<a name="0.14.7"></a>
## [0.14.7] - 2019-08-01
### Update
- `advanced.php` example


<a name="0.14.6"></a>
## [0.14.6] - 2019-07-29
### Updated
- dependencies versions


<a name="0.14.5"></a>
## [0.14.5] - 2019-06-17

<a name="0.14.4"></a>
## [0.14.4] - 2019-06-09

<a name="0.14.3"></a>
## [0.14.3] - 2019-06-09

<a name="0.14.3-BETA.1"></a>
## [0.14.3-BETA.1] - 2019-04-28

<a name="0.14.2-BETA.1"></a>
## [0.14.2-BETA.1] - 2019-04-24

<a name="0.14.1-ALPHA.1"></a>
## [0.14.1-ALPHA.1] - 2019-04-23

<a name="0.14.0-ALPHA.1"></a>
## [0.14.0-ALPHA.1] - 2019-04-23

<a name="0.13.0-ALPHA.1"></a>
## [0.13.0-ALPHA.1] - 2019-04-23

<a name="0.12.0-ALPHA.1"></a>
## [0.12.0-ALPHA.1] - 2019-04-23

<a name="0.11.1-ALPHA.1"></a>
## [0.11.1-ALPHA.1] - 2019-04-22

<a name="0.10.2-ALPHA.1"></a>
## [0.10.2-ALPHA.1] - 2019-04-22

<a name="0.10.1-ALPHA.1"></a>
## [0.10.1-ALPHA.1] - 2019-04-22

<a name="0.10.0-ALPHA.1"></a>
## [0.10.0-ALPHA.1] - 2019-04-22

<a name="0.9.0-BETA.1"></a>
## [0.9.0-BETA.1] - 2019-04-17

<a name="0.8.0-BETA.1"></a>
## [0.8.0-BETA.1] - 2019-04-13

<a name="0.7.4-BETA.1"></a>
## [0.7.4-BETA.1] - 2019-04-13

<a name="0.7.3-BETA.1"></a>
## [0.7.3-BETA.1] - 2019-04-13

<a name="0.7.2-BETA.1"></a>
## [0.7.2-BETA.1] - 2019-04-12

<a name="0.7.1-ALPHA1"></a>
## [0.7.1-ALPHA1] - 2019-04-12

<a name="0.7.0-ALPHA.1"></a>
## [0.7.0-ALPHA.1] - 2019-04-12

<a name="0.6.1-ALPHA.1"></a>
## [0.6.1-ALPHA.1] - 2019-04-11

<a name="0.6.0-ALPHA.1"></a>
## [0.6.0-ALPHA.1] - 2019-04-11

<a name="0.5.0-ALPHA.1"></a>
## [0.5.0-ALPHA.1] - 2019-04-11

<a name="0.4.0-ALPHA.1"></a>
## [0.4.0-ALPHA.1] - 2019-04-10

<a name="0.3.4-ALPHA.1"></a>
## [0.3.4-ALPHA.1] - 2019-04-09

<a name="0.3.3-ALPHA.1"></a>
## [0.3.3-ALPHA.1] - 2019-04-08

<a name="0.3.2-ALPHA.1"></a>
## [0.3.2-ALPHA.1] - 2019-04-08

<a name="0.3.1-ALPHA.1"></a>
## [0.3.1-ALPHA.1] - 2019-04-08

<a name="0.3.0-ALPHA.1"></a>
## [0.3.0-ALPHA.1] - 2019-04-08

<a name="0.2.3-BETA.1"></a>
## [0.2.3-BETA.1] - 2019-04-06

<a name="0.2.2-BETA.1"></a>
## [0.2.2-BETA.1] - 2019-04-06

<a name="0.2.1-ALPHA.1"></a>
## 0.2.1-ALPHA.1 - 2019-04-06

[Unreleased]: https://github.com/alecrabbit/php-console-spinner/compare/0.42.0-BETA.0...HEAD
[0.42.0-BETA.0]: https://github.com/alecrabbit/php-console-spinner/compare/0.41.1-BETA.1...0.42.0-BETA.0
[0.41.1-BETA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.41.0-BETA.1...0.41.1-BETA.1
[0.41.0-BETA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.40.3-BETA.2...0.41.0-BETA.1
[0.40.3-BETA.2]: https://github.com/alecrabbit/php-console-spinner/compare/0.40.2-BETA.2...0.40.3-BETA.2
[0.40.2-BETA.2]: https://github.com/alecrabbit/php-console-spinner/compare/0.40.2-BETA.1...0.40.2-BETA.2
[0.40.2-BETA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.40.1-BETA.1...0.40.2-BETA.1
[0.40.1-BETA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.40.0-ALPHA.4...0.40.1-BETA.1
[0.40.0-ALPHA.4]: https://github.com/alecrabbit/php-console-spinner/compare/0.40.0-ALPHA.3...0.40.0-ALPHA.4
[0.40.0-ALPHA.3]: https://github.com/alecrabbit/php-console-spinner/compare/0.40.0-ALPHA.2...0.40.0-ALPHA.3
[0.40.0-ALPHA.2]: https://github.com/alecrabbit/php-console-spinner/compare/0.40.0-ALPHA.1...0.40.0-ALPHA.2
[0.40.0-ALPHA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.36.1-BETA.2...0.40.0-ALPHA.1
[0.36.1-BETA.2]: https://github.com/alecrabbit/php-console-spinner/compare/0.36.1-BETA.1...0.36.1-BETA.2
[0.36.1-BETA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.36.0-BETA.0...0.36.1-BETA.1
[0.36.0-BETA.0]: https://github.com/alecrabbit/php-console-spinner/compare/0.35.0-BETA.0...0.36.0-BETA.0
[0.35.0-BETA.0]: https://github.com/alecrabbit/php-console-spinner/compare/0.34.0-BETA.4...0.35.0-BETA.0
[0.34.0-BETA.4]: https://github.com/alecrabbit/php-console-spinner/compare/0.34.0-BETA.3...0.34.0-BETA.4
[0.34.0-BETA.3]: https://github.com/alecrabbit/php-console-spinner/compare/0.34.0-BETA.2...0.34.0-BETA.3
[0.34.0-BETA.2]: https://github.com/alecrabbit/php-console-spinner/compare/0.34.0-BETA.1...0.34.0-BETA.2
[0.34.0-BETA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.33.0-ALPHA.1...0.34.0-BETA.1
[0.33.0-ALPHA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.32.0-ALPHA1...0.33.0-ALPHA.1
[0.32.0-ALPHA1]: https://github.com/alecrabbit/php-console-spinner/compare/0.31.0-ALPHA1...0.32.0-ALPHA1
[0.31.0-ALPHA1]: https://github.com/alecrabbit/php-console-spinner/compare/0.30.0-ALPHA2...0.31.0-ALPHA1
[0.30.0-ALPHA2]: https://github.com/alecrabbit/php-console-spinner/compare/0.17.1...0.30.0-ALPHA2
[0.17.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.17.0...0.17.1
[0.17.0]: https://github.com/alecrabbit/php-console-spinner/compare/0.16.5...0.17.0
[0.16.5]: https://github.com/alecrabbit/php-console-spinner/compare/0.16.4...0.16.5
[0.16.4]: https://github.com/alecrabbit/php-console-spinner/compare/0.16.3...0.16.4
[0.16.3]: https://github.com/alecrabbit/php-console-spinner/compare/0.16.2...0.16.3
[0.16.2]: https://github.com/alecrabbit/php-console-spinner/compare/0.16.1-ALPHA.4...0.16.2
[0.16.1-ALPHA.4]: https://github.com/alecrabbit/php-console-spinner/compare/0.16.1-ALPHA.3...0.16.1-ALPHA.4
[0.16.1-ALPHA.3]: https://github.com/alecrabbit/php-console-spinner/compare/0.16.0-ALPHA.2...0.16.1-ALPHA.3
[0.16.0-ALPHA.2]: https://github.com/alecrabbit/php-console-spinner/compare/0.16.0-ALPHA.1...0.16.0-ALPHA.2
[0.16.0-ALPHA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.15.2-ALPHA.3...0.16.0-ALPHA.1
[0.15.2-ALPHA.3]: https://github.com/alecrabbit/php-console-spinner/compare/0.15.1-ALPHA.3...0.15.2-ALPHA.3
[0.15.1-ALPHA.3]: https://github.com/alecrabbit/php-console-spinner/compare/0.14.7...0.15.1-ALPHA.3
[0.14.7]: https://github.com/alecrabbit/php-console-spinner/compare/0.14.6...0.14.7
[0.14.6]: https://github.com/alecrabbit/php-console-spinner/compare/0.14.5...0.14.6
[0.14.5]: https://github.com/alecrabbit/php-console-spinner/compare/0.14.4...0.14.5
[0.14.4]: https://github.com/alecrabbit/php-console-spinner/compare/0.14.3...0.14.4
[0.14.3]: https://github.com/alecrabbit/php-console-spinner/compare/0.14.3-BETA.1...0.14.3
[0.14.3-BETA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.14.2-BETA.1...0.14.3-BETA.1
[0.14.2-BETA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.14.1-ALPHA.1...0.14.2-BETA.1
[0.14.1-ALPHA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.14.0-ALPHA.1...0.14.1-ALPHA.1
[0.14.0-ALPHA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.13.0-ALPHA.1...0.14.0-ALPHA.1
[0.13.0-ALPHA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.12.0-ALPHA.1...0.13.0-ALPHA.1
[0.12.0-ALPHA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.11.1-ALPHA.1...0.12.0-ALPHA.1
[0.11.1-ALPHA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.10.2-ALPHA.1...0.11.1-ALPHA.1
[0.10.2-ALPHA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.10.1-ALPHA.1...0.10.2-ALPHA.1
[0.10.1-ALPHA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.10.0-ALPHA.1...0.10.1-ALPHA.1
[0.10.0-ALPHA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.9.0-BETA.1...0.10.0-ALPHA.1
[0.9.0-BETA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.8.0-BETA.1...0.9.0-BETA.1
[0.8.0-BETA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.7.4-BETA.1...0.8.0-BETA.1
[0.7.4-BETA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.7.3-BETA.1...0.7.4-BETA.1
[0.7.3-BETA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.7.2-BETA.1...0.7.3-BETA.1
[0.7.2-BETA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.7.1-ALPHA1...0.7.2-BETA.1
[0.7.1-ALPHA1]: https://github.com/alecrabbit/php-console-spinner/compare/0.7.0-ALPHA.1...0.7.1-ALPHA1
[0.7.0-ALPHA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.6.1-ALPHA.1...0.7.0-ALPHA.1
[0.6.1-ALPHA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.6.0-ALPHA.1...0.6.1-ALPHA.1
[0.6.0-ALPHA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.5.0-ALPHA.1...0.6.0-ALPHA.1
[0.5.0-ALPHA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.4.0-ALPHA.1...0.5.0-ALPHA.1
[0.4.0-ALPHA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.3.4-ALPHA.1...0.4.0-ALPHA.1
[0.3.4-ALPHA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.3.3-ALPHA.1...0.3.4-ALPHA.1
[0.3.3-ALPHA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.3.2-ALPHA.1...0.3.3-ALPHA.1
[0.3.2-ALPHA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.3.1-ALPHA.1...0.3.2-ALPHA.1
[0.3.1-ALPHA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.3.0-ALPHA.1...0.3.1-ALPHA.1
[0.3.0-ALPHA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.2.3-BETA.1...0.3.0-ALPHA.1
[0.2.3-BETA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.2.2-BETA.1...0.2.3-BETA.1
[0.2.2-BETA.1]: https://github.com/alecrabbit/php-console-spinner/compare/0.2.1-ALPHA.1...0.2.2-BETA.1
