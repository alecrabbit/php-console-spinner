# Unix pipe and redirect

```bash
$ php examples/async.demo.php | grep 10 > out.txt
```
As a result in `out.txt`, you'll only have lines containing `10`
```text
 Gulgowski-Schmitt                    6,110.46$ PL79175995375489523442187962 
 Jones Ltd                            1,612.36$ SE7910009743360513473811 
 Rolfson, Romaguera and Macejkovic    1,210.72$ GR800176321QCBHR18995PRKH4Q 

...

 Rau and Sons                           647.68$ EE043607851166100346 
 Roberts, Lakin and Schimmel          1,221.30$ TR97078310435LF9RFN51665HM 
 Rempel Group                         2,212.32$ SI96109599881828207 
```

## Default Output Adapter

By default spinner is instantiated with `StdErrOutputAdaper`. It allows to write all spinner sequences to `stderr`. Your app have to write to `stdout`. For simple cases `echo` will do.

And if you want anything to be written to `stderr` besides spinner sequences, e.g. status messages, you can use:
```php
$spinner->getOutput()->writeln('Status message');
```
> Note: it should be colored separately.
 
## Symfony Output Adapter

Using `SymfonyOutputAdapter::class`

```php
$consoleOutput = new ConsoleOutput();
$output = new SymfonyOutputAdapter($consoleOutput);
$spinner = new SnakeSpinner(null, $output);
```

```bash
$ php examples/async.demo.php > out.txt
```
Will output:
```text
Async spinner demo.

Use CTRL+C to exit.

Searching for accepted payments...
11:53:18 Memory: 4.29MB(6.00MB) Peak: 4.33MB(6.00MB)
...
Finished!
```

```bash
$ cat out.txt
```

```text
 Wunsch-Veum                          5,613.30$ PT75978979392149515437200 
 Barrows, Cartwright and Stark          883.82$ ES5919018953998040913866 
 Bahringer and Sons                   1,945.00$ MT98FUBW51066KW27TIY2F795DX2T4V 
 Herman-Howell                        2,481.60$ SK7556541091928982308119 

...

 Bashirian and Sons                   3,565.11$ HR3778259595000442092 
 Kiehn, Shields and Beahan            3,630.72$ RO59QZIGOQ90DO226U4288SC 
 Cormier Group                        3,486.08$ FI1306157195893690 
 Pollich-Hagenes                      1,443.56$ IT75O4888486788CWJ5W2NJF8LI 
```

## Notes on running under `docker-compose`

> Use `-T` flag

```bash
$ docker-compose exec -T app php examples/async.demo.php > out.txt
```