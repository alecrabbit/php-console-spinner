### Probes

#### Registering Probe

```php
Probes::register(CustomProbe::class); 
```

> `CustomProbe` class must be a subclass of `IStaticProbe` class.

#### Loading all probes

```php
$probes = Probes::load(); // Traversable<class-string<IStaticProbe>>
```
> Note that method returns `\Generator`.

#### Loading specific probe

```php
$probe = Probes::load(ILoopProbe::class); // Traversable<class-string<ILoopProbe>>
```

#### Unregistering probe

```php
Probes::unregister(CustomProbe::class);
```
> `CustomProbe` class must be a subclass of `IStaticProbe` class.
> Probe class to unregister must be specific class.
> Probe must be unregistered before loading probes.
