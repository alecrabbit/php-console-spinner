[⬅️ to README.md](../README.md)
# Development

### Requirements

To use this repository development environment you should have:

- docker
- docker-compose standalone (currently docker compose plugin is not supported)
- make

### 1. Clone repository
> **Note** This repository got quite big, consider using `--depth` option
> ```bash
> git clone --depth=10 <repo_url>
> ```
```bash
git clone <repo_url>
```

### 2. Install [`DAM`](https://github.com/alecrabbit/dev-app-makefile) tool

After cloning the repository run `make` to see help message.
It could be something like this:
```bash
$ make
DAM tool help:

  make install_dam_tool - install DAM tool

```
Execute `make install_dam_tool` to install `DAM` tool.

### 3. Initialize the project

```bash
$ make init
```

This command will:
- generate `docker-stack.yml` file (aka compiled `docker-compose.yml` file)
- pull necessary docker image(s)
- build docker container(s)
- run docker container(s)
- install dependencies
- _[optional]_ run tests 

If tests are not executed automatically, you can run them manually:
```bash
make test && make test_coverage
```
> **Note** `make test` and `make test_coverage` commands can be unavailable. It depends on the project.

### 4. Available commands
To see available commands run:
```bash
make
```
or
```bash
make help
```
