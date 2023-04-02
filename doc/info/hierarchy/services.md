# Hierarchy

```mermaid
classDiagram
    direction TB
    Facade ..> ContainerFactory
    Facade ..> ConfigBuilder
    Facade ..> SpinnerFactory
    Facade ..> LoopFactory
    
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
    
    WidgetBuilder ..> WidgetRevolverBuilder
    
    WidgetRevolverBuilder ..> RevolverFactory
    
    RevolverFactory ..> FrameRevolverBuilder
    RevolverFactory ..> FrameFactory
    
    FrameRevolverBuilder ..> StyleFrameCollectionRenderer
    FrameRevolverBuilder ..> CharFrameCollectionRenderer
    FrameRevolverBuilder ..> IntervalFactory
    
    IntervalFactory ..> DefaultsProvider
    IntervalFactory ..> IntervalNormalizer
    
    IntervalNormalizer ..> NormalizerMode
    
    StyleFrameCollectionRenderer ..> StyleFrameRenderer
    StyleFrameCollectionRenderer ..> FrameFactory
    
    CharFrameCollectionRenderer ..> FrameFactory
    
    StyleFrameRenderer ..> AnsiStyleConverter
    StyleFrameRenderer ..> Sequencer
    StyleFrameRenderer ..> FrameFactory
    
    AnsiStyleConverter ..> OptionStyleMode
    
    
```
