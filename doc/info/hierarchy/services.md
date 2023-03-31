# Hierarchy

```mermaid
classDiagram
    direction TB
    Facade --> SpinnerFactory
    Facade --> ConfigBuilder
    Facade --> LoopFactory

    SpinnerFactory --> SpinnerBuilder

    ConfigBuilder --> IDefaultsProvider

    LoopFactory --> ILoopProbeFactory
    
    SpinnerBuilder --> DriverBuilder
    SpinnerBuilder --> WidgetBuilder
    
    WidgetBuilder --> WidgetRevolverBuilder
    WidgetBuilder --> RevolverFactory
    
```
