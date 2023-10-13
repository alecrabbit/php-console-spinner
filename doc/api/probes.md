# Probes

## Registering probe
To register a probe, use the following code:
```php
Probes::register(CustomProbe::class); 
```

> `CustomProbe` class must be a subclass of `IStaticProbe` interface.

## Unregistering probe

To unregister a probe, use the following code:

```php
Probes::unregister(CustomProbe::class);
```
> - The probe class to unregister should be a specific class(registered earlier), e.g. `RevoltLoopProbe::class`.
> - The probe must be unregistered before loading probes (`Probes::load()` method call).
> - Unregistering a probe that is not registered will have no effect.
> - `CustomProbe` class must be a subclass of `IStaticProbe` interface.

## Loading all probes (internal)

```php
$probes = Probes::load(); // Traversable<class-string<IStaticProbe>>
```
> Note that this method returns a `\Generator`.

## Loading probe of a specific subclass (internal)

To load a specific probes subclass, use the following code:

```php
$probe = Probes::load(CustomProbe::class); // Traversable<class-string<ILoopProbe>>
```
> - Probes are loaded in the reverse order of registration.
> - `CustomProbe` class must be a subclass of `IStaticProbe` interface.
