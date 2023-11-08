[⬅️ to README.md](../README.md)

[⬅️ to limitations.md](limitations.md)

### Event loop auto start feature

- Autostart feature interferes with error handling:
  - If you have custom error handler (e.g. `NunoMaduro\Collision\Provider` is registered) in case of error(exception) 
the event loop will be started anyway (see `[889ad594-ca28-4770-bb38-fd5bd8cb1777]` code comment).
- Autostart feature for ReactPHP event loop CAN NOT be disabled.

### Docker
- Usage inside docker containers:
  - To run your application with `docker-compose exec` use `-T` option (or `tty: true` for your app service 
in `docker-compose.yml`) to disable pseudo-tty allocation.
  - To run daemon-like applications you should disable spinner entirely to not mess-up docker logs.
