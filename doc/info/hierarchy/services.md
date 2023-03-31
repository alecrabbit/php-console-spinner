# Hierarchy

```mermaid
classDiagram
    direction LR
    Facade --> SpinnerFactory
    Facade --> ConfigBuilder
    Facade --> LoopFactory

    SpinnerFactory --> SpinnerBuilder

    ConfigBuilder --> IDefaultsProvider

    LoopFactory --> ILoopProbeFactory
    
    SpinnerBuilder --> DriverBuilder
    SpinnerBuilder --> WidgetBuilder
```
