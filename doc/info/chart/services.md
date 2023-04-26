# Service "hierarchy"

```mermaid
classDiagram
    direction TB
    Facade ..> IContainerFactory
    Facade ..> IConfigBuilder
    Facade ..> IDriverFactory
    Facade ..> ISpinnerFactory
    Facade ..> IDriverAttacher
    Facade ..> ILoopFactory
   

    class Facade {
        +getDefaultsProvider() IDefaultsProvider
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
    
    IDriverSetup ..> IDriverAttacher
    
    ILoopSetup ..> ILoop

    IConfigBuilder ..> IDefaultsProvider
    
    class IConfigBuilder {
        +getDefaultsProvider() IDefaultsProvider
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
    ISpinnerFactory ..> IWidgetFactory
    ISpinnerFactory ..> IDefaultsProvider

    IWidgetFactory ..> IWidgetBuilder
    IWidgetFactory ..> IWidgetRevolverFactory

    IWidgetRevolverFactory ..> IWidgetRevolverBuilder
    IWidgetRevolverFactory ..> IStyleRevolverFactory
    IWidgetRevolverFactory ..> ICharRevolverFactory

    IStyleRevolverFactory ..> IFrameRevolverBuilder
    IStyleRevolverFactory ..> IStyleFrameCollectionRenderer

    ICharRevolverFactory ..> IFrameRevolverBuilder
    ICharRevolverFactory ..> ICharFrameCollectionRenderer

    IStyleFrameCollectionRenderer ..> IStyleFrameRenderer

    ICharFrameCollectionRenderer ..> ICharFrameRenderer

    IStyleFrameRenderer ..> IAnsiStyleConverter
    IStyleFrameRenderer ..> ISequencer
    IStyleFrameRenderer ..> IFrameFactory

    ICharFrameRenderer ..> IFrameFactory

    IAnsiStyleConverter ..> OptionStyleMode

    IFrameFactory ..> IWidthMeasurer


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
