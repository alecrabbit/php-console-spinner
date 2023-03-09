[⬅️ to README.md](../README.md)
# Features

- [x] Extremely flexible
- [x] Extensible, see [alecrabbit/php-console-spinner-extras](https://github.com/alecrabbit/php-console-spinner-extras)
- [x] Zero dependencies[*](#limitations) 
- [x] Asynchronous mode[*](#limitations)
  - [x] Support of `react/event-loop` 
  - [x] Support of `revolt/event-loop`(`amphp/amp:^3.0`)
- [x] Synchronous mode
- [ ] Color mode switch:
  - [ ] no color
  - [ ] 16 colors
  - [ ] 256 colors (default)
  - [ ] true color
  - [ ] _[Postponed]_ auto-detection[**](#requirements)
- [ ] _[Postponed]_ Terminal width auto-detection[**](#requirements)
- [x] Pipe support
```text
$ app.php | grep "something"
```
- [x] Stream redirection support
```text
$ app.php > output.txt
```
- [x] Auto cursor hide/show (can be disabled)
---
<a name="limitations"></a> * see [limitations](limitations.md)<br>
<a name="requirements"></a> ** requires [terminal library]()<br>