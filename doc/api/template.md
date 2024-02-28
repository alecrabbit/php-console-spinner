# Template (aka Pattern)
> ** Note ** Expected to be renamed to `Pattern`

> ** Note ** This file describes tentative api

```php
class Template implements ITemplate
{
    public function getInterval(): IInterval
    {
        // ...
    }

    public function getFrames(): Traversable;
    {
        // ...
    }
}
```

If pattern argument for revolver creation is an instance of `ITemplate` then `IFrameCollection` will be created from it.
