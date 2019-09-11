# Unix pipe and redirect

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