# Service hierarchy

```mermaid
classDiagram
    direction TB
    Facade ..> IContainerFactory
    Facade ..> IConfigBuilder
    Facade ..> ISpinnerFactory
    Facade ..> ILoopFactory
    Facade ..> ILoopSetup
   

    class Facade {
        +getConfigBuilder() IConfigBuilder
        +getLoop() ILoopAdapter
        +createSpinner(IConfig $config = null) ISpinner
        +replaceService(string $id, object|callable|string $service) void
    }
    
    IContainerFactory ..> IContainer
    
    IContainer ..> IServiceSpawner

    ISpinnerFactory ..> ISpinnerBuilder
    ISpinnerFactory ..> ISpinnerSetup

    ILoopSetup ..> ILoopAdapter

    ISpinnerSetup ..> ISpinnerAttacher

    class ISpinnerFactory {
        +createSpinner(IConfig $config) ISpinner
    }
    
    IConfigBuilder ..> IDefaultsProvider
    
    class IConfigBuilder {
        +getDefaultsProvider() IDefaultsProvider
    }
    
    ILoopFactory ..> ILoopProbeFactory

    class ILoopFactory {
        +getLoop() ILoopAdapter
    }
    
    ISpinnerBuilder ..> IDriverBuilder
    ISpinnerBuilder ..> IWidgetBuilder

    IDriverBuilder ..> ITimerBuilder
    IDriverBuilder ..> IOutputBuilder
    IDriverBuilder ..> ICursorBuilder

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
