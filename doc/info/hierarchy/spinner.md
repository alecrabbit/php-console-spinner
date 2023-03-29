# 'Spinner' => ASpinner::class

```mermaid
classDiagram
direction LR
Spinner ..|> ISpinner
Spinner --* IDriver
Spinner --* IWidgetComposite
```

```mermaid
classDiagram
direction LR
Facade ..|> ISpinner
Spinner --* IDriver
Spinner --* IWidgetComposite
```