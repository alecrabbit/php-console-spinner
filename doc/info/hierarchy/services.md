# Hierarchy

```mermaid
classDiagram
    direction TB
    Facade --> SpinnerFactory
    Facade --> ConfigBuilder
    Facade --> LoopFactory
    class Facade{
        +getConfigBuilder()
        +getLoop()
        +createSpinner(IConfig $config = null)
    }
    
    SpinnerFactory --> SpinnerBuilder

    ConfigBuilder --> DefaultsProvider

    LoopFactory --> LoopProbeFactory
    
    SpinnerBuilder --> DriverBuilder
    SpinnerBuilder --> WidgetBuilder
    
    WidgetBuilder --> WidgetRevolverBuilder
    WidgetBuilder --> RevolverFactory
    
```
