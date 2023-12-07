# Pipe and Stream redirection

## Pipe

Pipe is a simple way to redirect the output of a command to another command.

```bash
php app.php | grep Ukraine
```

If you are lucky enough you'll see something like this:

```text
2023-12-06T15:06:29.776+00:00: Ukraine
```

## Stream

Stream redirection is a way to redirect the output of a command to a file.

```bash
php app.php > output.txt
```
File will contain something like this:

```text
2023-12-06T15:22:02.938+00:00: Cape Verde
2023-12-06T15:22:03.214+00:00: Burundi
2023-12-06T15:22:03.238+00:00: Egypt
2023-12-06T15:22:03.510+00:00: Moldova
2023-12-06T15:22:03.545+00:00: Angola
2023-12-06T15:22:03.728+00:00: Maldives
2023-12-06T15:22:03.895+00:00: Bermuda
2023-12-06T15:22:04.025+00:00: Namibia
2023-12-06T15:22:04.167+00:00: Mauritania
2023-12-06T15:22:04.195+00:00: Vanuatu
2023-12-06T15:22:04.239+00:00: Sri Lanka
2023-12-06T15:22:04.244+00:00: Guernsey
2023-12-06T15:22:04.260+00:00: Indonesia
2023-12-06T15:22:04.419+00:00: Macao
2023-12-06T15:22:04.609+00:00: Marshall Islands
2023-12-06T15:22:04.684+00:00: Greenland
2023-12-06T15:22:04.721+00:00: Denmark
2023-12-06T15:22:04.752+00:00: Indonesia
...
```
> **Note** No spinner sequences will not get to the output file. But spinner will be visible in the terminal.
