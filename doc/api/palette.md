# Palette

### Registering a palette

To register a palette, use the following code:

```php
Palettes::register(Rainbow::class);
```

> To render a palette to pattern we:
> (tentative)
> ```php
> $pattern = $renderer->render(Rainbow::class, $parameters);
> ```
