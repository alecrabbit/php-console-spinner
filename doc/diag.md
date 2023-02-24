```mermaid
flowchart TD
    subgraph DefaultsFactory
    df1["::create()"]-->df2([IDefaults])
    end
    subgraph Factory
    sf1["::createSpinner()"]-->sf2([ISpinner])
    sf3["::getConfigBuilder()"]-->sf4([IConfigBuilder])
    end
    subgraph WidgetFactory
    wf1["::getWidgetBuilder()"]-->wf2([IWidgetBuilder])
    wf3["::getWidgetRevolverBuilder()"]-->wf4([IWidgetRevolverBuilder])
    end
```

DefaultsFactory

Factory (ConfigBuilder)

WidgetFactory (WidgetBuilder, WidgetRevolverBuilder)

### Arrows samples
|    Type    |  Description  |
|:----------:|:-------------:|
| <&#124;--  |  Inheritance  |                         
|    *--	    |  Composition  |
|    o--	    |  Aggregation  |
|    -->	    |  Association  |
|    --	     | Link (Solid)  |
|    ..>	    |  Dependency   |
| ..&#124;>	 |  Realization  |
|    ..	     | Link (Dashed) |

```mermaid
classDiagram
direction LR
%% Inheritance
classA <|-- classB 
%% Composition
classC *-- classD
%% Aggregation
classE o-- classF
%% Association
classG <-- classH
%% Link (Solid)
classI -- classJ
%% Dependency
classK <.. classL
%% Realization
classM <|.. classN
%% Link (Dashed)
classO .. classP
```