# Probes

## Registering probe
To register a probe, use the following code:
```php
Probes::register(CustomProbe::class); 
```

> `CustomProbe` class must be a subclass of `IStaticProbe` class.

## Loading all probes

```php
$probes = Probes::load(); // Traversable<class-string<IStaticProbe>>
```
> Note that this method returns a `\Generator`.

## Loading probe of a specific subclass

To load a specific probes subclass, use the following code:

```php
$probe = Probes::load(ILoopProbe::class); // Traversable<class-string<ILoopProbe>>
```
> `ILoopProbe` must be a subclass of `IStaticProbe` class.

## Unregistering probe

To unregister a probe, use the following code:

```php
Probes::unregister(CustomProbe::class);
```
> - `CustomProbe` class must be a subclass of `IStaticProbe` interface.
> - The probe class to unregister should be a specific class(registered earlier), e.g. `RevoltLoopProbe::class`
> - The probe must be unregistered before loading probes (`Probes::load()` method call).
> - Unregistering a probe that is not registered will have no effect.
