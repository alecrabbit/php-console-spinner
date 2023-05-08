[⬅️ to README.md](../README.md)

[⬅️ to limitations.md](limitations.md)

- Event loop autostart feature interferes with error handling.
  - If you have custom error handler (e.g. `NunoMaduro\Collision\Provider` is registered) in case of error the event loop will be started anyway (see _[889ad594-ca28-4770-bb38-fd5bd8cb1777]_ code comment).
- Autostart feature for ReactPHP event loop can not be disabled. 
- Usage inside docker containers:
  - If you use `docker-compose exec` to run your application use `-T` option to disable pseudo-tty allocation.
  - To run daemon-like applications you should disable spinner entirely to not mess-up docker logs.
