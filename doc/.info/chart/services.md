# Service "hierarchy"

```mermaid
classDiagram
    direction TB
    Facade ..> IContainerFactory
    Facade ..> ISettingsProvider
    Facade ..> ILoopFactory
    Facade ..> IDriverFactory
    Facade ..> ISpinnerFactory
   

    class Facade {
        +createSpinner() ISpinner
        +getDriver() IDriver
        +getLoop() ILoop
        +getSettingsProvider() ISettingsProvider
    }  
    
    class DefinitionRegistry {
        +bind() void
    }
    
    IContainerFactory ..> IContainer
    
    class ILoopFactory {
        +getLoop() ILoop
    }
    
    class ISpinnerFactory {
        +createSpinner() ISpinner
    }   
    
    class IDriverFactory {
        +getDriver() IDriver
    }


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
    IDriverFactory ..> IDriverBuilder
    IDriverFactory ..> ISequenceStateWriterFactory
    IDriverFactory ..> ITimerFactory
    IDriverFactory ..> IDriverSetup
    IDriverFactory ..> ILinkerSettings
    IDriverFactory ..> ISignalHandlingSetupFactory
    
    IDriverBuilder ..> IIntervalFactory
    
    ISignalHandlingSetupFactory ..> ISettingsProvider
    ISignalHandlingSetupFactory ..> ILoopFactory
    ISignalHandlingSetupFactory ..> ISignalHandlingSetupBuilder
    
    ISequenceStateWriterFactory ..> ISequenceStateWriterBuilder
    ISequenceStateWriterFactory ..> IBufferedOutputSingletonFactory
    ISequenceStateWriterFactory ..> IConsoleCursorFactory

    ITimerFactory ..> ITimerBuilder
    
    IDriverSetup ..> IDriverLinker
    
    IDriverLinker ..> ILoop
    IDriverLinker ..> OptionLinker

    ILoopFactory ..> ILoopProbeFactory

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
