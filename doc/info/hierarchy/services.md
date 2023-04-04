# Hierarchy

```mermaid
classDiagram
    direction TB
    Facade ..> ContainerFactory
    Facade ..> ConfigBuilder
    Facade ..> SpinnerFactory
    Facade ..> LoopFactory
    
    ContainerFactory ..> Container
    
    Container ..> ServiceSpawner
    
    class Facade {
        +getContainer()
        +getConfigBuilder()
        +getLoop()
        +createSpinner(IConfig $config = null)
    }
    
    SpinnerFactory ..> SpinnerBuilder

    ConfigBuilder ..> DefaultsProvider

    LoopFactory ..> LoopProbeFactory
    
    SpinnerBuilder ..> DriverBuilder
    SpinnerBuilder ..> WidgetBuilder
    
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
    StyleFrameCollectionRenderer ..> FrameFactory
    
    CharFrameCollectionRenderer ..> FrameFactory
    
    StyleFrameRenderer ..> AnsiStyleConverter
    StyleFrameRenderer ..> Sequencer
    StyleFrameRenderer ..> FrameFactory
    
    AnsiStyleConverter ..> OptionStyleMode
    
    FrameFactory ..> WidthMeasurer
   
    
```

ProceduralFrameRevolverBuilder ..> StyleFrameCollectionRenderer

ProceduralFrameRevolverBuilder ..> CharFrameCollectionRenderer

ProceduralFrameRevolverBuilder ..> IntervalFactory
