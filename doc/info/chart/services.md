# Service "hierarchy"

```mermaid
classDiagram
    direction TB
    Facade ..> IContainerFactory
    Facade ..> IConfigBuilder
    Facade ..> IDriverFactory
    Facade ..> ILoopFactory
   

    class Facade {
        +getConfigBuilder() IConfigBuilder
        +getLoop() ILoop
        +createDriver() IDriver
        +replaceService(string $id, object|callable|string $service) void
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
```
```mermaid
classDiagram
    direction TB
    IWidgetBuilder ..> IWidgetRevolverBuilder

    IWidgetRevolverBuilder ..> IFrameRevolverBuilder

    IFrameRevolverBuilder ..> IStyleFrameCollectionRenderer
    IFrameRevolverBuilder ..> ICharFrameCollectionRenderer
    IFrameRevolverBuilder ..> IIntervalFactory

    IIntervalFactory ..> IIntervalNormalizer
    IIntervalFactory .. Interval

    IIntervalNormalizer ..> IIntegerNormalizer

    IStyleFrameCollectionRenderer ..> IStyleFrameRenderer

    ICharFrameCollectionRenderer ..> ICharFrameRenderer

    IStyleFrameRenderer ..> IAnsiStyleConverter
    IStyleFrameRenderer ..> ISequencer
    IStyleFrameRenderer ..> IFrameFactory
    
    ICharFrameRenderer ..> IFrameFactory

    IAnsiStyleConverter ..> OptionStyleMode

    IFrameFactory ..> IWidthMeasurer


```

ProceduralFrameRevolverBuilder ..> StyleFrameCollectionRenderer

ProceduralFrameRevolverBuilder ..> CharFrameCollectionRenderer

ProceduralFrameRevolverBuilder ..> IntervalFactory
