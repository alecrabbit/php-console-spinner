# Hierarchy

```mermaid
classDiagram
    direction LR
    Facade ..|> IFacade
    Facade --> SpinnerFactory
    Facade --> ConfigBuilder
    Facade --> LoopFactory


    SpinnerFactory ..|> ISpinnerFactory
    SpinnerFactory --> SpinnerBuilder

    ConfigBuilder ..|> IConfigBuilder
    ConfigBuilder --> IDefaultsProvider
    
    SpinnerBuilder ..|> ISpinnerBuilder
    SpinnerBuilder --> DriverBuilder
    SpinnerBuilder --> WidgetBuilder
```
