# 'Spinner' => ASpinner::class

```mermaid
classDiagram
direction LR
Spinner ..|> ISpinner
Spinner --* IDriver
Spinner --* ITimer
Spinner --* IWidgetComposite
```