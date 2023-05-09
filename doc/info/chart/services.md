# Service "hierarchy"

```mermaid
classDiagram
    direction TB
    Facade ..> IContainerFactory
    Facade ..> IConfigBuilder
    Facade ..> IDriverFactory
    Facade ..> ISpinnerFactory
    Facade ..> IDriverLinker
    Facade ..> ILoopFactory
   

    class Facade {
        +getSettingsProvider() ISettingsProvider
        +getLoop() ILoop
        +createDriver() IDriver
        +useService(string $id, object|callable|string $service) void
    }
    
    IContainerFactory ..> IContainer
    
    IContainer ..> IServiceSpawner

    IDriverFactory ..> IDriverBuilder
    IDriverFactory ..> IDriverOutputFactory
    IDriverFactory ..> ITimerFactory
    IDriverFactory ..> IDriverSetup
    
    class IDriverFactory {
        +create() IDriver
    }
    
    IDriverOutputFactory ..> IDriverOutputBuilder
    IDriverOutputFactory ..> IBufferedOutputSingletonFactory
    IDriverOutputFactory ..> IConsoleCursorFactory
    
    IDriverBuilder ..> IIntervalFactory
    
    IConsoleCursorFactory ..> IBufferedOutputSingletonFactory
    IConsoleCursorFactory ..> IConsoleCursorBuilder
    
    ITimerFactory ..> ITimerBuilder
    
    IDriverSetup ..> IDriverLinker
    
    ILoopSetup ..> ILoop

    IConfigBuilder ..> ISettingsProvider
    
    class IConfigBuilder {
        +getSettingsProvider() ISettingsProvider
    }
    
    ILoopFactory ..> ILoopProbeFactory
    ILoopFactory ..> ILoopSetupBuilder
    
    ILoopProbeFactory ..> `ILoopProbe[]`
    
    ILoopSetupBuilder ..> ILoopSetup

    class ILoopFactory {
        +getLoop() ILoop
    }

    IIntervalFactory ..> IIntervalNormalizer
    IIntervalFactory .. Interval

    IIntervalNormalizer ..> IIntegerNormalizer
```
```mermaid
classDiagram
    direction TB
    ISpinnerFactory ..> ISettingsProvider
    ISpinnerFactory ..> IWidgetFactory
    ISpinnerFactory ..> IWidgetSettingsFactory

    IWidgetSettingsFactory ..> ISettingsProvider
    IWidgetSettingsFactory ..> IWidgetSettingsBuilder 
    
    IWidgetFactory ..> IWidgetBuilder
    IWidgetFactory ..> IWidgetRevolverFactory

    IWidgetRevolverFactory ..> IWidgetRevolverBuilder
    IWidgetRevolverFactory ..> IStyleFrameRevolverFactory
    IWidgetRevolverFactory ..> ICharFrameRevolverFactory
    
    IStyleFrameRevolverFactory ..> IFrameRevolverBuilder
    IStyleFrameRevolverFactory ..> IFrameCollectionFactory
    IStyleFrameRevolverFactory ..> IIntervalFactory
    IStyleFrameRevolverFactory ..> OptionStyleMode
    
    ICharFrameRevolverFactory ..> IFrameRevolverBuilder
    ICharFrameRevolverFactory ..> IFrameCollectionFactory
    ICharFrameRevolverFactory ..> IIntervalFactory
    
    IIntervalFactory ..> IIntervalNormalizer



```
```mermaid
classDiagram
    direction TB
    IIntegerNormalizerFactory ..> IIntegerNormalizerBuilder
    IIntegerNormalizerFactory ..> OptionNormalizerMode
```

ProceduralFrameRevolverBuilder ..> StyleFrameCollectionRenderer

ProceduralFrameRevolverBuilder ..> CharFrameCollectionRenderer

ProceduralFrameRevolverBuilder ..> IntervalFactory
