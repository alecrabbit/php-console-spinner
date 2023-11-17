[⬅️ to README.md](../README.md)
# Features

> **Note** See [limitations](limitations.md)

- [x] Extremely flexible (a bit complicated because of this)
- [x] Extensible
- [x] "Zero" dependencies (requires `psr/container`)
- [x] Asynchronous mode
  - [x] Support of `revolt/event-loop` 
  - [x] Support of `react/event-loop`
- [x] Synchronous mode
- [x] Styling mode switch:
  - [x] no color
  - [x] 16 colors
  - [x] 256 colors (default)
  - [x] true color
- [x] Pipe support
```text
$ app.php | grep "something"
```
- [x] Stream redirection support
```text
$ app.php > output.txt
```
- [x] Auto cursor hide/show (can be disabled)
- [x] Event loop auto start (can be disabled for `revolt/event-loop`)
