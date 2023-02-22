[⬅️ to README.md](../README.md)
# Features

- [x] Extremely flexible 
- [x] Zero dependencies (* see [limitations](limitations.md))
- [x] Asynchronous mode (* see [limitations](limitations.md))
  - [x] Support of `react/event-loop` 
  - [x] Support of `revolt/event-loop`(`amphp/amp:^3.0`)
- [x] Synchronous mode
- [ ] Color mode switch:
  - [ ] no color
  - [ ] 16 colors
  - [ ] 256 colors (default)
  - [ ] true color
  - [ ] _[Postponed]_ auto-detection (* requires [terminal library]())
- [ ] _[Postponed]_ Terminal width auto-detection (* requires [terminal library]())
- [x] Pipe support
```text
$ app.php | grep "something"
```
- [x] Stream redirection support
```text
$ app.php > output.txt
```
- [x] Auto cursor hide/show (can be disabled)
