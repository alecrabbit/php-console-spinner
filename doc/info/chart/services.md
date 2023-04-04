# Hierarchy

```mermaid
classDiagram
    direction TB
    Facade ..> IContainerFactory
    Facade ..> IConfigBuilder
    Facade ..> ISpinnerFactory
    Facade ..> ILoopFactory

    class Facade {
        +getContainer() IContainer
        +getConfigBuilder() IConfigBuilder
        +getLoop() ILoopAdapter
        +createSpinner(IConfig $config = null) ISpinner
    }
    
    IContainerFactory ..> IContainer

    class IContainerFactory {
        +getContainer() IContainer
    }
    
    IContainer ..> ServiceSpawner

    ISpinnerFactory ..> ISpinnerBuilder

    class ISpinnerFactory {
        +createSpinner(IConfig $config = null) ISpinner
    }
    
    IConfigBuilder ..> IDefaultsProvider
    
    class IConfigBuilder {
        +getDefaultsProvider() IDefaultsProvider
    }
    
    ILoopFactory ..> ILoopProbeFactory

    class ILoopFactory {
        +getLoop() ILoopAdapter
    }
    
    ISpinnerBuilder ..> DriverBuilder
    ISpinnerBuilder ..> WidgetBuilder

    DriverBuilder ..> TimerBuilder
    DriverBuilder ..> OutputBuilder
    DriverBuilder ..> CursorBuilder

    WidgetBuilder ..> WidgetRevolverBuilder

    WidgetRevolverBuilder ..> FrameRevolverBuilder

    FrameRevolverBuilder ..> StyleFrameCollectionRenderer
    FrameRevolverBuilder ..> CharFrameCollectionRenderer
    FrameRevolverBuilder ..> IntervalFactory

    IntervalFactory ..> IntervalNormalizer
    IntervalFactory .. Interval

    IntervalNormalizer ..> IntegerNormalizer

    StyleFrameCollectionRenderer ..> StyleFrameRenderer

    CharFrameCollectionRenderer ..> CharFrameRenderer

    StyleFrameRenderer ..> AnsiStyleConverter
    StyleFrameRenderer ..> Sequencer
    StyleFrameRenderer ..> FrameFactory
    
    CharFrameRenderer ..> FrameFactory

    AnsiStyleConverter ..> OptionStyleMode

    FrameFactory ..> WidthMeasurer


```

ProceduralFrameRevolverBuilder ..> StyleFrameCollectionRenderer

ProceduralFrameRevolverBuilder ..> CharFrameCollectionRenderer

ProceduralFrameRevolverBuilder ..> IntervalFactory
