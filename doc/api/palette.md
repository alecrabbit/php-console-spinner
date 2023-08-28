# Palette
> ** Note ** This file describes tentative api

### Registering a palette

To register a palette, use the following code:

```php
Palettes::register(Rainbow::class);
```
Signature:
```php
Palettes::register(string $paletteClass, ?string $label = null): void
```

> To render a palette to pattern:
> 
> ```php
> $pattern = $paletterRenderer->render(Rainbow::class, $parameters);
> ```
